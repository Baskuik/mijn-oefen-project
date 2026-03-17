<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class EditWebsite extends Page
{
    // Filament v5: hetzelfde union type als de parent
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';

    // In v5 is $view non-static
    protected string $view = 'filament.pages.edit-website';

    // Preview-pagina’s (label => url) gebruikt door de Blade view
    public array $previewPages = [];

    // Geselecteerde pagina (label uit $previewPages)
    public string $page = '';

    // Huidige formulierstate (alleen voor de geselecteerde pagina)
    public array $data = [];

    // Onopgeslagen concepten per pagina (label => state)
    public array $pageStates = [];

    public function mount(): void
    {
        $this->previewPages = $this->getPreviewPages();

        $labels = array_keys($this->previewPages);
        $this->page = in_array('Home', $labels, true) ? 'Home' : ($labels[0] ?? 'Home');

        // Laad state voor de startpagina uit de database
        $this->data = $this->loadStateFor($this->page);
    }

    // Dynamische form op basis van de geselecteerde pagina
    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->schema($this->schemaFor($this->page));
    }

    // Wanneer de gebruiker een andere pagina kiest in de dropdown
    public function updatedPage(string $value): void
    {
        // 1) Sla het huidige (onopgeslagen) concept op in het geheugen
        $this->pageStates[$this->page] = $this->data;

        // 2) Schakel naar de nieuwe pagina
        $this->page = $value;

        // 3) Herstel de state (eerst concept, anders uit DB)
        $this->data = $this->pageStates[$value] ?? $this->loadStateFor($value);

        // 4) Vul het formulier met de nieuwe state
        $this->form->fill($this->data);
    }

    // Opslaan: alleen de huidige pagina wordt naar de DB geschreven
    public function save(): void
    {
        foreach ($this->data as $key => $value) {
            SiteSetting::set($key, is_null($value) ? null : (string) $value);
        }

        // Werk het concept voor deze pagina bij
        $this->pageStates[$this->page] = $this->data;

        // Laat de preview iframe herladen
        $this->dispatch('site-settings-saved');

        $this->notify('success', 'Instellingen voor ' . $this->page . ' opgeslagen');
    }

    // Handmatige heropbouw van de paginalijst (knop in de toolbar)
    public function refreshPages(): void
    {
        $this->previewPages = $this->getPreviewPages();
        $this->dispatch('preview-pages-refreshed', pages: $this->previewPages);
    }

    // ------- Helpers: state/schemas/keys per pagina -------

    protected function loadStateFor(string $label): array
    {
        $state = [];
        foreach ($this->keysFor($label) as $key) {
            $state[$key] = SiteSetting::get($key, '');
        }
        return $state;
    }

    protected function schemaFor(string $label): array
    {
        $slug = Str::slug($label ?: '');

        if ($slug === 'home' || $slug === '') {
            return [
                Section::make('Homepage Hero')
                    ->icon('heroicon-o-bolt')
                    ->schema([
                        TextInput::make('hero_title')->label('Hero titel')->maxLength(120),
                        TextInput::make('hero_title_highlight')->label('Hero highlight')->maxLength(120),
                        Textarea::make('hero_subtitle')->label('Subtitel')->rows(3),
                        TextInput::make('hero_video_id')->label('YouTube video ID')->maxLength(32),
                    ])
                    ->columns(2),

                Section::make('Kernfeatures')
                    ->icon('heroicon-o-star')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('feature_1_title')->label('Feature 1 titel'),
                            TextInput::make('feature_2_title')->label('Feature 2 titel'),
                            TextInput::make('feature_3_title')->label('Feature 3 titel'),

                            Textarea::make('feature_1_text')->label('Feature 1 tekst')->rows(2),
                            Textarea::make('feature_2_text')->label('Feature 2 tekst')->rows(2),
                            Textarea::make('feature_3_text')->label('Feature 3 tekst')->rows(2),
                        ]),
                    ]),
            ];
        }

        if ($slug === 'profile' || $slug === 'profiel') {
            return [
                Section::make('Profielpagina')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        TextInput::make('profile_title')->label('Titel')->maxLength(120),
                        Textarea::make('profile_bio')->label('Bio')->rows(4),
                    ])
                    ->columns(1),
            ];
        }

        if ($slug === 'cart' || $slug === 'winkelwagen') {
            return [
                Section::make('Winkelwagen')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        TextInput::make('cart_title')->label('Titel')->maxLength(120),
                        Textarea::make('cart_subtitle')->label('Subtitel')->rows(3),
                    ])
                    ->columns(1),
            ];
        }

        // Fallback voor onbekende pagina’s
        return [
            Section::make(Str::title($label) ?: 'Pagina')
                ->icon('heroicon-o-document-text')
                ->schema([
                    TextInput::make('page_title')->label('Titel')->maxLength(120),
                    Textarea::make('page_subtitle')->label('Subtitel / Intro')->rows(3),
                    Textarea::make('page_body')->label('Inhoud')->rows(6),
                ])
                ->columns(1),
        ];
    }

    protected function keysFor(string $label): array
    {
        $slug = Str::slug($label ?: '');

        if ($slug === 'home' || $slug === '') {
            return [
                'hero_title',
                'hero_title_highlight',
                'hero_subtitle',
                'hero_video_id',
                'feature_1_title',
                'feature_1_text',
                'feature_2_title',
                'feature_2_text',
                'feature_3_title',
                'feature_3_text',
            ];
        }

        if ($slug === 'profile' || $slug === 'profiel') {
            return ['profile_title', 'profile_bio'];
        }

        if ($slug === 'cart' || $slug === 'winkelwagen') {
            return ['cart_title', 'cart_subtitle'];
        }

        // Fallback keys
        return ['page_title', 'page_subtitle', 'page_body'];
    }

    // Routes scannen voor publieke web GET-routes zonder parameters
    protected function getPreviewPages(): array
    {
        $pages = [];

        foreach (Route::getRoutes() as $route) {
            $methods = $route->methods();
            $middleware = method_exists($route, 'middleware') ? (array) $route->middleware() : [];

            if (! in_array('GET', $methods, true)) continue;
            if (! in_array('web', $middleware, true)) continue;

            $name = (string) $route->getName();
            $uri  = trim($route->uri(), '/');

            // Sla admin/dev/auth routes over
            if (
                ($name && Str::startsWith($name, ['filament.', 'livewire.', 'ignition.']))
                || Str::startsWith($uri, ['filament', 'telescope', 'vendor', 'sanctum'])
                || Str::contains($uri, ['login', 'logout', 'register', 'password', 'verification', 'email'])
            ) continue;

            // Geen dynamische parameters
            if (Str::contains($uri, '{')) continue;

            $url = url($uri === '' ? '/' : '/' . $uri);
            $label = $name ?: ($uri === '' ? 'Home' : Str::title(str_replace(['-', '/'], ' ', $uri)));
            $pages[$label] = $url;
        }

        ksort($pages, SORT_NATURAL | SORT_FLAG_CASE);

        // Home bovenaan houden
        if (isset($pages['Home'])) {
            $pages = ['Home' => $pages['Home']] + array_diff_key($pages, ['Home' => true]);
        }

        return $pages;
    }
}