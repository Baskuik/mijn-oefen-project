@if(session('edit_mode') && auth()->check() && auth()->user()->is_admin)
<div
    x-data="editorToolbar()"
    x-init="init()"
    x-cloak
    class="fixed top-0 inset-x-0 z-[1000]"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mt-2 rounded-xl bg-slate-900 text-white shadow-lg ring-1 ring-white/10">
            <div class="flex items-center justify-between p-3">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-sm font-semibold">Bewerkingsmodus actief</span>
                    <span x-show="saved" class="ml-2 text-xs text-emerald-300" style="display:none">Opgeslagen ✓</span>
                    <span x-show="uploading" class="ml-2 text-xs text-sky-300" style="display:none">Afbeelding uploaden…</span>
                    <span x-show="dirtyCount>0 && !saving" class="ml-2 text-xs text-amber-300" style="display:none" x-text="dirtyCount + ' wijziging(en) onopgeslagen'"></span>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        x-on:click="save()"
                        x-bind:disabled="saving || dirtyCount===0"
                        class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 px-3 py-1.5 text-sm font-semibold text-white disabled:opacity-60 transition"
                    >
                        <svg x-show="!saving" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12V8l-6-6H6a2 2 0 00-2 2v2"/></svg>
                        <svg x-show="saving" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" style="display:none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                        <span x-text="saving ? 'Opslaan…' : 'Opslaan (Ctrl/Cmd+S)'"></span>
                    </button>

                    <button
                        type="button"
                        x-on:click="exit()"
                        class="inline-flex items-center gap-2 rounded-lg bg-slate-700 hover:bg-slate-600 px-3 py-1.5 text-sm font-semibold text-white transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Edit‑mode afsluiten
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Spacer zodat toolbar content niet overlapt -->
<div class="h-[56px]"></div>

<script>
function editorToolbar() {
    return {
        saving: false,
        saved: false,
        uploading: false,
        dirty: {},   // key -> latest value
        dirtyCount: 0,
        scopeEl: null,

        init() {
            // Scope: neem [data-edit-scope] als die bestaat, anders document
            this.scopeEl = document.querySelector('[data-edit-scope]') || document;

            // Houd alle bewerkbare tekstvelden in de gaten
            const sel = '[data-setting-key]';
            this.scopeEl.querySelectorAll(sel).forEach((el) => {
                const key = el.dataset.settingKey;
                if (!key) return;

                const handler = () => {
                    const val = this.readValue(el);
                    this.markDirty(key, val);
                };

                if (el.isContentEditable) {
                    el.addEventListener('input', handler);
                } else {
                    el.addEventListener('input', handler);
                    el.addEventListener('change', handler);
                }
            });

            // Houd alle afbeelding-upload velden in de gaten
            this.scopeEl.querySelectorAll('[data-image-key]').forEach((el) => {
                el.addEventListener('change', async (e) => {
                    const file = e.target.files && e.target.files[0];
                    if (!file) return;
                    const key = el.dataset.imageKey;
                    await this.uploadImage(key, file, el);
                });
            });

            // Ctrl/Cmd + S = opslaan
            window.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
                    e.preventDefault();
                    this.save();
                }
            });

            // Waarschuw bij verlaten met onopgeslagen wijzigingen
            window.addEventListener('beforeunload', (e) => {
                if (this.dirtyCount > 0) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            }, { passive: false });
        },

        readValue(el) {
            if (el.isContentEditable) return el.textContent;
            const tag = (el.tagName || '').toLowerCase();
            if (tag === 'textarea' || tag === 'input') return el.value;
            return el.value ?? el.textContent ?? '';
        },

        markDirty(key, val) {
            this.dirty[key] = val ?? '';
            this.dirtyCount = Object.keys(this.dirty).length;
        },

        payload() {
            return { settings: this.dirty };
        },

        async uploadImage(key, file, inputEl) {
            if (this.uploading) return;
            this.uploading = true;

            try {
                const formData = new FormData();
                formData.append('key', key);
                formData.append('image', file);

                const r = await fetch('{{ route('site-settings.upload') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                    },
                    body: formData,
                });

                if (!r.ok) {
                    let msg = 'Upload mislukt';
                    try { const j = await r.json(); if (j?.message) msg = j.message; } catch {}
                    alert(msg);
                    return;
                }

                const d = await r.json().catch(() => ({}));
                if (d && d.ok && d.url) {
                    // Update alle preview-elementen die naar deze sleutel verwijzen
                    const previewEls = document.querySelectorAll('[data-image-preview="' + key + '"]');
                    previewEls.forEach((el) => {
                        if (el.tagName === 'IMG') {
                            el.src = d.url;
                        } else {
                            el.style.backgroundImage = 'url(' + d.url + ')';
                        }
                    });

                    // Toon ook de URL in een eventueel URL-inputveld
                    const urlInputs = document.querySelectorAll('[data-setting-key="' + key + '"]');
                    urlInputs.forEach((el) => { el.value = d.url; });

                    this.saved = true;
                    setTimeout(() => { this.saved = false; }, 1200);
                }
            } finally {
                this.uploading = false;
                // Reset het file input zodat dezelfde file opnieuw gekozen kan worden
                if (inputEl) inputEl.value = '';
            }
        },

        async save() {
            if (this.dirtyCount === 0 || this.saving) return;

            this.saving = true;
            try {
                const r = await fetch('{{ route('site-settings.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify(this.payload()),
                });

                if (!r.ok) {
                    // Toon een simpele melding uit de response (indien JSON)
                    let msg = 'Opslaan mislukt';
                    try { const j = await r.json(); if (j?.message) msg = j.message; } catch {}
                    alert(msg);
                    return;
                }

                const d = await r.json().catch(() => ({}));
                if (d && d.ok) {
                    this.saved = true;
                    this.dirty = {};
                    this.dirtyCount = 0;
                    setTimeout(() => { this.saved = false }, 1200);
                }
            } finally {
                this.saving = false;
            }
        },

        exit() {
            // Herlaad dezelfde pagina met preview=false zodat middleware edit_mode wist
            const url = new URL(window.location.href);
            url.searchParams.set('preview', 'false');
            window.location.replace(url.toString());
        },
    }
}
</script>
@endif