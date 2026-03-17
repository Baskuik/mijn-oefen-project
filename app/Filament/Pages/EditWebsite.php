<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use BackedEnum;

class EditWebsite extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';
    protected string $view = 'filament.pages.edit-website';

    // NIEUW: lijst met label => url die de Blade-view gebruikt
    public array $previewPages = [];

    public function mount(): void
    {
        // Bestaande mount-logica...
        $this->previewPages = $this->getPreviewPages();
    }

    /**
     * Herbereken de paginalijst (bv. na nieuwe routes) en stuur naar de browser.
     */
    public function refreshPages(): void
    {
        $this->previewPages = $this->getPreviewPages();

        // Stuur naar de browser; de Blade luistert hierop en werkt de lijst bij.
        $this->dispatch('preview-pages-refreshed', pages: $this->previewPages);
    }

    /**
     * Roep dit aan op het einde van je save()-methode.
     * Voorbeeld:
     *   public function save(): void {
     *       // ... opslaan van settings
     *       $this->dispatch('site-settings-saved');
     *       $this->notify('success', 'Instellingen opgeslagen');
     *   }
     */

    /**
     * Vind alle GET 'web' routes zonder parameters die publiek zijn.
     * Retourneer als ['Label' => 'https://...'].
     */
    protected function getPreviewPages(): array
    {
        $pages = [];

        foreach (Route::getRoutes() as $route) {
            // Alleen GET routes in de 'web' middleware
            $methods = $route->methods();
            $middleware = method_exists($route, 'middleware') ? (array) $route->middleware() : [];

            if (!in_array('GET', $methods, true)) {
                continue;
            }
            if (!in_array('web', $middleware, true)) {
                continue;
            }

            $name = (string) $route->getName();
            $uri  = trim($route->uri(), '/');

            // Sla admin/filament/livewire/auth/system routes over
            if (
                $name && Str::startsWith($name, ['filament.', 'livewire.', 'ignition.'])
                || Str::startsWith($uri, ['filament', 'telescope', 'vendor', 'sanctum'])
                || Str::contains($uri, ['login', 'logout', 'register', 'password', 'verification', 'email'])
            ) {
                continue;
            }

            // Geen dynamische parameters in de preview
            if (Str::contains($uri, '{')) {
                continue;
            }

            // Bepaal URL en label
            $url = url($uri === '' ? '/' : '/' . $uri);
            $label = $name
                ?: ($uri === '' ? 'Home' : Str::title(str_replace(['-', '/'], ' ', $uri)));

            $pages[$label] = $url;
        }

        ksort($pages, SORT_NATURAL | SORT_FLAG_CASE);

        // Zet Home (indien aanwezig) bovenaan
        if (isset($pages['Home'])) {
            $pages = ['Home' => $pages['Home']] + array_diff_key($pages, ['Home' => true]);
        }

        return $pages;
    }
}