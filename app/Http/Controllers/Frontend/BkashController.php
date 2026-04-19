<?php
// ══════════════════════════════════════════════════════════════════════
// app/Http/Controllers/Frontend/BkashController.php
// bKash Tokenized Checkout API v1.2.0-beta Integration
// ══════════════════════════════════════════════════════════════════════

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Bkash;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BkashController extends Controller
{
    private ?Bkash $config = null;

    // ── Load bKash config from DB ──────────────────────────────────────
    private function getConfig(): ?Bkash
    {
        if (!$this->config) {
            $this->config = Bkash::first();
        }
        return $this->config;
    }

    // ══════════════════════════════════════════════════════════════════
    //  STEP 1 — Grant Token (server-side, called by createPayment)
    // ══════════════════════════════════════════════════════════════════
    private function grantToken(): ?string
    {
        $cfg = $this->getConfig();
        if (!$cfg) return null;

        $url = rtrim($cfg->base_url, '/') . '/tokenized/checkout/token/grant';

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                    'username'     => $cfg->username,
                    'password'     => $cfg->password,
                ])
                ->post($url, [
                    'app_key'    => $cfg->app_key,
                    'app_secret' => $cfg->app_secret,
                ]);

            $data = $response->json();

            if (isset($data['id_token'])) {
                return $data['id_token'];
            }

            Log::error('bKash grantToken failed', $data);
            return null;

        } catch (\Throwable $e) {
            Log::error('bKash grantToken exception: ' . $e->getMessage());
            return null;
        }
    }

    // ══════════════════════════════════════════════════════════════════
    //  STEP 2 — Create Payment
    //  Called via AJAX from checkout page
    // ══════════════════════════════════════════════════════════════════
    public function createPayment(Request $request)
    {
        $cfg = $this->getConfig();

        if (!$cfg || !$cfg->status) {
            return response()->json(['error' => 'bKash এখন পাওয়া যাচ্ছে না।'], 422);
        }

        // ── Validate pending order data ────────────────────────────
        $pending = session('pending_order');
        if (!$pending) {
            return response()->json(['error' => 'Session expired. পুনরায় চেষ্টা করুন।'], 422);
        }

        $token = $this->grantToken();
        if (!$token) {
            return response()->json(['error' => 'bKash authentication failed.'], 500);
        }

        $invoiceNumber = 'INV-' . strtoupper(substr(md5(uniqid()), 0, 10));
        $amount        = number_format((float) $pending['total'], 2, '.', '');

        // Store invoice number in session for callback matching
        session(['bkash_invoice' => $invoiceNumber]);

        $callbackUrl = route('bkash.callback');
        $url         = rtrim($cfg->base_url, '/') . '/tokenized/checkout/create';

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                    'authorization' => $token,
                    'x-app-key'     => $cfg->app_key,
                ])
                ->post($url, [
                    'mode'                  => '0011',
                    'payerReference'        => $pending['phone'] ?? '01700000000',
                    'callbackURL'           => $callbackUrl,
                    'amount'                => $amount,
                    'currency'              => 'BDT',
                    'intent'                => 'sale',
                    'merchantInvoiceNumber' => $invoiceNumber,
                ]);

            $data = $response->json();

            if (isset($data['bkashURL'])) {
                // Store token temporarily for execute step
                session(['bkash_token'      => $token]);
                session(['bkash_payment_id' => $data['paymentID']]);

                return response()->json([
                    'bkashURL'  => $data['bkashURL'],
                    'paymentID' => $data['paymentID'],
                ]);
            }

            Log::error('bKash createPayment failed', $data);
            return response()->json([
                'error' => $data['statusMessage'] ?? 'Payment create করতে সমস্যা হয়েছে।',
            ], 422);

        } catch (\Throwable $e) {
            Log::error('bKash createPayment exception: ' . $e->getMessage());
            return response()->json(['error' => 'সার্ভার সমস্যা। আবার চেষ্টা করুন।'], 500);
        }
    }

    // ══════════════════════════════════════════════════════════════════
    //  STEP 3 — Callback (bKash redirects here after user completes)
    // ══════════════════════════════════════════════════════════════════
    public function callback(Request $request)
    {
        $status    = $request->get('status');
        $paymentID = $request->get('paymentID');

        if ($status === 'cancel') {
            return redirect()->route('checkout.index')
                ->with('error', 'আপনি bKash পেমেন্ট বাতিল করেছেন।');
        }

        if ($status === 'failure' || !$paymentID) {
            return redirect()->route('checkout.index')
                ->with('error', 'bKash পেমেন্ট ব্যর্থ হয়েছে। আবার চেষ্টা করুন।');
        }

        // ── Execute Payment ───────────────────────────────────────
        $cfg   = $this->getConfig();
        $token = session('bkash_token');

        if (!$cfg || !$token) {
            return redirect()->route('checkout.index')
                ->with('error', 'Session expired. আবার চেষ্টা করুন।');
        }

        $url = rtrim($cfg->base_url, '/') . '/tokenized/checkout/execute';

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                    'authorization' => $token,
                    'x-app-key'     => $cfg->app_key,
                ])
                ->post($url, ['paymentID' => $paymentID]);

            $data = $response->json();

            if (isset($data['trxID']) && $data['statusCode'] === '0000') {
                return $this->placeOrderAfterPayment(
                    $data['trxID'],
                    $data['amount'] ?? null,
                    'bkash'
                );
            }

            Log::error('bKash execute failed', $data);
            return redirect()->route('checkout.index')
                ->with('error', 'bKash পেমেন্ট verify করা যায়নি: ' . ($data['statusMessage'] ?? 'Unknown error'));

        } catch (\Throwable $e) {
            Log::error('bKash execute exception: ' . $e->getMessage());
            return redirect()->route('checkout.index')
                ->with('error', 'Payment verify করতে সমস্যা হয়েছে।');
        }
    }

    // ══════════════════════════════════════════════════════════════════
    //  PLACE ORDER after successful bKash payment
    // ══════════════════════════════════════════════════════════════════
    private function placeOrderAfterPayment(string $trxID, ?string $paidAmount, string $method)
    {
        $pending   = session('pending_order');
        $cartItems = session()->get('cart', []);

        if (!$pending || empty($cartItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'Session expired. অর্ডার সম্ভব হয়নি।');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number'   => Order::generateOrderNumber(),
                'user_id'        => Auth::id(),
                'customer_name'  => $pending['customer_name'],
                'phone'          => $pending['phone'],
                'address'        => $pending['address'],
                'delivery_area'  => $pending['delivery_area'],
                'note'           => $pending['note'] ?? null,
                'payment_method' => $method,
                'payment_status' => 'paid',
                'transaction_id' => $trxID,
                'order_status'   => 'processing',
                'subtotal'       => $pending['subtotal'],
                'discount'       => $pending['discount'],
                'delivery_fee'   => $pending['delivery_fee'],
                'total'          => $pending['total'],
                'coupon_code'    => $pending['coupon_code'] ?? null,
            ]);

            foreach ($cartItems as $cartKey => $item) {
                $productId = $item['product_id'] ?? $cartKey;
                $unitPrice = ($item['discount_price'] ?? null) ?: $item['price'];

                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $productId,
                    'product_name'   => $item['name'],
                    'product_image'  => $item['image'] ?? null,
                    'product_slug'   => $item['slug'] ?? null,
                    'price'          => $unitPrice,
                    'original_price' => $item['price'],
                    'quantity'       => $item['quantity'],
                    'subtotal'       => $unitPrice * $item['quantity'],
                    'selected_color' => $item['selected_color'] ?? null,
                    'selected_size'  => $item['selected_size']  ?? null,
                ]);

                $product = Product::find($productId);
                if ($product && !$product->is_unlimited && $product->stock !== null) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // Coupon used count
            $couponId = $pending['coupon_id'] ?? null;
            if ($couponId) {
                Coupon::where('id', $couponId)->increment('used');
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order create after payment failed: ' . $e->getMessage());
            return redirect()->route('checkout.index')
                ->with('error', 'Payment সফল কিন্তু অর্ডার save করতে সমস্যা হয়েছে। TrxID: ' . $trxID . ' — আমাদের সাথে যোগাযোগ করুন।');
        }

        // Clear sessions
        session()->forget(['cart', 'coupon_code', 'coupon_discount', 'coupon_id',
                           'pending_order', 'bkash_token', 'bkash_payment_id', 'bkash_invoice']);

        return redirect()->route('order.success', $order->order_number)
            ->with('success', 'আপনার bKash পেমেন্ট সফল হয়েছে! অর্ডার confirm হয়েছে।');
    }
}
