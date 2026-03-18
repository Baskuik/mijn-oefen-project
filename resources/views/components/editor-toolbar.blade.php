@if(session('edit_mode') && auth()->check() && auth()->user()->is_admin)
<div id="editor-toolbar" style="position:fixed;top:0;left:0;right:0;z-index:9999;">
    <form method="POST" action="{{ route('edit-mode.save') }}" id="editor-toolbar-form">
        @csrf
        {{-- De inline-input-velden injecteren hun waarden hier via JavaScript --}}

        <div style="
            display: flex;
            align-items: center;
            gap: 12px;
            background: #1e293b;
            color: #f8fafc;
            padding: 10px 20px;
            font-family: system-ui, sans-serif;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,.4);
        ">
            <span style="font-weight:600; color:#818cf8;">&#9998; Edit-modus</span>

            <span style="margin-left:auto; display:flex; align-items:center; gap:8px;">
                @if(session('edit_mode_saved'))
                    <span style="color:#4ade80; font-size:13px;">&#10003; Opgeslagen!</span>
                @endif

                <button
                    type="submit"
                    style="
                        background:#4f46e5; color:#fff; border:none; border-radius:6px;
                        padding:7px 16px; cursor:pointer; font-weight:600; font-size:13px;
                    "
                    onmouseover="this.style.background='#4338ca'"
                    onmouseout="this.style.background='#4f46e5'"
                >
                    Opslaan
                </button>

                <a
                    href="{{ route('edit-mode.exit') }}"
                    style="
                        background:#374151; color:#d1d5db; border-radius:6px;
                        padding:7px 16px; text-decoration:none; font-weight:600; font-size:13px;
                    "
                    onmouseover="this.style.background='#4b5563'"
                    onmouseout="this.style.background='#374151'"
                >
                    Edit-modus afsluiten
                </a>
            </span>
        </div>
    </form>
</div>

{{-- Zorg voor ruimte onder de toolbar zodat de pagina-inhoud niet verborgen raakt --}}
<div style="height:48px;"></div>

<script>
    /**
     * Voordat het opslaan-formulier verstuurd wordt, kopieer de huidige
     * waarden van alle [data-setting] velden als hidden inputs naar het formulier.
     */
    document.getElementById('editor-toolbar-form').addEventListener('submit', function () {
        document.querySelectorAll('[data-setting]').forEach(function (el) {
            var key   = el.getAttribute('data-setting');
            var value = el.tagName === 'INPUT' || el.tagName === 'TEXTAREA'
                ? el.value
                : el.innerText;

            var hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = key;
            hidden.value = value;
            document.getElementById('editor-toolbar-form').appendChild(hidden);
        });
    });
</script>
@endif