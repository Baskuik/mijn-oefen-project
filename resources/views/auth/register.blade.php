<x-guest-layout>
    <!-- Heading -->
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Account aanmaken</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Maak gratis een account aan</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" id="register-form">
        @csrf
 
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Naam')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-mailadres')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Wachtwoord')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Wachtwoord bevestigen')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Cookie Consent Checkbox -->
        <div class="flex items-start gap-3 pt-1">
            <input
                type="checkbox"
                id="cookie-checkbox"
                class="mt-1 h-4 w-4 cursor-pointer rounded border-slate-300 dark:border-slate-600 text-slate-800 focus:ring-slate-500"
                onclick="handleCookieCheckbox(event)"
                readonly
            />
            <label for="cookie-checkbox" class="text-sm text-slate-600 dark:text-slate-300 cursor-pointer select-none">
                Ik ga akkoord met het
                <span class="font-semibold text-slate-800 dark:text-slate-200 underline cursor-pointer" onclick="openCookieModal()">cookiebeleid</span>.
                <span class="text-red-500">*</span>
            </label>
        </div>

        <!-- Hidden field set after acceptance -->
        <input type="hidden" name="cookie_accepted" id="cookie-accepted-input" value="0" />

        <!-- Submit -->
        <button type="submit"
                id="register-submit-btn"
                disabled
                class="w-full flex justify-center items-center gap-2 px-4 py-3 bg-slate-800 dark:bg-slate-600 hover:bg-slate-700 dark:hover:bg-slate-500 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 disabled:opacity-50 disabled:cursor-not-allowed">
            {{ __('Registreren') }}
        </button>
    </form>

    <!-- Login link -->
    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Al een account?
        <a href="{{ route('login') }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:underline transition-colors">
            Log hier in
        </a>
    </p>

    <!-- ── Cookie Modal ── -->
    <div id="cookie-modal"
         class="fixed inset-0 z-50 hidden flex items-center justify-center p-4"
         aria-modal="true" role="dialog" aria-labelledby="cookie-modal-title">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCookieModal()"></div>

        <!-- Panel -->
        <div class="relative w-full max-w-lg bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 flex flex-col max-h-[85vh]">

            <!-- Header -->
            <div class="px-6 pt-6 pb-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between shrink-0">
                <h2 id="cookie-modal-title" class="text-lg font-bold text-slate-900 dark:text-white">🍪 Cookiebeleid</h2>
                <button onclick="closeCookieModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors" aria-label="Sluiten">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Scrollable content -->
            <div id="cookie-modal-body"
                 onscroll="checkCookieScroll()"
                 class="overflow-y-auto px-6 py-4 flex-1 text-sm text-slate-600 dark:text-slate-300 space-y-4 leading-relaxed">

                <p>Welkom bij <strong class="text-slate-800 dark:text-white">MijnShop</strong>. Wij hechten veel waarde aan jouw privacy en de bescherming van jouw persoonsgegevens. Dit cookiebeleid legt uit welke cookies wij gebruiken, waarom wij ze gebruiken en hoe jij jouw voorkeuren kunt beheren.</p>

                <h3 class="font-semibold text-slate-800 dark:text-white text-base">1. Wat zijn cookies?</h3>
                <p>Cookies zijn kleine tekstbestandjes die worden opgeslagen op jouw apparaat (computer, tablet of smartphone) wanneer je onze website bezoekt. Ze helpen ons om de website goed te laten werken, je ervaring te verbeteren en inzicht te krijgen in hoe de website wordt gebruikt.</p>

                <h3 class="font-semibold text-slate-800 dark:text-white text-base">2. Welke cookies gebruiken wij?</h3>
                <p><strong>Noodzakelijke cookies</strong><br>Deze cookies zijn essentieel voor het correct functioneren van de website. Zonder deze cookies kunnen bepaalde onderdelen van de site niet werken. Ze slaan bijvoorbeeld jouw inlogstatus op en zorgen ervoor dat jouw winkelwagen bewaard blijft.</p>
                <p><strong>Functionele cookies</strong><br>Deze cookies onthouden jouw voorkeuren, zoals de taalinstelling of het gekozen thema (licht/donker), zodat je die niet telkens opnieuw hoeft in te stellen.</p>
                <p><strong>Analytische cookies</strong><br>Wij gebruiken analytische cookies om te begrijpen hoe bezoekers de website gebruiken. De gegevens worden geanonimiseerd en worden uitsluitend gebruikt om onze dienstverlening te verbeteren. Er worden geen persoonsgegevens aan derden verkocht.</p>
                <p><strong>Marketing- en trackingcookies</strong><br>Met jouw toestemming kunnen wij cookies plaatsen om relevante advertenties te tonen op andere websites. Deze cookies volgen jouw surfgedrag over meerdere websites.</p>

                <h3 class="font-semibold text-slate-800 dark:text-white text-base">3. Hoe lang worden cookies bewaard?</h3>
                <p>De bewaartermijn verschilt per cookie. Sessiecookies worden verwijderd zodra je de browser sluit. Persistente cookies blijven gedurende een vaste periode (maximaal 12 maanden) op jouw apparaat staan, tenzij je ze eerder verwijdert.</p>

                <h3 class="font-semibold text-slate-800 dark:text-white text-base">4. Jouw rechten en keuzes</h3>
                <p>Je hebt het recht om jouw toestemming op elk moment in te trekken. Je kunt cookies beheren of verwijderen via de instellingen van jouw browser. Houd er rekening mee dat het uitschakelen van bepaalde cookies de functionaliteit van de website kan beïnvloeden.</p>

                <h3 class="font-semibold text-slate-800 dark:text-white text-base">5. Wijzigingen in dit beleid</h3>
                <p>Wij behouden ons het recht voor om dit cookiebeleid te wijzigen. De meest recente versie is altijd te vinden op onze website. Bij ingrijpende wijzigingen zullen wij je hierover informeren via e-mail of een melding op de website.</p>

                <h3 class="font-semibold text-slate-800 dark:text-white text-base">6. Contact</h3>
                <p>Heb je vragen over ons cookiebeleid? Neem dan contact met ons op via <strong class="text-slate-800 dark:text-white">info@mijnshop.nl</strong> of stuur een brief naar ons postadres. Wij helpen je graag verder.</p>

                <p class="text-xs text-slate-400 dark:text-slate-500 pt-2 border-t border-slate-100 dark:border-slate-700">Versie 1.0 — Laatst bijgewerkt: {{ now()->format('d F Y') }}</p>
            </div>

            <!-- Scroll hint -->
            <div id="cookie-scroll-hint" class="px-6 py-2 text-center text-xs text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 shrink-0">
                ↓ Scroll naar beneden om te accepteren
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between gap-3 shrink-0">
                <button onclick="closeCookieModal()"
                        class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white border border-slate-300 dark:border-slate-600 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    Annuleren
                </button>
                <button id="cookie-accept-btn"
                        onclick="acceptCookies()"
                        disabled
                        class="px-5 py-2 text-sm font-semibold bg-slate-800 dark:bg-slate-600 text-white rounded-xl hover:bg-slate-700 dark:hover:bg-slate-500 transition-colors disabled:opacity-40 disabled:cursor-not-allowed shadow-sm">
                    Accepteren
                </button>
            </div>
        </div>
    </div>

    <script>
        let cookiesAccepted = false;

        function handleCookieCheckbox(event) {
            // Prevent manual check/uncheck — only accept button controls it
            if (!cookiesAccepted) {
                event.preventDefault();
                openCookieModal();
            } else {
                // Allow unchecking to revoke consent
                cookiesAccepted = false;
                document.getElementById('cookie-accepted-input').value = '0';
                document.getElementById('register-submit-btn').disabled = true;
                document.getElementById('cookie-checkbox').checked = false;
            }
        }

        function openCookieModal() {
            const modal = document.getElementById('cookie-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            // Reset scroll and accept button state
            const body = document.getElementById('cookie-modal-body');
            body.scrollTop = 0;
            document.getElementById('cookie-accept-btn').disabled = true;
            document.getElementById('cookie-scroll-hint').classList.remove('hidden');
        }

        function closeCookieModal() {
            const modal = document.getElementById('cookie-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
            if (!cookiesAccepted) {
                document.getElementById('cookie-checkbox').checked = false;
            }
        }

        function checkCookieScroll() {
            const body = document.getElementById('cookie-modal-body');
            const acceptBtn = document.getElementById('cookie-accept-btn');
            const hint = document.getElementById('cookie-scroll-hint');
            // Allow a 10px tolerance for rounding
            const atBottom = body.scrollTop + body.clientHeight >= body.scrollHeight - 10;
            if (atBottom) {
                acceptBtn.disabled = false;
                hint.classList.add('hidden');
            }
        }

        function acceptCookies() {
            cookiesAccepted = true;
            document.getElementById('cookie-accepted-input').value = '1';
            document.getElementById('cookie-checkbox').checked = true;
            document.getElementById('register-submit-btn').disabled = false;
            closeCookieModal();
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeCookieModal();
        });
    </script>
</x-guest-layout>