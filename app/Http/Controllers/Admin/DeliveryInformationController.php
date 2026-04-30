<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use Illuminate\Http\Request;

class DeliveryInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveryInfo = DeliveryInformation::first();
        return view('admin.DeliveryInformation.index', compact('deliveryInfo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deliveryInfo = DeliveryInformation::first();

        // If record already exists, redirect to edit
        if ($deliveryInfo) {
            return redirect()->route('DeliveryInformation.edit', $deliveryInfo->id)
                ->with('info', 'Delivery Information already exists. You can edit it here.');
        }

        return view('admin.DeliveryInformation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'header_title'                  => 'nullable|string|max:255',
            'home_delivery_title'           => 'nullable|string|max:255',
            'home_delivery_description'     => 'nullable|string',
            'pickup_title'                  => 'nullable|string|max:255',
            'pickup_description'            => 'nullable|string',
            'instant_download_title'        => 'nullable|string|max:255',
            'instant_download_description'  => 'nullable|string',
            'secure_title'                  => 'nullable|string|max:255',
            'secure_description'            => 'nullable|string',
            'cod_title'                     => 'nullable|string|max:255',
            'cod_description'               => 'nullable|string',
            'mobile_banking_title'          => 'nullable|string|max:255',
            'mobile_banking_description'    => 'nullable|string',
            'footer_company_information'    => 'nullable|string',
        ]);

        DeliveryInformation::create($request->all());

        return redirect()->route('admin.DeliveryInformation.index')
            ->with('success', 'Delivery Information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $deliveryInfo = DeliveryInformation::findOrFail($id);
        return view('admin.DeliveryInformation.show', compact('deliveryInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $deliveryInfo = DeliveryInformation::findOrFail($id);
        return view('admin.DeliveryInformation.edit', compact('deliveryInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'header_title'                  => 'nullable|string|max:255',
            'home_delivery_title'           => 'nullable|string|max:255',
            'home_delivery_description'     => 'nullable|string',
            'pickup_title'                  => 'nullable|string|max:255',
            'pickup_description'            => 'nullable|string',
            'instant_download_title'        => 'nullable|string|max:255',
            'instant_download_description'  => 'nullable|string',
            'secure_title'                  => 'nullable|string|max:255',
            'secure_description'            => 'nullable|string',
            'cod_title'                     => 'nullable|string|max:255',
            'cod_description'               => 'nullable|string',
            'mobile_banking_title'          => 'nullable|string|max:255',
            'mobile_banking_description'    => 'nullable|string',
            'footer_company_information'    => 'nullable|string',
        ]);

        $deliveryInfo = DeliveryInformation::findOrFail($id);
        $deliveryInfo->update($request->all());

        return redirect()->route('admin.DeliveryInformation.index')
            ->with('success', 'Delivery Information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deliveryInfo = DeliveryInformation::findOrFail($id);
        $deliveryInfo->delete();

        return redirect()->route('DeliveryInformation.index')
            ->with('success', 'Delivery Information deleted successfully.');
    }
}
