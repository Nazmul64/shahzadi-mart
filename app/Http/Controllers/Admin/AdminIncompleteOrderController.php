<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncompleteOrder;
use App\Models\PathaoOrder;
use App\Models\SteadfastOrder;
use App\Models\Pathaocourier;
use App\Models\Steadfastcourier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminIncompleteOrderController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    // INDEX
    // ══════════════════════════════════════════════════════════════
    public function index(Request $request)
    {
        $query  = IncompleteOrder::query();
        $status = $request->get('status', 'incomplete');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone',        'like', "%{$search}%")
                  ->orWhere('address',      'like', "%{$search}%");
            });
        }

        $orders = $query->orderByDesc('id')->paginate(20);

        $statusCounts = [
            'all'        => IncompleteOrder::count(),
            'incomplete' => IncompleteOrder::where('status', 'incomplete')->count(),
            'recovered'  => IncompleteOrder::where('status', 'recovered')->count(),
            'contacted'  => IncompleteOrder::where('status', 'contacted')->count(),
        ];

        return view('admin.incomplete_orders.index', compact('orders', 'statusCounts', 'status'));
    }

    // ══════════════════════════════════════════════════════════════
    // SHOW
    // ══════════════════════════════════════════════════════════════
    public function show(IncompleteOrder $incompleteOrder)
    {
        $sfOrder    = $incompleteOrder->steadfastOrder;
        $pathaoOrd  = $incompleteOrder->pathaoOrder;
        return view('admin.incomplete_orders.show', compact('incompleteOrder', 'sfOrder', 'pathaoOrd'));
    }

    // ══════════════════════════════════════════════════════════════
    // ALL ORDER (alternate view - tab/list)
    // ══════════════════════════════════════════════════════════════
    public function allorder(Request $request)
    {
        return $this->index($request);
    }

    // ══════════════════════════════════════════════════════════════
    // DESTROY (single)
    // ══════════════════════════════════════════════════════════════
    public function destroy(IncompleteOrder $incompleteOrder)
    {
        $incompleteOrder->delete();
        return back()->with('success', 'ইনকমপ্লিট অর্ডারটি মুছে ফেলা হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    // BULK DELETE
    // ══════════════════════════════════════════════════════════════
    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        IncompleteOrder::whereIn('id', $request->ids)->delete();
        return back()->with('success', count($request->ids) . 'টি ইনকমপ্লিট অর্ডার মুছে ফেলা হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    // MARK AS CONTACTED
    // ══════════════════════════════════════════════════════════════
    public function markContacted(IncompleteOrder $incompleteOrder)
    {
        $incompleteOrder->update(['status' => 'contacted']);
        return back()->with('success', 'Contacted হিসেবে mark করা হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    // MARK AS RECOVERED
    // ══════════════════════════════════════════════════════════════
    public function markRecovered(IncompleteOrder $incompleteOrder)
    {
        $incompleteOrder->update(['status' => 'recovered']);
        return back()->with('success', 'Recovered হিসেবে mark করা হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    // STATUS UPDATE (single, PATCH)
    // ══════════════════════════════════════════════════════════════
    public function updateStatus(Request $request, IncompleteOrder $incompleteOrder)
    {
        $request->validate(['status' => 'required|in:incomplete,contacted,recovered']);
        $incompleteOrder->update(['status' => $request->status]);
        return back()->with('success', 'স্ট্যাটাস আপডেট করা হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    // BULK STATUS UPDATE
    // ══════════════════════════════════════════════════════════════
    public function bulkStatus(Request $request)
    {
        $request->validate([
            'ids'    => 'required|array',
            'status' => 'required|in:incomplete,contacted,recovered',
        ]);
        IncompleteOrder::whereIn('id', $request->ids)->update(['status' => $request->status]);
        return back()->with('success', count($request->ids) . 'টি অর্ডারের স্ট্যাটাস আপডেট হয়েছে।');
    }

    // ══════════════════════════════════════════════════════════════
    // ── STEADFAST HELPERS ────────────────────────────────────────
    // ══════════════════════════════════════════════════════════════
    private function sfGetBaseUrl(Steadfastcourier $settings): string
    {
        $dbUrl = trim($settings->url ?? '');
        if (empty($dbUrl)) return 'https://portal.steadfast.com.bd/api/v1';

        $clean = trim(preg_replace('#/create_order.*$#i', '', $dbUrl));
        $clean = rtrim($clean, '/');

        if (!filter_var($clean, FILTER_VALIDATE_URL) || str_contains($clean, ' ')) {
            return 'https://portal.steadfast.com.bd/api/v1';
        }
        return $clean;
    }

    private function sfCallApi(string $apiKey, string $secretKey, array $payload, string $baseUrl): array
    {
        $url = rtrim($baseUrl, '/') . '/create_order';
        $ch  = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
            CURLOPT_HTTPHEADER     => [
                'Api-Key: '    . $apiKey,
                'Secret-Key: ' . $secretKey,
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);
        $body     = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno    = curl_errno($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        Log::info("[SF-Incomplete] API [{$url}]", [
            'http_code' => $httpCode,
            'payload'   => $payload,
            'response'  => substr((string)$body, 0, 800),
        ]);

        if ($errno) throw new \Exception("cURL ব্যর্থ [{$errno}]: {$error}");

        $data = json_decode((string)$body, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['code' => $httpCode, 'data' => ['message' => trim(strip_tags((string)$body))], 'error' => true];
        }
        return ['code' => $httpCode, 'data' => $data];
    }

    private function sfBuildPayload(IncompleteOrder $order): array
    {
        return [
            'invoice'           => (string) ($order->id . '-INC'),
            'recipient_name'    => (string) $order->customer_name,
            'recipient_phone'   => (string) $order->phone,
            'recipient_address' => (string) $order->address,
            'cod_amount'        => (float)  $order->total,
            'note'              => 'Incomplete Order Recovery',
        ];
    }

    private function sfSaveConsignment(IncompleteOrder $order, array $consignment, array $fullData): void
    {
        // IncompleteOrder এর জন্য আলাদা morph বা সরাসরি column ব্যবহার
        // SteadfastOrder model এ incomplete_order_id column থাকতে হবে
        // অথবা polymorphic relation ব্যবহার করতে পারো
        // এখানে সরাসরি SteadfastOrder তে save করছি incomplete_order_id দিয়ে
        \App\Models\SteadfastOrder::updateOrCreate(
            ['incomplete_order_id' => $order->id],
            [
                'order_id'         => null,
                'consignment_id'   => $consignment['consignment_id'],
                'invoice'          => $consignment['invoice']         ?? ($order->id . '-INC'),
                'tracking_code'    => $consignment['tracking_code']   ?? null,
                'tracking_link'    => $consignment['tracking_link']   ?? null,
                'cod_amount'       => $consignment['cod_amount']      ?? $order->total,
                'status'           => $consignment['status']          ?? 'in_review',
                'delivery_charge'  => $consignment['delivery_charge'] ?? 0,
                'tracking_message' => 'Sent to Steadfast successfully.',
                'response_message' => json_encode($fullData),
                'is_sent'          => true,
            ]
        );
        $order->update(['status' => 'recovered']);
    }

    // ── Steadfast Single Send ─────────────────────────────────────
    public function steadfastSend(Request $request, IncompleteOrder $incompleteOrder)
    {
        $settings = Steadfastcourier::active();
        if (!$settings) return back()->with('error', '❌ Steadfast Courier সেটিংস পাওয়া যায়নি।');

        $existing = \App\Models\SteadfastOrder::where('incomplete_order_id', $incompleteOrder->id)->first();
        if ($existing && $existing->is_sent) {
            return back()->with('warning', '⚠️ এই অর্ডার আগেই পাঠানো হয়েছে। Tracking: ' . $existing->tracking_code);
        }

        try {
            $result = $this->sfCallApi(
                trim($settings->api_key),
                trim($settings->secret_key),
                $this->sfBuildPayload($incompleteOrder),
                $this->sfGetBaseUrl($settings)
            );

            $data = $result['data'];
            $code = $result['code'];

            if ($code >= 200 && $code < 300 && isset($data['consignment']['consignment_id'])) {
                $this->sfSaveConsignment($incompleteOrder, $data['consignment'], $data);
                return back()->with('success', '✅ Steadfast-এ পাঠানো হয়েছে! Tracking: ' . ($data['consignment']['tracking_code'] ?? 'N/A'));
            }

            $errMsg = $data['message'] ?? $data['errors'] ?? 'Unknown error';
            return back()->with('error', '❌ Steadfast Error (HTTP ' . $code . '): ' . (is_array($errMsg) ? json_encode($errMsg) : $errMsg));

        } catch (\Exception $e) {
            Log::error('[SF-Incomplete] Single: ' . $e->getMessage());
            return back()->with('error', '❌ ' . $e->getMessage());
        }
    }

    // ── Steadfast Bulk Send ───────────────────────────────────────
    public function steadfastBulkSend(Request $request)
    {
        $request->validate(['ids' => 'required|array|min:1']);
        $settings = Steadfastcourier::active();
        if (!$settings) return back()->with('error', '❌ Steadfast Courier সেটিংস পাওয়া যায়নি।');

        $baseUrl   = $this->sfGetBaseUrl($settings);
        $apiKey    = trim($settings->api_key);
        $secretKey = trim($settings->secret_key);

        $orders  = IncompleteOrder::whereIn('id', $request->ids)->get();
        $success = $failed = $skipped = 0;
        $errors  = [];

        foreach ($orders as $order) {
            $existing = \App\Models\SteadfastOrder::where('incomplete_order_id', $order->id)->first();
            if ($existing && $existing->is_sent) { $skipped++; continue; }

            try {
                $result = $this->sfCallApi($apiKey, $secretKey, $this->sfBuildPayload($order), $baseUrl);
                $data   = $result['data'];
                $code   = $result['code'];

                if ($code >= 200 && $code < 300 && isset($data['consignment']['consignment_id'])) {
                    $this->sfSaveConsignment($order, $data['consignment'], $data);
                    $success++;
                } else {
                    $errMsg   = $data['message'] ?? $data['errors'] ?? 'HTTP ' . $code;
                    $errors[] = "#INC-{$order->id}: " . (is_array($errMsg) ? json_encode($errMsg) : $errMsg);
                    $failed++;
                }
            } catch (\Exception $e) {
                $errors[] = "#INC-{$order->id}: " . $e->getMessage();
                $failed++;
            }
        }

        $parts = [];
        if ($success > 0) $parts[] = "✅ {$success}টি সফলভাবে পাঠানো হয়েছে";
        if ($skipped > 0) $parts[] = "⏭️ {$skipped}টি ইতিমধ্যে পাঠানো (skip)";
        if ($failed > 0)  $parts[] = "❌ {$failed}টি ব্যর্থ";
        $msg = implode(', ', $parts) . '.';
        if (!empty($errors)) $msg .= ' Errors: ' . implode(' | ', array_slice($errors, 0, 3));

        return back()->with($success > 0 ? 'success' : 'error', $msg);
    }

    // ══════════════════════════════════════════════════════════════
    // ── PATHAO HELPERS ───────────────────────────────────────────
    // ══════════════════════════════════════════════════════════════
    private function pathaoSanitizePhone(?string $phone): string
    {
        if (!$phone) return '';
        $digits = preg_replace('/\D/', '', trim($phone));
        if (strlen($digits) === 14 && str_starts_with($digits, '8801')) $digits = substr($digits, 2);
        elseif (strlen($digits) === 13 && str_starts_with($digits, '880')) $digits = '0' . substr($digits, 3);
        elseif (strlen($digits) === 12 && str_starts_with($digits, '88'))  $digits = '0' . substr($digits, 2);
        elseif (strlen($digits) === 10 && str_starts_with($digits, '1'))   $digits = '0' . $digits;
        return $digits;
    }

    private function pathaoGetToken()
    {
        $settings = Pathaocourier::first();
        if (!$settings || !$settings->status) throw new \Exception('Pathao Courier settings not configured or inactive.');

        if ($settings->isTokenExpired()) {
            if ($settings->refresh_token) {
                $response = Http::post($settings->base_url . '/aladdin/api/v1/issue-token', [
                    'client_id'     => $settings->client_id,
                    'client_secret' => $settings->client_secret,
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $settings->refresh_token,
                ]);
                if ($response->successful()) {
                    $data = $response->json();
                    $settings->update([
                        'access_token'     => $data['access_token'],
                        'refresh_token'    => $data['refresh_token'] ?? $settings->refresh_token,
                        'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 432000),
                    ]);
                    return $data['access_token'];
                }
            }
            $response = Http::post($settings->base_url . '/aladdin/api/v1/issue-token', [
                'client_id'     => $settings->client_id,
                'client_secret' => $settings->client_secret,
                'username'      => $settings->username,
                'password'      => $settings->password,
                'grant_type'    => 'password',
            ]);
            if (!$response->successful()) throw new \Exception('Token generate failed: ' . $response->body());
            $data = $response->json();
            $settings->update([
                'access_token'     => $data['access_token'],
                'refresh_token'    => $data['refresh_token'] ?? null,
                'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 432000),
            ]);
            return $data['access_token'];
        }
        return $settings->access_token;
    }

    private function pathaoSaveOrder(IncompleteOrder $order, array $data, Request $request): void
    {
        \App\Models\PathaoOrder::updateOrCreate(
            ['incomplete_order_id' => $order->id],
            [
                'order_id'          => null,
                'consignment_id'    => $data['consignment_id']    ?? null,
                'merchant_order_id' => $data['merchant_order_id'] ?? ($order->id . '-INC'),
                'order_status'      => $data['order_status']      ?? 'Pending',
                'delivery_fee'      => $data['delivery_fee']      ?? 0,
                'store_id'          => $request->store_id,
                'city_id'           => $request->city_id,
                'zone_id'           => $request->zone_id,
                'area_id'           => $request->area_id ?? null,
                'amount_to_collect' => $order->total,
                'is_sent'           => true,
                'response_data'     => json_encode($data),
            ]
        );
        $order->update(['status' => 'recovered']);
    }

    // ── Pathao Single Send ────────────────────────────────────────
    public function pathaoSend(Request $request, IncompleteOrder $incompleteOrder)
    {
        $request->validate([
            'store_id' => 'required|integer',
            'city_id'  => 'required|integer',
            'zone_id'  => 'required|integer',
        ]);

        try {
            $settings = Pathaocourier::first();
            $token    = $this->pathaoGetToken();
            $phone    = $this->pathaoSanitizePhone($incompleteOrder->phone);

            $payload = [
                'store_id'          => (int) $request->store_id,
                'merchant_order_id' => $incompleteOrder->id . '-INC',
                'recipient_name'    => $incompleteOrder->customer_name,
                'recipient_phone'   => $phone,
                'recipient_address' => $incompleteOrder->address,
                'recipient_city'    => (int) $request->city_id,
                'recipient_zone'    => (int) $request->zone_id,
                'delivery_type'     => 48,
                'item_type'         => 2,
                'item_quantity'     => !empty($incompleteOrder->cart_snapshot) ? count($incompleteOrder->cart_snapshot) : 1,
                'item_weight'       => 0.5,
                'amount_to_collect' => (int) $incompleteOrder->total,
                'item_description'  => 'Incomplete Order Recovery #' . $incompleteOrder->id,
            ];
            if ($request->filled('area_id')) $payload['recipient_area'] = (int) $request->area_id;

            Log::info('[Pathao-Incomplete] Single payload', $payload);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ])->post($settings->base_url . '/aladdin/api/v1/orders', $payload);

            Log::info('[Pathao-Incomplete] Single response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                $data = $response->json('data');
                $this->pathaoSaveOrder($incompleteOrder, $data, $request);
                return response()->json(['success' => true, 'message' => 'Order sent to Pathao successfully!', 'data' => $data]);
            }

            return response()->json(['success' => false, 'message' => 'Pathao API error: ' . $response->body()], 400);

        } catch (\Exception $e) {
            Log::error('[Pathao-Incomplete] Single exception', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ── Pathao Bulk Send ──────────────────────────────────────────
    public function pathaoBulkSend(Request $request)
    {
        $request->validate([
            'ids'      => 'required|array',
            'store_id' => 'required|integer',
            'city_id'  => 'required|integer',
            'zone_id'  => 'required|integer',
        ]);

        try {
            $settings = Pathaocourier::first();
            $token    = $this->pathaoGetToken();
            $orders   = IncompleteOrder::whereIn('id', $request->ids)->get();
            $payload  = [];

            foreach ($orders as $order) {
                $phone = $this->pathaoSanitizePhone($order->phone);
                $item  = [
                    'store_id'          => (int) $request->store_id,
                    'merchant_order_id' => $order->id . '-INC',
                    'recipient_name'    => $order->customer_name,
                    'recipient_phone'   => $phone,
                    'recipient_address' => $order->address,
                    'recipient_city'    => (int) $request->city_id,
                    'recipient_zone'    => (int) $request->zone_id,
                    'delivery_type'     => 48,
                    'item_type'         => 2,
                    'item_quantity'     => !empty($order->cart_snapshot) ? count($order->cart_snapshot) : 1,
                    'item_weight'       => 0.5,
                    'amount_to_collect' => (int) $order->total,
                    'item_description'  => 'Incomplete Order #' . $order->id,
                ];
                if ($request->filled('area_id')) $item['recipient_area'] = (int) $request->area_id;
                $payload[] = $item;
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json; charset=UTF-8',
            ])->post($settings->base_url . '/aladdin/api/v1/orders/bulk', ['orders' => $payload]);

            Log::info('[Pathao-Incomplete] Bulk response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                foreach ($orders as $order) {
                    $this->pathaoSaveOrder($order, [], $request);
                }
                return response()->json(['success' => true, 'message' => count($payload) . 'টি অর্ডার Pathao-তে পাঠানো হয়েছে!']);
            }

            return response()->json(['success' => false, 'message' => 'Pathao API error: ' . $response->body()], 400);

        } catch (\Exception $e) {
            Log::error('[Pathao-Incomplete] Bulk exception', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
