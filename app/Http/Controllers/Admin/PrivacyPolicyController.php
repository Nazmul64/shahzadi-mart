<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $policies = PrivacyPolicy::latest()->get();
        return view('admin.privacypolicy.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.privacypolicy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        PrivacyPolicy::create($request->all());

        return redirect()->route('admin.privacy-policy.index')->with('success', 'Privacy Policy created successfully.');
    }

    public function edit($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        return view('admin.privacypolicy.edit', compact('policy'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        $policy = PrivacyPolicy::findOrFail($id);
        $policy->update($request->all());

        return redirect()->route('admin.privacy-policy.index')->with('success', 'Privacy Policy updated successfully.');
    }

    public function destroy($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        $policy->delete();

        return redirect()->route('admin.privacy-policy.index')->with('success', 'Privacy Policy deleted successfully.');
    }
}
