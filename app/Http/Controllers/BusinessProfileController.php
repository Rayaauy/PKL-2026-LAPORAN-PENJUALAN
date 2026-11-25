<?php

namespace App\Http\Controllers;

use App\Models\BusinessProfile;
use Illuminate\Http\Request;

class BusinessProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->businessProfile;
        return view('business.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name'    => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:1000',
            'phone'         => 'nullable|string|max:20|regex:/^[0-9\+\-\(\)\s]+$/',
            'description'   => 'nullable|string|max:2000',
        ], [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka, +, -, (, dan ).',
        ]);

        // strip_tags to prevent stored XSS
        $validated['business_name'] = strip_tags($validated['business_name']);
        $validated['owner_name']    = isset($validated['owner_name']) ? strip_tags($validated['owner_name']) : null;
        $validated['description']   = isset($validated['description']) ? strip_tags($validated['description']) : null;

        $profile = auth()->user()->businessProfile;

        if ($profile) {
            $profile->update($validated);
        } else {
            auth()->user()->businessProfile()->create($validated);
        }

        return redirect()->route('business.edit')
            ->with('success', 'Profil usaha berhasil disimpan.');
    }
}
