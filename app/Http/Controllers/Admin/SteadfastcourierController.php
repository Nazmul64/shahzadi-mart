<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Steadfastcourier;
use Illuminate\Http\Request;

class SteadfastcourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $steadfastcourier = Steadfastcourier::first();
        return view('admin.steadfastcourier.index', compact('steadfastcourier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.steadfastcourier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'api_key'    => 'required|string',
            'secret_key' => 'required|string',
            'url'        => 'required|url',
        ]);

        Steadfastcourier::create([
            'api_key'    => $request->api_key,
            'secret_key' => $request->secret_key,
            'url'        => $request->url,
            'status'     => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.steadfastcourier.index')
            ->with('success', 'Steadfast Courier settings saved successfully!');
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
        $steadfastcourier = Steadfastcourier::findOrFail($id);
        return view('admin.steadfastcourier.edit', compact('steadfastcourier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'api_key'    => 'required|string',
            'secret_key' => 'required|string',
            'url'        => 'required|url',
        ]);

        $steadfastcourier = Steadfastcourier::findOrFail($id);

        $steadfastcourier->update([
            'api_key'    => $request->api_key,
            'secret_key' => $request->secret_key,
            'url'        => $request->url,
            'status'     => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.steadfastcourier.index')
            ->with('success', 'Steadfast Courier settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $steadfastcourier = Steadfastcourier::findOrFail($id);
        $steadfastcourier->delete();

        return redirect()->route('admin.steadfastcourier.index')
            ->with('success', 'Steadfast Courier settings deleted successfully!');
    }
}
