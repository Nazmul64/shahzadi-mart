<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contact.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contact_number'      => 'required|string|max:20',
            'address'             => 'required|string',
            'email'               => 'required|email|max:255',
            'google_map_embed_code' => 'nullable|string',
        ]);

        Contact::create([
            'contact_number'        => $request->contact_number,
            'address'               => $request->address,
            'email'                 => $request->email,
            'google_map_embed_code' => $request->google_map_embed_code,
        ]);

        return redirect()->route('admin.contact.index')
                         ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contact.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'contact_number'        => 'required|string|max:20',
            'address'               => 'required|string',
            'email'                 => 'required|email|max:255',
            'google_map_embed_code' => 'nullable|string',
        ]);

        $contact = Contact::findOrFail($id);

        $contact->update([
            'contact_number'        => $request->contact_number,
            'address'               => $request->address,
            'email'                 => $request->email,
            'google_map_embed_code' => $request->google_map_embed_code,
        ]);

        return redirect()->route('admin.contact.index')
                         ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contact.index')
                         ->with('success', 'Contact deleted successfully.');
    }
}
