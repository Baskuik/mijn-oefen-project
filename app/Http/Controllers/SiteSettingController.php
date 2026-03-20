<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function upload(Request $request)
    {
        abort_if(!auth()->check() || ! (auth()->user()->is_admin ?? false), 403);

        $validated = $request->validate([
            'key'   => ['required', 'string', 'regex:/^[a-z0-9_]+$/i'],
            'image' => ['required', 'file', 'image', 'max:5120'],
        ]);

        $path = $request->file('image')->store('site-images', 'public');
        $url  = Storage::url($path);

        SiteSetting::set($validated['key'], $url);

        return response()->json(['ok' => true, 'url' => $url, 'key' => $validated['key']]);
    }
}