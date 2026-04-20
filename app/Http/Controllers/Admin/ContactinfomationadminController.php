<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contactinfomationadmin;
use Illuminate\Http\Request;

class ContactinfomationadminController extends Controller
{
    // ── Index ─────────────────────────────────────────────────────
    public function index()
    {
        $contacts = Contactinfomationadmin::latest()->get();
        return view('admin.contactinfomationadmins.index', compact('contacts'));
    }

    // ── Create ────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.contactinfomationadmins.create');
    }

    // ── Store ─────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'watsapp_url'   => 'required|string|max:255',
            'messanger_url' => 'required|string|max:255|unique:contactinfomationadmins,messanger_url',
            'phone'         => 'nullable|string|max:20',
        ], [
            'watsapp_url.required'   => 'WhatsApp URL দিন।',
            'messanger_url.required' => 'Messenger URL দিন।',
            'messanger_url.unique'   => 'এই Messenger URL আগেই ব্যবহার হয়েছে।',
        ]);

        Contactinfomationadmin::create($request->only('watsapp_url', 'messanger_url', 'phone'));

        return redirect()->route('admin.contactinfomationadmins.index')
                         ->with('success', 'Contact info সফলভাবে যোগ করা হয়েছে।');
    }

    // ── Edit ──────────────────────────────────────────────────────
    public function edit(Contactinfomationadmin $contactinfomationadmin)
    {
        return view('admin.contactinfomationadmins.edit', compact('contactinfomationadmin'));
    }

    // ── Update ────────────────────────────────────────────────────
    public function update(Request $request, Contactinfomationadmin $contactinfomationadmin)
    {
        $request->validate([
            'watsapp_url'   => 'required|string|max:255',
            'messanger_url' => 'required|string|max:255|unique:contactinfomationadmins,messanger_url,' . $contactinfomationadmin->id,
            'phone'         => 'nullable|string|max:20',
        ], [
            'watsapp_url.required'   => 'WhatsApp URL দিন।',
            'messanger_url.required' => 'Messenger URL দিন।',
            'messanger_url.unique'   => 'এই Messenger URL আগেই ব্যবহার হয়েছে।',
        ]);

        $contactinfomationadmin->update($request->only('watsapp_url', 'messanger_url', 'phone'));

        return redirect()->route('admin.contactinfomationadmins.index')
                         ->with('success', 'Contact info সফলভাবে আপডেট হয়েছে।');
    }

    // ── Destroy ───────────────────────────────────────────────────
    public function destroy(Contactinfomationadmin $contactinfomationadmin)
    {
        $contactinfomationadmin->delete();
        return redirect()->route('admin.contactinfomationadmins.index')
                         ->with('success', 'Contact info মুছে ফেলা হয়েছে।');
    }
}
