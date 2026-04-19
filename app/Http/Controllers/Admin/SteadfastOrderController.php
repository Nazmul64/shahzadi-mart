<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SteadfastOrder;
use App\Models\Steadfastcourier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SteadfastOrderController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    // Base URL — DB থেকে নাও, invalid হলে official fallback
    // ══════════════════════════════════════════════════════════════
    private function getBaseUrl(Steadfastcourier $settings): string
    {
        $dbUrl = trim($settings->url ?? '');

        if (empty($dbUrl)) {
            return 'https://portal.steadfast.com.bd/api/v1';
        }

        $clean = trim(preg_replace('#/create_order.*$#i', '', $dbUrl));
        $clean = rtrim($clean, '/');

        if (!filter_var($clean, FILTER_VALIDATE_URL) || str_contains($clean, ' ')) {
            Log::warning('Steadfast: DB URL invalid, fallback. DB value: ' . $dbUrl);
            return 'https://portal.steadfast.com.bd/api/v1';
        }

        return $clean;
    }

    // ══════════════════════════════════════════════════════════════
    // API Call
    // ══════════════════════════════════════════════════════════════
    private function callSteadfast(string $apiKey, string $secretKey, array $payload, string $baseUrl): array
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

        Log::info("Steadfast API [{$url}]", [
            'http_code'  => $httpCode,
            'curl_errno' => $errno,
            'payload'    => $payload,
            'response'   => substr((string) $body, 0, 800),
        ]);

        if ($errno) {
            throw new \Exception("cURL ব্যর্থ [{$errno}]: {$error}. URL: {$url}");
        }

        $data = json_decode((string) $body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $plainMsg = trim(strip_tags((string) $body));
            return [
                'code'  => $httpCode,
                'data'  => ['message' => $plainMsg ?: "Invalid JSON (HTTP {$httpCode})"],
                'error' => true,
            ];
        }

        return ['code' => $httpCode, 'data' => $data];
    }

    // ══════════════════════════════════════════════════════════════
    // Consignment Save — ✅ tracking_link যোগ, response_message এখন longText
    // ══════════════════════════════════════════════════════════════
    private function saveConsignment(Order $order, array $consignment, array $fullData): void
    {
        SteadfastOrder::updateOrCreate(
            ['order_id' => $order->id],
            [
                'consignment_id'   => $consignment['consignment_id'],
                'invoice'          => $consignment['invoice']          ?? $order->order_number,
                'tracking_code'    => $consignment['tracking_code']    ?? null,
                'tracking_link'    => $consignment['tracking_link']    ?? null,  // ✅ নতুন
                'cod_amount'       => $consignment['cod_amount']       ?? $order->total,
                'status'           => $consignment['status']           ?? 'in_review',
                'delivery_charge'  => $consignment['delivery_charge']  ?? 0,
                'tracking_message' => 'Sent to Steadfast successfully.',
                'response_message' => json_encode($fullData),           // ✅ longText এ save হবে
                'is_sent'          => true,
            ]
        );

        $order->update(['order_status' => 'processing']);
    }

    // ══════════════════════════════════════════════════════════════
    // Payload
    // ══════════════════════════════════════════════════════════════
    private function buildPayload(Order $order): array
    {
        return [
            'invoice'           => (string) $order->order_number,
            'recipient_name'    => (string) $order->customer_name,
            'recipient_phone'   => (string) $order->phone,
            'recipient_address' => (string) $order->address,
            'cod_amount'        => (float)  $order->total,
            'note'              => (string) ($order->note ?? ''),
        ];
    }

    // ══════════════════════════════════════════════════════════════
    // Settings
    // ══════════════════════════════════════════════════════════════
    private function loadSettings(): ?Steadfastcourier
    {
        return Steadfastcourier::active();
    }

    // ══════════════════════════════════════════════════════════════
    // TEST — GET admin/steadfast/test
    // ══════════════════════════════════════════════════════════════
    public function test(Request $request)
    {
        $settings = $this->loadSettings();
        $result   = [
            'settings_found' => false,
            'api_key'        => null,
            'secret_key'     => null,
            'db_url'         => null,
            'resolved_url'   => null,
            'balance_check'  => null,
            'balance_result' => null,
            'error'          => null,
        ];

        if (!$settings) {
            $result['error'] = '❌ DB তে কোনো active Steadfast courier নেই।';
            return response()->json($result, 404);
        }

        $result['settings_found'] = true;
        $result['api_key']        = substr($settings->api_key, 0, 6) . '****';
        $result['secret_key']     = substr($settings->secret_key, 0, 6) . '****';
        $result['db_url']         = $settings->url;

        try {
            $baseUrl               = $this->getBaseUrl($settings);
            $result['resolved_url'] = $baseUrl;

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $baseUrl . '/get_balance',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPGET        => true,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER     => [
                    'Api-Key: '    . trim($settings->api_key),
                    'Secret-Key: ' . trim($settings->secret_key),
                    'Content-Type: application/json',
                    'Accept: application/json',
                ],
            ]);
            $body     = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errno    = curl_errno($ch);
            $error    = curl_error($ch);
            curl_close($ch);

            $result['balance_check'] = "HTTP {$httpCode}";

            if ($errno) {
                $result['error'] = "cURL Error [{$errno}]: {$error}";
            } else {
                $data = json_decode($body, true);
                $result['balance_result'] = json_last_error() === JSON_ERROR_NONE
                    ? $data
                    : trim(strip_tags($body));
            }

        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        return response()->json($result);
    }

    // ══════════════════════════════════════════════════════════════
    // Single Send
    // ══════════════════════════════════════════════════════════════
    public function send(Request $request, $order)
    {
        $order    = Order::with(['items', 'steadfastOrder'])->findOrFail($order);
        $settings = $this->loadSettings();

        if (!$settings) {
            return back()->with('error', '❌ Steadfast Courier সেটিংস পাওয়া যায়নি।');
        }

        if ($order->steadfastOrder && $order->steadfastOrder->is_sent) {
            return back()->with('warning', '⚠️ এই অর্ডার আগেই পাঠানো হয়েছে। Tracking: ' . $order->steadfastOrder->tracking_code);
        }

        try {
            $result = $this->callSteadfast(
                trim($settings->api_key),
                trim($settings->secret_key),
                $this->buildPayload($order),
                $this->getBaseUrl($settings)
            );

            $data = $result['data'];
            $code = $result['code'];

            if ($code >= 200 && $code < 300 && isset($data['consignment']['consignment_id'])) {
                $this->saveConsignment($order, $data['consignment'], $data);
                return back()->with('success',
                    '✅ Steadfast-এ পাঠানো হয়েছে! Tracking: ' . ($data['consignment']['tracking_code'] ?? 'N/A')
                );
            }

            $errMsg = $data['message'] ?? $data['errors'] ?? 'Unknown error';
            Log::error('Steadfast Error (single):', ['code' => $code, 'data' => $data]);
            return back()->with('error', '❌ Steadfast Error (HTTP ' . $code . '): ' . (is_array($errMsg) ? json_encode($errMsg) : $errMsg));

        } catch (\Exception $e) {
            Log::error('Steadfast Exception (single): ' . $e->getMessage());
            return back()->with('error', '❌ ' . $e->getMessage());
        }
    }

    // ══════════════════════════════════════════════════════════════
    // Bulk Send
    // ══════════════════════════════════════════════════════════════
    public function bulkSend(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:orders,id',
        ]);

        $settings = $this->loadSettings();
        if (!$settings) {
            return back()->with('error', '❌ Steadfast Courier সেটিংস পাওয়া যায়নি।');
        }

        try {
            $baseUrl   = $this->getBaseUrl($settings);
            $apiKey    = trim($settings->api_key);
            $secretKey = trim($settings->secret_key);
        } catch (\Exception $e) {
            return back()->with('error', '❌ ' . $e->getMessage());
        }

        $orders  = Order::with('steadfastOrder')->whereIn('id', $request->ids)->get();
        $success = $failed = $skipped = 0;
        $errors  = [];

        foreach ($orders as $order) {
            if ($order->steadfastOrder && $order->steadfastOrder->is_sent) {
                $skipped++;
                continue;
            }

            try {
                $result = $this->callSteadfast($apiKey, $secretKey, $this->buildPayload($order), $baseUrl);
                $data   = $result['data'];
                $code   = $result['code'];

                if ($code >= 200 && $code < 300 && isset($data['consignment']['consignment_id'])) {
                    $this->saveConsignment($order, $data['consignment'], $data);
                    $success++;
                } else {
                    $errMsg   = $data['message'] ?? $data['errors'] ?? 'HTTP ' . $code;
                    $errors[] = "#{$order->order_number}: " . (is_array($errMsg) ? json_encode($errMsg) : $errMsg);
                    $failed++;
                }

            } catch (\Exception $e) {
                Log::error("Steadfast Bulk #{$order->order_number}: " . $e->getMessage());
                $errors[] = "#{$order->order_number}: " . $e->getMessage();
                $failed++;
            }
        }

        $parts = [];
        if ($success > 0) $parts[] = "✅ {$success}টি সফলভাবে পাঠানো হয়েছে";
        if ($skipped > 0) $parts[] = "⏭️ {$skipped}টি ইতিমধ্যে পাঠানো (skip)";
        if ($failed > 0)  $parts[] = "❌ {$failed}টি ব্যর্থ";

        $msg = implode(', ', $parts) . '.';
        if (!empty($errors)) {
            $msg .= ' Errors: ' . implode(' | ', array_slice($errors, 0, 3));
        }

        return back()->with($success > 0 ? 'success' : 'error', $msg);
    }

    // ══════════════════════════════════════════════════════════════
    // Webhook
    // ══════════════════════════════════════════════════════════════
    public function webhook(Request $request)
    {
        Log::info('Steadfast Webhook:', $request->all());

        $consignmentId  = $request->input('consignment_id');
        $status         = strtolower($request->input('status', ''));
        $steadfastOrder = SteadfastOrder::where('consignment_id', $consignmentId)->first();

        if (!$steadfastOrder) {
            Log::warning('Steadfast Webhook: not found — ' . $consignmentId);
            return response()->json(['status' => 'not_found'], 404);
        }

        $steadfastOrder->update([
            'status'           => $status,
            'cod_amount'       => $request->input('cod_amount',      $steadfastOrder->cod_amount),
            'delivery_charge'  => $request->input('delivery_charge', $steadfastOrder->delivery_charge),
            'tracking_message' => 'Webhook: ' . $status,
        ]);

        $orderStatus = match ($status) {
            'delivered'                                                           => 'delivered',
            'cancelled', 'cancelled_approval_pending'                            => 'cancelled',
            'partial_delivered', 'delivered_approval_pending',
            'partial_delivered_approval_pending'                                 => 'shipped',
            'hold'                                                               => 'on_hold',
            default                                                              => 'processing',
        };

        $steadfastOrder->order?->update(['order_status' => $orderStatus]);

        Log::info("Webhook: {$consignmentId} → {$status} → {$orderStatus}");

        return response()->json(['status' => 'success']);
    }
}
