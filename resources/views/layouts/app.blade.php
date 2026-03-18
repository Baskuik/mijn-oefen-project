@if(auth()->user()?->hasRole('admin') && request('edit_mode') == 'active')
    <div style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">
        <div style="background: #111827; color: white; padding: 12px 24px; border-radius: 50px; display: flex; gap: 20px; align-items: center; shadow: 0 10px 25px rgba(0,0,0,0.3);">
            <span style="font-weight: bold; font-size: 14px;">🛠 Editor Modus Actief</span>
            <button onclick="window.location.href='{{ route('home') }}'" style="background: #374151; padding: 6px 12px; border-radius: 6px; font-size: 12px;">Stoppen</button>
        </div>
    </div>

    <style>
        /* Maak alle teksten die bewerkbaar zijn herkenbaar */
        .editable-field:hover {
            outline: 2px dashed #fbbf24;
            cursor: pointer;
            background: rgba(251, 191, 36, 0.1);
        }
    </style>
@endif