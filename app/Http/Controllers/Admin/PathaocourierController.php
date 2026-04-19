<?php
// app/Http/Controllers/Admin/PathaocourierController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pathaocourier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PathaocourierController extends Controller
{
    // ইন্ডেক্স - settings দেখাবে
    public function index()
    {
        $pathaocourier = Pathaocourier::first();
        return view('admin.pathaocourier.index', compact('pathaocourier'));
    }

    // Create form
    public function create()
    {
        return view('admin.pathaocourier.create');
    }

    // Save settings
    public function store(Request $request)
    {
        $request->validate([
            'base_url'      => 'required|url',
            'client_id'     => 'required|string',
            'client_secret' => 'required|string',
            'username'      => 'required|string',
            'password'      => 'required|string',
            'grant_type'    => 'required|string',
        ]);

        Pathaocourier::create([
            'base_url'      => $request->base_url,
            'client_id'     => $request->client_id,
            'client_secret' => $request->client_secret,
            'username'      => $request->username,
            'password'      => $request->password,
            'grant_type'    => $request->grant_type,
            'status'        => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.pathaocourier.index')
            ->with('success', 'Pathao Courier settings saved successfully!');
    }

    // Edit form
    public function edit(string $id)
    {
        $pathaocourier = Pathaocourier::findOrFail($id);
        return view('admin.pathaocourier.edit', compact('pathaocourier'));
    }

    // Update settings
  public function update(Request $request, string $id)
{
    $rules = [
        'base_url'      => 'required|url',
        'client_id'     => 'required|string',
        'client_secret' => 'required|string',
        'username'      => 'required|string',
        'grant_type'    => 'required|string',
    ];

    // password দিলে validate করবে, না দিলে skip
    if ($request->filled('password')) {
        $rules['password'] = 'required|string|min:4';
    }

    $request->validate($rules);

    $pathaocourier = Pathaocourier::findOrFail($id);

    $updateData = [
        'base_url'         => $request->base_url,
        'client_id'        => $request->client_id,
        'client_secret'    => $request->client_secret,
        'username'         => $request->username,
        'grant_type'       => $request->grant_type,
        'status'           => $request->has('status') ? 1 : 0,
        'access_token'     => null,
        'refresh_token'    => null,
        'token_expires_at' => null,
    ];

    if ($request->filled('password')) {
        $updateData['password'] = $request->password;
    }

    $pathaocourier->update($updateData);

    return redirect()->route('admin.pathaocourier.index')
        ->with('success', 'Pathao Courier settings updated successfully!');
}

    // Delete
    public function destroy(string $id)
    {
        $pathaocourier = Pathaocourier::findOrFail($id);
        $pathaocourier->delete();

        return redirect()->route('admin.pathaocourier.index')
            ->with('success', 'Pathao Courier settings deleted successfully!');
    }

    // Token generate করবে Pathao API থেকে
    public function generateToken()
    {
        $pathaocourier = Pathaocourier::first();

        if (!$pathaocourier) {
            return redirect()->route('admin.pathaocourier.index')
                ->with('error', 'Pathao Courier settings not found!');
        }

        try {
            $response = Http::post($pathaocourier->base_url . '/aladdin/api/v1/issue-token', [
                'client_id'     => $pathaocourier->client_id,
                'client_secret' => $pathaocourier->client_secret,
                'username'      => $pathaocourier->username,
                'password'      => $pathaocourier->password,
                'grant_type'    => $pathaocourier->grant_type,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $pathaocourier->update([
                    'access_token'     => $data['access_token'],
                    'refresh_token'    => $data['refresh_token'] ?? null,
                    'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 3600),
                ]);

                return redirect()->route('admin.pathaocourier.index')
                    ->with('success', 'Token generated successfully!');
            } else {
                return redirect()->route('admin.pathaocourier.index')
                    ->with('error', 'Token generation failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.pathaocourier.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
