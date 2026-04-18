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
    // DB থেকে Base URL বের করো — কোনো hardcode নেই
    // ══════════════════════════════════════════════════════════════
    private function getBaseUrl(Steadfastcourier $settings): string
    {
        $dbUrl = trim($settings->url ?? '');

        if (empty($dbUrl)) {
            throw new \Exception('Steadfast API URL ডাটাবেজে সেট করা নেই। Admin Panel → Steadfast Courier Settings → URL ফিল্ড পূরণ করুন।');
        }

        // /create_order শেষে থাকলে strip করো, trailing slash সরাও
        return rtrim(preg_replace('#/create_order$#i', '', $dbUrl), '/');
    }

    // ══════════════════════════════════════════════════════════════
    // Steadfast API Call
    // ══════════════════════════════════════════════════════════════
    private function callSteadfast(string $apiKey, string $secretKey, array $payload, string $baseUrl): array
    {
        $url = $baseUrl . '/create_order';
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

        Log::info("Steadfast API Call [{$url}]", [
            'http_code' => $httpCode,
            'curl_errno' => $errno,
            'curl_error' => $error,
            'response'  => substr((string) $body, 0, 500),
        ]);

        // cURL নিজেই connect করতে পারেনি
        if ($errno) {
            throw new \Exception("cURL সংযোগ ব্যর্থ [{$errno}]: {$error}. URL চেক করুন: {$url}");
        }

        $bodyStr = (string) $body;
        $data    = json_decode($bodyStr, true);

        // JSON না হলে plain-text error (যেমন "Account is not active!")
        if (json_last_error() !== JSON_ERROR_NONE) {
            $plainMsg = trim(strip_tags($bodyStr));
            return [
                'code'  => $httpCode,
                'data'  => ['message' => $plainMsg ?: "Invalid JSON response (HTTP {$httpCode})"],
                'url'   => $url,
                'error' => true,
            ];
        }

        return ['code' => $httpCode, 'data' => $data, 'url' => $url];
    }

    // ══════════════════════════════════════════════════════════════
    // Consignment DB-তে save করো
    // ══════════════════════════════════════════════════════════════
    private function saveConsignment(Order $order, array $consignment, array $fullData): void
    {
        SteadfastOrder::updateOrCreate(
            ['order_id' => $order->id],
            [
                'consignment_id'   => $consignment['consignment_id'],
                'invoice'          => $consignment['invoice']         ?? $order->order_number,
                'tracking_code'    => $consignment['tracking_code']   ?? null,
                'cod_amount'       => $consignment['cod_amount']      ?? $order->total,
                'status'           => $consignment['status']          ?? 'in_review',
                'delivery_charge'  => $consignment['delivery_charge'] ?? 0,
                'tracking_message' => 'Sent to Steadfast successfully.',
                'response_message' => json_encode($fullData),
                'is_sent'          => true,
            ]
        );

        $order->update(['order_status' => 'processing']);
    }

    // ══════════════════════════════════════════════════════════════
    // Order Payload তৈরি
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
    // Settings লোড — না পেলে null
    // ══════════════════════════════════════════════════════════════
    private function loadSettings(): ?Steadfastcourier
    {
        return Steadfastcourier::active();
    }

    // ══════════════════════════════════════════════════════════════
    // Single Order Send
    // ══════════════════════════════════════════════════════════════
    public function send(Request $request, $order)
    {
        $order    = Order::with(['items', 'steadfastOrder'])->findOrFail($order);
        $settings = $this->loadSettings();

        if (!$settings) {
            return back()->with('error', '❌ Steadfast Courier সেটিংস পাওয়া যায়নি। Admin Panel → Steadfast Courier থেকে API Key ও URL সেট করুন।');
        }

        try {
            $baseUrl = $this->getBaseUrl($settings);
            $payload = $this->buildPayload($order);

            Log::info('Steadfast Single Send — Payload:', $payload);
            Log::info('Steadfast Single Send — Base URL:', ['url' => $baseUrl]);

            $result = $this->callSteadfast(
                trim($settings->api_key),
                trim($settings->secret_key),
                $payload,
                $baseUrl
            );

            $data = $result['data'];
            $code = $result['code'];

            if ($code >= 200 && $code < 300 && isset($data['consignment']['consignment_id'])) {
                $this->saveConsignment($order, $data['consignment'], $data);
                return back()->with('success',
                    '✅ অর্ডার Steadfast-এ পাঠানো হয়েছে! Tracking: ' . ($data['consignment']['tracking_code'] ?? 'N/A')
                );
            }

            $errMsg = $data['message'] ?? $data['errors'] ?? 'Unknown API error';
            Log::error('Steadfast API Error (single):', ['code' => $code, 'data' => $data]);

            return back()->with('error',
                '❌ Steadfast Error (HTTP ' . $code . '): ' . (is_array($errMsg) ? json_encode($errMsg) : $errMsg)
            );

        } catch (\Exception $e) {
            Log::error('Steadfast Exception (single): ' . $e->getMessage());
            return back()->with('error', '❌ Error: ' . $e->getMessage());
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
            return back()->with('error', '❌ Steadfast Courier সেটিংস পাওয়া যায়নি। Admin Panel → Steadfast Courier থেকে API Key ও URL সেট করুন।');
        }

        try {
            $baseUrl   = $this->getBaseUrl($settings);
            $apiKey    = trim($settings->api_key);
            $secretKey = trim($settings->secret_key);
        } catch (\Exception $e) {
            return back()->with('error', '❌ ' . $e->getMessage());
        }

        $orders  = Order::with('steadfastOrder')->whereIn('id', $request->ids)->get();
        $success = 0;
        $failed  = 0;
        $skipped = 0;
        $errors  = [];

        foreach ($orders as $order) {

            // ইতিমধ্যে পাঠানো হয়ে গেলে skip
            if ($order->steadfastOrder && $order->steadfastOrder->is_sent) {
                $skipped++;
                continue;
            }

            $payload = $this->buildPayload($order);

            try {
                $result = $this->callSteadfast($apiKey, $secretKey, $payload, $baseUrl);
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
    // Webhook — Steadfast থেকে status update পাবে
    // ══════════════════════════════════════════════════════════════
    public function webhook(Request $request)
    {
        Log::info('Steadfast Webhook Received:', $request->all());

        $consignmentId  = $request->input('consignment_id');
        $status         = strtolower($request->input('status', ''));
        $steadfastOrder = SteadfastOrder::where('consignment_id', $consignmentId)->first();

        if (!$steadfastOrder) {
            Log::warning('Steadfast Webhook: Consignment not found — ' . $consignmentId);
            return response()->json(['status' => 'not_found', 'message' => 'Consignment not found.'], 404);
        }

        $steadfastOrder->update([
            'status'           => $status,
            'cod_amount'       => $request->input('cod_amount',      $steadfastOrder->cod_amount),
            'delivery_charge'  => $request->input('delivery_charge', $steadfastOrder->delivery_charge),
            'tracking_message' => 'Webhook: ' . $status,
        ]);

        $orderStatus = match ($status) {
            'delivered'                                        => 'delivered',
            'cancelled', 'cancelled_approval_pending'         => 'cancelled',
            'partial_delivered',
            'delivered_approval_pending',
            'partial_delivered_approval_pending'              => 'shipped',
            'hold'                                            => 'on_hold',
            default                                           => 'processing',
        };

        $steadfastOrder->order?->update(['order_status' => $orderStatus]);

        Log::info("Steadfast Webhook: Consignment {$consignmentId} → {$status} → Order {$orderStatus}");

        return response()->json(['status' => 'success', 'message' => 'Webhook received.']);
    }
}
