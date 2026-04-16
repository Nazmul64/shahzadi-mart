<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pathaocourier;
use Illuminate\Http\Request;

class PathaocourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pathaocourier = Pathaocourier::first();
        return view('admin.pathaocourier.index', compact('pathaocourier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pathaocourier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url'   => 'required|url',
            'token' => 'required|string',
        ]);

        Pathaocourier::create([
            'url'    => $request->url,
            'token'  => $request->token,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.pathaocourier.index')
            ->with('success', 'Pathao Courier settings saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pathaocourier = Pathaocourier::findOrFail($id);
        return view('admin.pathaocourier.edit', compact('pathaocourier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'url'   => 'required|url',
            'token' => 'required|string',
        ]);

        $pathaocourier = Pathaocourier::findOrFail($id);

        $pathaocourier->update([
            'url'    => $request->url,
            'token'  => $request->token,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.pathaocourier.index')
            ->with('success', 'Pathao Courier settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pathaocourier = Pathaocourier::findOrFail($id);
        $pathaocourier->delete();

        return redirect()->route('admin.pathaocourier.index')
            ->with('success', 'Pathao Courier settings deleted successfully!');
    }
}
