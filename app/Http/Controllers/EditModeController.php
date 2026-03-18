<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class EditModeController extends Controller
{
    /**
     * Sla de inline-bewerkte instellingen op vanuit de frontend toolbar.
     * Alleen toegankelijk voor admins met actieve edit_mode.
     */
    public function save(Request $request)
    {
        $allowed = [
            'hero_title',
            'hero_title_highlight',
            'hero_subtitle',
            'hero_video_id',
            'feature_1_title', 'feature_1_text',
            'feature_2_title', 'feature_2_text',
            'feature_3_title', 'feature_3_text',
        ];

        foreach ($allowed as $key) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key));
            }
        }

        return back()->with('edit_mode_saved', true);
    }

    /**
     * Verlaat de edit-modus en ga terug naar de homepage.
     */
    public function exit()
    {
        session()->forget('edit_mode');

        return redirect()->route('home');
    }
}