<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTimeWarning;
use Illuminate\Http\Request;

class DeliveryTimeWarningController extends Controller
{
    public function index()
    {
        $deliveryWarning = DeliveryTimeWarning::first();
        return view('admin.delivery_warning.index', compact('deliveryWarning'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'button_text' => 'nullable|string|max:255',
            'warning_text' => 'nullable|string',
        ]);

        $deliveryWarning = DeliveryTimeWarning::first();

        if ($deliveryWarning) {
            $deliveryWarning->update([
                'button_text' => $request->button_text,
                'warning_text' => $request->warning_text,
            ]);
        } else {
            DeliveryTimeWarning::create([
                'button_text' => $request->button_text,
                'warning_text' => $request->warning_text,
            ]);
        }

        return redirect()->back()->with('success', 'Delivery Time Warning updated successfully!');
    }
}
