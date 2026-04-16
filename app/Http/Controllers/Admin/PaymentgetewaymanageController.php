<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paymentgetewaymanage;
use Illuminate\Http\Request;

class PaymentgetewaymanageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bkash     = Paymentgetewaymanage::where('gateway_name', 'bkash')->first();
        $shurjopay = Paymentgetewaymanage::where('gateway_name', 'shurjopay')->first();

        return view('admin.paymentgetewaymanage.index', compact('bkash', 'shurjopay'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.paymentgetewaymanage.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $gateway = $request->input('gateway_name');

        $rules = [
            'gateway_name' => 'required|string',
            'username'     => 'required|string',
            'base_url'     => 'required|url',
            'password'     => 'required|string',
        ];

        if ($gateway === 'bkash') {
            $rules['app_key']    = 'required|string';
            $rules['app_secret'] = 'required|string';
        }

        if ($gateway === 'shurjopay') {
            $rules['prefix']      = 'required|string';
            $rules['success_url'] = 'required|url';
            $rules['return_url']  = 'required|url';
        }

        $validated = $request->validate($rules);
        $validated['status'] = $request->has('status') ? 1 : 0;

        Paymentgetewaymanage::create($validated);

        return redirect()->route('admin.paymentgetewaymanage.index')
            ->with('success', ucfirst($gateway) . ' gateway created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gateway = Paymentgetewaymanage::findOrFail($id);
        return view('admin.paymentgetewaymanage.show', compact('gateway'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gateway = Paymentgetewaymanage::findOrFail($id);
        return view('admin.paymentgetewaymanage.edit', compact('gateway'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gateway = Paymentgetewaymanage::findOrFail($id);

        $rules = [
            'username' => 'required|string',
            'base_url' => 'required|url',
            'password' => 'required|string',
        ];

        if ($gateway->gateway_name === 'bkash') {
            $rules['app_key']    = 'required|string';
            $rules['app_secret'] = 'required|string';
        }

        if ($gateway->gateway_name === 'shurjopay') {
            $rules['prefix']      = 'required|string';
            $rules['success_url'] = 'required|url';
            $rules['return_url']  = 'required|url';
        }

        $validated = $request->validate($rules);
        $validated['status'] = $request->has('status') ? 1 : 0;

        $gateway->update($validated);

        return redirect()->route('admin.paymentgetewaymanage.index')
            ->with('success', ucfirst($gateway->gateway_name) . ' gateway updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gateway = Paymentgetewaymanage::findOrFail($id);
        $name    = $gateway->gateway_name;
        $gateway->delete();

        return redirect()->route('paymentgetewaymanage.index')
            ->with('success', ucfirst($name) . ' gateway deleted successfully.');
    }

    /**
     * Quick toggle status via AJAX or redirect.
     */
    public function toggleStatus(string $id)
    {
        $gateway         = Paymentgetewaymanage::findOrFail($id);
        $gateway->status = $gateway->status ? 0 : 1;
        $gateway->save();

        if (request()->expectsJson()) {
            return response()->json(['status' => $gateway->status]);
        }

        return redirect()->back()->with('success', 'Gateway status updated.');
    }
}
