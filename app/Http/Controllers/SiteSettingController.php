<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function update(Request $request)
    {
        // Extra veiligheid, naast route-middleware
        abort_if(!auth()->check() || ! (auth()->user()->is_admin ?? false), 403);

        $validated = $request->validate([
            'settings'   => ['required', 'array'],
            'settings.*' => ['nullable', 'string', 'max:16000'],
        ]);

        $count = 0;

        foreach ($validated['settings'] as $key => $value) {
            // Alleen letters/cijfers/underscore
            if (! preg_match('/^[a-z0-9_]+$/i', $key)) {
                continue;
            }
            SiteSetting::set($key, $value === '' ? null : $value);
            $count++;
        }

        return response()->json(['ok' => true, 'updated' => $count]);
    }
}