<?php
// app/Http/Controllers/Admin/PathaoOrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PathaoOrder;
use App\Models\Pathaocourier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PathaoOrderController extends Controller
{
    // ─── Phone Sanitizer ─────────────────────────────────────────────
    private function sanitizePhone(?string $phone): string
    {
        if (!$phone) return '';

        $original = $phone;
        $phone    = trim($phone);
        $digits   = preg_replace('/\D/', '', $phone);

        Log::debug('[Pathao] sanitizePhone input', [
            'original' => $original,
            'trimmed'  => $phone,
            'digits'   => $digits,
            'length'   => strlen($digits),
        ]);

        if (strlen($digits) === 14 && str_starts_with($digits, '8801')) {
            $digits = substr($digits, 2); // 8801XXXXXXXXXX → 01XXXXXXXXX
        } elseif (strlen($digits) === 13 && str_starts_with($digits, '880')) {
            $digits = '0' . substr($digits, 3); // 880XXXXXXXXXX → 01XXXXXXXXX
        } elseif (strlen($digits) === 12 && str_starts_with($digits, '88')) {
            $digits = '0' . substr($digits, 2); // 88XXXXXXXXXX → 01XXXXXXXXX
        } elseif (strlen($digits) === 10 && str_starts_with($digits, '1')) {
            $digits = '0' . $digits; // 1XXXXXXXXX → 01XXXXXXXXX
        }

        Log::debug('[Pathao] sanitizePhone output', [
            'sanitized' => $digits,
            'length'    => strlen($digits),
            'valid'     => strlen($digits) === 11 && str_starts_with($digits, '01'),
        ]);

        return $digits;
    }

    // ─── Debug: Phone Test ───────────────────────────────────────────
    public function debugPhone()
    {
        $orders = Order::latest()->take(10)->get(['id', 'order_number', 'phone']);

        $result = $orders->map(function ($order) {
            $sanitized = $this->sanitizePhone($order->phone);
            return [
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
                'original'     => $order->phone,
                'sanitized'    => $sanitized,
                'length'       => strlen($sanitized),
                'valid'        => strlen($sanitized) === 11 && str_starts_with($sanitized, '01'),
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $result,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // ─── Debug: Full Payload Preview ─────────────────────────────────
    public function debugPayload(Request $request)
    {
        $ids = $request->input('ids', Order::latest()->take(3)->pluck('id')->toArray());

        $orders  = Order::whereIn('id', $ids)->with('items')->get();
        $payload = [];

        foreach ($orders as $order) {
            $phone = $this->sanitizePhone($order->phone);
            $payload[] = [
                'store_id'          => 999,
                'merchant_order_id' => $order->order_number,
                'recipient_name'    => $order->customer_name,
                'recipient_phone'   => $phone,
                'recipient_phone_raw' => $order->phone,
                'recipient_address' => $order->address,
                'recipient_city'    => 1,
                'recipient_zone'    => 1,
                'delivery_type'     => 48,
                'item_type'         => 2,
                'item_quantity'     => $order->items->sum('quantity'),
                'item_weight'       => 0.5,
                'amount_to_collect' => (int) $order->total,
                'item_description'  => 'Order #' . $order->order_number,
                '__phone_valid'     => strlen($phone) === 11 && str_starts_with($phone, '01'),
            ];
        }

        return response()->json([
            'success'      => true,
            'order_count'  => count($payload),
            'payload'      => $payload,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // ─── Debug: Token Test ───────────────────────────────────────────
    public function debugToken()
    {
        try {
            $settings = Pathaocourier::first();

            if (!$settings) {
                return response()->json(['success' => false, 'message' => 'No Pathao settings found in DB']);
            }

            return response()->json([
                'success'          => true,
                'status'           => $settings->status,
                'base_url'         => $settings->base_url,
                'client_id'        => $settings->client_id,
                'has_access_token' => !empty($settings->access_token),
                'token_preview'    => $settings->access_token ? substr($settings->access_token, 0, 20) . '...' : null,
                'token_expires_at' => $settings->token_expires_at,
                'is_expired'       => $settings->isTokenExpired(),
                'has_refresh'      => !empty($settings->refresh_token),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // ─── Helper: valid token নিয়ে আসে ───────────────────────────────
    private function getAccessToken()
    {
        $settings = Pathaocourier::first();

        if (!$settings || !$settings->status) {
            throw new \Exception('Pathao Courier settings not configured or inactive.');
        }

        if ($settings->isTokenExpired()) {
            Log::info('[Pathao] Token expired, refreshing...');

            if ($settings->refresh_token) {
                $response = Http::post($settings->base_url . '/aladdin/api/v1/issue-token', [
                    'client_id'     => $settings->client_id,
                    'client_secret' => $settings->client_secret,
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $settings->refresh_token,
                ]);

                Log::debug('[Pathao] Refresh token response', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
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

            Log::info('[Pathao] Using password grant...');

            $response = Http::post($settings->base_url . '/aladdin/api/v1/issue-token', [
                'client_id'     => $settings->client_id,
                'client_secret' => $settings->client_secret,
                'username'      => $settings->username,
                'password'      => $settings->password,
                'grant_type'    => 'password',
            ]);

            Log::debug('[Pathao] Password grant response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            if (!$response->successful()) {
                throw new \Exception('Token generate failed: ' . $response->body());
            }

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

    // ─── Store List ──────────────────────────────────────────────────
    public function getStores()
    {
        try {
            $settings = Pathaocourier::first();
            $token    = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ])->get($settings->base_url . '/aladdin/api/v1/stores');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $response->json('data.data') ?? [],
                ]);
            }

            return response()->json(['success' => false, 'message' => $response->body()], 400);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── City List ───────────────────────────────────────────────────
    public function getCities()
    {
        try {
            $settings = Pathaocourier::first();
            $token    = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ])->get($settings->base_url . '/aladdin/api/v1/city-list');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $response->json('data.data') ?? [],
                ]);
            }

            return response()->json(['success' => false, 'message' => $response->body()], 400);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── Zone List ───────────────────────────────────────────────────
    public function getZones(Request $request)
    {
        try {
            $settings = Pathaocourier::first();
            $token    = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ])->get($settings->base_url . '/aladdin/api/v1/cities/' . $request->city_id . '/zone-list');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $response->json('data.data') ?? [],
                ]);
            }

            return response()->json(['success' => false, 'message' => $response->body()], 400);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── Area List ───────────────────────────────────────────────────
    public function getAreas(Request $request)
    {
        try {
            $settings = Pathaocourier::first();
            $token    = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ])->get($settings->base_url . '/aladdin/api/v1/zones/' . $request->zone_id . '/area-list');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $response->json('data.data') ?? [],
                ]);
            }

            return response()->json(['success' => false, 'message' => $response->body()], 400);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── Single Order Send ───────────────────────────────────────────
    public function send(Request $request, Order $order)
    {
        $request->validate([
            'store_id' => 'required|integer',
            'city_id'  => 'required|integer',
            'zone_id'  => 'required|integer',
        ]);

        try {
            $settings = Pathaocourier::first();
            $token    = $this->getAccessToken();

            $phone = $this->sanitizePhone($order->phone);

            $payload = [
                'store_id'          => (int) $request->store_id,
                'merchant_order_id' => $order->order_number,
                'recipient_name'    => $order->customer_name,
                'recipient_phone'   => $phone,
                'recipient_address' => $order->address,
                'recipient_city'    => (int) $request->city_id,
                'recipient_zone'    => (int) $request->zone_id,
                'delivery_type'     => 48,
                'item_type'         => 2,
                'item_quantity'     => $order->items->sum('quantity'),
                'item_weight'       => 0.5,
                'amount_to_collect' => (int) $order->total,
                'item_description'  => 'Order #' . $order->order_number,
            ];

            if ($request->filled('area_id')) {
                $payload['recipient_area'] = (int) $request->area_id;
            }

            Log::info('[Pathao] Single send payload', $payload);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ])->post($settings->base_url . '/aladdin/api/v1/orders', $payload);

            Log::info('[Pathao] Single send response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            if ($response->successful()) {
                $data = $response->json('data');

                PathaoOrder::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'consignment_id'    => $data['consignment_id'] ?? null,
                        'merchant_order_id' => $data['merchant_order_id'] ?? $order->order_number,
                        'order_status'      => $data['order_status'] ?? 'Pending',
                        'delivery_fee'      => $data['delivery_fee'] ?? 0,
                        'store_id'          => $request->store_id,
                        'city_id'           => $request->city_id,
                        'zone_id'           => $request->zone_id,
                        'area_id'           => $request->area_id ?? null,
                        'amount_to_collect' => $order->total,
                        'is_sent'           => true,
                        'response_data'     => json_encode($response->json()),
                    ]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Order sent to Pathao successfully!',
                    'data'    => $data,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Pathao API error: ' . $response->body(),
            ], 400);

        } catch (\Exception $e) {
            Log::error('[Pathao] Single send exception', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ─── Bulk Order Send ─────────────────────────────────────────────
    public function bulkSend(Request $request)
    {
        $request->validate([
            'ids'      => 'required|array',
            'store_id' => 'required|integer',
            'city_id'  => 'required|integer',
            'zone_id'  => 'required|integer',
        ]);

        try {
            $settings = Pathaocourier::first();
            $token    = $this->getAccessToken();

            $orders  = Order::whereIn('id', $request->ids)->with('items')->get();
            $payload = [];

            foreach ($orders as $order) {
                $phone = $this->sanitizePhone($order->phone);

                Log::info('[Pathao] Bulk phone', [
                    'order'     => $order->order_number,
                    'original'  => $order->phone,
                    'sanitized' => $phone,
                    'valid'     => strlen($phone) === 11 && str_starts_with($phone, '01'),
                ]);

                $item = [
                    'store_id'          => (int) $request->store_id,
                    'merchant_order_id' => $order->order_number,
                    'recipient_name'    => $order->customer_name,
                    'recipient_phone'   => $phone,
                    'recipient_address' => $order->address,
                    'recipient_city'    => (int) $request->city_id,
                    'recipient_zone'    => (int) $request->zone_id,
                    'delivery_type'     => 48,
                    'item_type'         => 2,
                    'item_quantity'     => $order->items->sum('quantity'),
                    'item_weight'       => 0.5,
                    'amount_to_collect' => (int) $order->total,
                    'item_description'  => 'Order #' . $order->order_number,
                ];

                if ($request->filled('area_id')) {
                    $item['recipient_area'] = (int) $request->area_id;
                }

                $payload[] = $item;
            }

            Log::info('[Pathao] Bulk send full payload', ['orders' => $payload]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json; charset=UTF-8',
            ])->post($settings->base_url . '/aladdin/api/v1/orders/bulk', [
                'orders' => $payload,
            ]);

            Log::info('[Pathao] Bulk send response', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            if ($response->successful()) {
                foreach ($orders as $order) {
                    PathaoOrder::updateOrCreate(
                        ['order_id' => $order->id],
                        [
                            'order_status'      => 'Pending',
                            'store_id'          => $request->store_id,
                            'city_id'           => $request->city_id,
                            'zone_id'           => $request->zone_id,
                            'area_id'           => $request->area_id ?? null,
                            'amount_to_collect' => $order->total,
                            'is_sent'           => true,
                            'response_data'     => json_encode($response->json()),
                        ]
                    );
                }

                return response()->json([
                    'success' => true,
                    'message' => count($payload) . 'টি অর্ডার Pathao-তে পাঠানো হয়েছে!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Pathao API error: ' . $response->body(),
            ], 400);

        } catch (\Exception $e) {
            Log::error('[Pathao] Bulk send exception', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ─── Test Token ──────────────────────────────────────────────────
    public function test()
    {
        try {
            $token = $this->getAccessToken();
            return response()->json(['success' => true, 'token' => substr($token, 0, 30) . '...']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
