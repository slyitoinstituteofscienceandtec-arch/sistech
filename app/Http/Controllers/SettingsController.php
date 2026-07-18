<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => 'required|string',
            'institution_motto' => 'nullable|string',
            'institution_address' => 'nullable|string',
            'institution_phone' => 'nullable|string',
            'institution_phone2' => 'nullable|string',
            'institution_email' => 'nullable|email',
            'institution_website' => 'nullable|url',
            'institution_facebook' => 'nullable|url',
            'institution_twitter' => 'nullable|url',
            'institution_instagram' => 'nullable|url',
            'institution_linkedin' => 'nullable|url',
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value, 'institution');
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
