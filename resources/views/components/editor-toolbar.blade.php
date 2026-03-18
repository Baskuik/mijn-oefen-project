@if(session('edit_mode'))
<div
    x-data="{
        busy: false,
        saved: false,
        async save() {
            this.busy = true;
            try {
                const settings = {};
                document.querySelectorAll('[data-edit-key]').forEach((el) => {
                    let val = '';
                    if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                        val = el.value;
                    } else if (el.isContentEditable) {
                        val = el.innerText;
                    } else {
                        val = el.textContent;
                    }
                    settings[el.dataset.editKey] = val;
                });

                const r = await fetch('{{ route('site-settings.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({ settings }),
                });

                const d = await r.json().catch(() => ({}));
                if (d && d.ok) {
                    this.saved = true;
                    setTimeout(() => { window.location.reload() }, 600);
                }
            } finally {
                this.busy = false;
            }
        },
        exit() {
            const url = new URL(window.location.href);
            url.searchParams.set('preview', 'false');
            window.location.replace(url.toString());
        }
    }"
    class="fixed top-0 inset-x-0 z-[9999] flex items-center justify-between gap-4 px-6 py-3 bg-slate-900/95 backdrop-blur-sm border-b border-white/10 shadow-xl"
    style="min-height: 56px;"
>
    <div class="flex items-center gap-3">
        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-500/20">
            <svg class="h-4 w-4 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
            </svg>
        </div>
        <div>
            <span class="text-sm font-semibold text-white">Bewerkingsmodus actief</span>
            <span class="ml-2 text-xs text-slate-400">Pas velden aan en klik op Opslaan</span>
        </div>
        <span
            x-show="saved"
            x-transition
            class="ml-3 flex items-center gap-1.5 rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-semibold text-emerald-400"
            style="display:none"
        >
            <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            Opgeslagen
        </span>
    </div>

    <div class="flex items-center gap-2">
        <button
            type="button"
            x-on:click="save()"
            x-bind:disabled="busy || saved"
            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 disabled:opacity-60 px-4 py-2 text-sm font-semibold text-white shadow transition-all focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-slate-900"
        >
            <svg x-show="busy" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
            </svg>
            <svg x-show="!busy" class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
            </svg>
            <span x-text="busy ? 'Opslaan…' : 'Opslaan'"></span>
        </button>

        <button
            type="button"
            x-on:click="exit()"
            class="inline-flex items-center gap-2 rounded-lg bg-white/10 hover:bg-white/20 px-4 py-2 text-sm font-medium text-slate-200 transition-colors focus:outline-none focus:ring-2 focus:ring-white/30"
        >
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Edit‑mode afsluiten
        </button>
    </div>
</div>

{{-- ruimte zodat de toolbar niets overlapt --}}
<div style="height: 56px;"></div>
@endif