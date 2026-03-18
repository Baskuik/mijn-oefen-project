<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings'   => ['required', 'array'],
            'settings.*' => ['nullable', 'string', 'max:5000'],
        ]);

        foreach ($validated['settings'] as $key => $value) {
            if (! preg_match('/^[a-z0-9_]+$/i', $key)) {
                continue; // alleen veilige keys
            }
            SiteSetting::set($key, $value === '' ? null : $value);
        }

        return response()->json(['ok' => true]);
    }
}