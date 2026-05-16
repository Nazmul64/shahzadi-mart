<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::latest()->paginate(20);
        return view('admin.banks.index', compact('banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:banks,name',
        ]);

        Bank::create([
            'name' => $request->name,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'ব্যাংক সফলভাবে যুক্ত করা হয়েছে।');
    }

    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:banks,name,' . $bank->id,
        ]);

        $bank->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'ব্যাংকের নাম আপডেট করা হয়েছে।');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->back()->with('success', 'ব্যাংক মুছে ফেলা হয়েছে।');
    }

    public function toggleStatus(Bank $bank)
    {
        $bank->update([
            'is_active' => !$bank->is_active,
        ]);

        return redirect()->back()->with('success', 'ব্যাংকের স্ট্যাটাস পরিবর্তন করা হয়েছে।');
    }
}
