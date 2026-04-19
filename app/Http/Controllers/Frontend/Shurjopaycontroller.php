<?php
// ══════════════════════════════════════════════════════════════════════
// app/Http/Controllers/Frontend/ShurjopayController.php
// ShurjoPay Payment Gateway Integration (REST API)
// ══════════════════════════════════════════════════════════════════════

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shurjopay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShurjopayController extends Controller
{
    private ?Shurjopay $config = null;

    private function getConfig(): ?Shurjopay
    {
        if (!$this->config) {
            $this->config = Shurjopay::first();
        }
        return $this->config;
    }

    // ══════════════════════════════════════════════════════════════════
    //  STEP 1 — Get Token from ShurjoPay
    // ══════════════════════════════════════════════════════════════════
    private function getToken(): ?array
    {
        $cfg = $this->getConfig();
        if (!$cfg) return null;

        $url = rtrim($cfg->base_url, '/') . '/api/get_token';

        try {
            $response = Http::timeout(30)
                ->asForm()
                ->post($url, [
                    'username' => $cfg->username,
                    'password' => $cfg->password,
                ]);

            $data = $response->json();

            if (!empty($data['token'])) {
                return $data; // Contains: token, store_id, execute_url, token_type, sp_code, message
            }

            Log::error('ShurjoPay getToken failed', $data ?? []);
            return null;

        } catch (\Throwable $e) {
            Log::error('ShurjoPay getToken exception: ' . $e->getMessage());
            return null;
        }
    }

    // ══════════════════════════════════════════════════════════════════
    //  STEP 2 — Initiate Payment (redirect user to ShurjoPay)
    //  Called by CheckoutController::redirectToShurjopay()
    // ══════════════════════════════════════════════════════════════════
    public function initiatePayment()
    {
        $cfg = $this->getConfig();

        if (!$cfg || !$cfg->status) {
            return redirect()->route('checkout.index')
                ->with('error', 'ShurjoPay এখন পাওয়া যাচ্ছে না।');
        }

        $pending = session('pending_order');
        if (!$pending) {
            return redirect()->route('checkout.index')
                ->with('error', 'Session expired. পুনরায় চেষ্টা করুন।');
        }

        $tokenData = $this->getToken();
        if (!$tokenData) {
            return redirect()->route('checkout.index')
                ->with('error', 'ShurjoPay authentication failed.');
        }

        $orderId = ($cfg->prefix ?? 'SP') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
        session(['sp_order_id' => $orderId]);

        $successUrl = $cfg->success_url ?: route('shurjopay.callback');
        $returnUrl  = $cfg->return_url  ?: route('shurjopay.callback');
        $executeUrl = rtrim($cfg->base_url, '/') . '/api/secret-pay';

        $payload = [
            'prefix'          => $cfg->prefix ?? 'SP',
            'token'           => $tokenData['token'],
            'store_id'        => $tokenData['store_id'],
            'return_url'      => $successUrl,
            'cancel_url'      => $returnUrl,
            'amount'          => number_format((float) $pending['total'], 2, '.', ''),
            'order_id'        => $orderId,
            'currency'        => 'BDT',
            'customer_name'   => $pending['customer_name'],
            'customer_address'=> $pending['address'],
            'customer_phone'  => $pending['phone'],
            'customer_city'   => $pending['delivery_area'],
            'customer_post_code' => '1000',
            'client_ip'       => request()->ip(),
        ];

        try {
            $response = Http::timeout(30)
                ->withToken($tokenData['token'])
                ->asForm()
                ->post($executeUrl, $payload);

            $data = $response->json();

            if (!empty($data['checkout_url'])) {
                // Store token for verification
                session(['sp_token'    => $tokenData['token']]);
                session(['sp_store_id' => $tokenData['store_id']]);

                return redirect()->away($data['checkout_url']);
            }

            Log::error('ShurjoPay initiate failed', $data ?? []);
            return redirect()->route('checkout.index')
                ->with('error', 'ShurjoPay payment initiate করতে সমস্যা হয়েছে: ' . ($data['message'] ?? 'Unknown'));

        } catch (\Throwable $e) {
            Log::error('ShurjoPay initiate exception: ' . $e->getMessage());
            return redirect()->route('checkout.index')
                ->with('error', 'সার্ভার সমস্যা। আবার চেষ্টা করুন।');
        }
    }

    // ══════════════════════════════════════════════════════════════════
    //  STEP 3 — Callback / Verify Payment
    // ══════════════════════════════════════════════════════════════════
    public function callback(Request $request)
    {
        $orderId = $request->get('order_id') ?? session('sp_order_id');

        if (!$orderId) {
            return redirect()->route('checkout.index')
                ->with('error', 'Payment information পাওয়া যায়নি।');
        }

        $cfg = $this->getConfig();
        if (!$cfg) {
            return redirect()->route('checkout.index')
                ->with('error', 'শুর্জোপে কনফিগ পাওয়া যায়নি।');
        }

        // ── Verify via ShurjoPay API ──────────────────────────────
        $tokenData = $this->getToken();
        if (!$tokenData) {
            return redirect()->route('checkout.index')
                ->with('error', 'Payment verify করা যায়নি (token error)।');
        }

        $verifyUrl = rtrim($cfg->base_url, '/') . '/api/verification';

        try {
            $response = Http::timeout(30)
                ->withToken($tokenData['token'])
                ->asForm()
                ->post($verifyUrl, [
                    'order_id' => $orderId,
                    'store_id' => $tokenData['store_id'],
                ]);

            $verifications = $response->json();

            // ShurjoPay returns an array; get first element
            $data = is_array($verifications) ? ($verifications[0] ?? []) : $verifications;

            $spCode = $data['sp_code'] ?? null;

            // sp_code 1000 = success
            if ($spCode == '1000') {
                $trxId = $data['bank_trx_id'] ?? ($data['sp_transaction_id'] ?? $orderId);
                return $this->placeOrderAfterPayment($trxId, $orderId);
            }

            // sp_code 1002 = cancelled
            if ($spCode == '1002') {
                return redirect()->route('checkout.index')
                    ->with('error', 'ShurjoPay পেমেন্ট বাতিল করা হয়েছে।');
            }

            Log::error('ShurjoPay verify failed', $data);
            return redirect()->route('checkout.index')
                ->with('error', 'ShurjoPay পেমেন্ট verify ব্যর্থ: ' . ($data['message'] ?? 'Unknown'));

        } catch (\Throwable $e) {
            Log::error('ShurjoPay verify exception: ' . $e->getMessage());
            return redirect()->route('checkout.index')
                ->with('error', 'Payment verify করতে সমস্যা হয়েছে।');
        }
    }

    // ══════════════════════════════════════════════════════════════════
    //  PLACE ORDER after successful ShurjoPay payment
    // ══════════════════════════════════════════════════════════════════
    private function placeOrderAfterPayment(string $trxId, string $spOrderId)
    {
        $pending   = session('pending_order');
        $cartItems = session()->get('cart', []);

        if (!$pending || empty($cartItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'Session expired. TrxID: ' . $trxId . ' — আমাদের সাথে যোগাযোগ করুন।');
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
                'payment_method' => 'shurjopay',
                'payment_status' => 'paid',
                'transaction_id' => $trxId,
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

            $couponId = $pending['coupon_id'] ?? null;
            if ($couponId) {
                Coupon::where('id', $couponId)->increment('used');
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order create after ShurjoPay failed: ' . $e->getMessage());
            return redirect()->route('checkout.index')
                ->with('error', 'Payment সফল কিন্তু অর্ডার save করতে সমস্যা। TrxID: ' . $trxId . ' — আমাদের সাথে যোগাযোগ করুন।');
        }

        session()->forget(['cart', 'coupon_code', 'coupon_discount', 'coupon_id',
                           'pending_order', 'sp_token', 'sp_store_id', 'sp_order_id']);

        return redirect()->route('order.success', $order->order_number)
            ->with('success', 'ShurjoPay পেমেন্ট সফল হয়েছে! অর্ডার confirm হয়েছে।');
    }
}
