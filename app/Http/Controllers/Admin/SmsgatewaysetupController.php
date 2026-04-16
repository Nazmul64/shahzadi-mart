<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Smsgatewaysetup;
use Illuminate\Http\Request;

class SmsgatewaysetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $smsgateway = Smsgatewaysetup::first();
        return view('admin.smsgatewaysetup.index', compact('smsgateway'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.smsgatewaysetup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url'       => 'required|url',
            'api_key'   => 'required|string',
            'sender_id' => 'required|string',
        ]);

        Smsgatewaysetup::create([
            'url'                => $request->url,
            'api_key'            => $request->api_key,
            'sender_id'          => $request->sender_id,
            'status'             => $request->has('status') ? 1 : 0,
            'order_confirm'      => $request->has('order_confirm') ? 1 : 0,
            'forgot_password'    => $request->has('forgot_password') ? 1 : 0,
            'password_generator' => $request->has('password_generator') ? 1 : 0,
        ]);

        return redirect()->route('admin.Smsgatewaysetup.index')
                         ->with('success', 'SMS Gateway created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $smsgateway = Smsgatewaysetup::findOrFail($id);
        return view('admin.smsgatewaysetup.show', compact('smsgateway'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $smsgateway = Smsgatewaysetup::findOrFail($id);
        return view('admin.smsgatewaysetup.edit', compact('smsgateway'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'url'       => 'required|url',
            'api_key'   => 'required|string',
            'sender_id' => 'required|string',
        ]);

        $smsgateway = Smsgatewaysetup::findOrFail($id);

        $smsgateway->update([
            'url'                => $request->url,
            'api_key'            => $request->api_key,
            'sender_id'          => $request->sender_id,
            'status'             => $request->has('status') ? 1 : 0,
            'order_confirm'      => $request->has('order_confirm') ? 1 : 0,
            'forgot_password'    => $request->has('forgot_password') ? 1 : 0,
            'password_generator' => $request->has('password_generator') ? 1 : 0,
        ]);

        return redirect()->route('admin.Smsgatewaysetup.index')
                         ->with('success', 'SMS Gateway updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $smsgateway = Smsgatewaysetup::findOrFail($id);
        $smsgateway->delete();

        return redirect()->route('admin.Smsgatewaysetup.index')
                         ->with('success', 'SMS Gateway deleted successfully.');
    }
}
