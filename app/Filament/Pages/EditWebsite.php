<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class EditWebsite extends Page
{
    // Filament v5: zelfde union type als parent
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';

    // Filament v5: $view is non-static
    protected string $view = 'filament.pages.edit-website';

    // Preview dropdown + iframe (label => url)
    public array $previewPages = [];

    // Actieve pagina (label uit $previewPages)
    public string $page = '';

    // Huidige form-state (enkel voor actieve pagina)
    public array $data = [];

    // Concepten per pagina (onopgeslagen; label => state)
    public array $pageStates = [];

    public function mount(): void
    {
        $this->previewPages = $this->getPreviewPages();

        $labels = array_keys($this->previewPages);
        $this->page = in_array('Home', $labels, true) ? 'Home' : ($labels[0] ?? 'Home');

        $this->data = $this->loadStateFor($this->page);
    }

    // Filament v5: containers uit Schemas\Components; inputs uit Forms\Components
    public function form(Schema $schema): Schema
    {
        $slug = Str::slug($this->page ?: '');

        // Home-pagina met Tabs: Hero, Features, Video
        if ($slug === 'home' || $slug === '') {
            return $schema
                ->statePath('data')
                ->schema([
                    Tabs::make('Pagina‑editor')
                        ->tabs([
                            Tab::make('Hero')
                                ->schema([
                                    Section::make('Hero')
                                        ->description('Hoofdtitel, highlight en subtitel van de hero-sectie.')
                                        ->schema([
                                            TextInput::make('hero_title')
                                                ->label('Hero titel')
                                                ->maxLength(120),
                                            TextInput::make('hero_title_highlight')
                                                ->label('Hero highlight')
                                                ->maxLength(120),
                                            Textarea::make('hero_subtitle')
                                                ->label('Subtitel')
                                                ->rows(3),
                                        ])
                                        ->columns(2),
                                ]),

                            Tab::make('Features')
                                ->schema([
                                    Section::make('Kernfeatures')
                                        ->description('Drie belangrijkste voordelen/kenmerken naast elkaar.')
                                        ->schema([
                                            Grid::make(3)->schema([
                                                Section::make('Feature 1')->schema([
                                                    TextInput::make('feature_1_title')
                                                        ->label('Titel')
                                                        ->maxLength(120),
                                                    Textarea::make('feature_1_text')
                                                        ->label('Beschrijving')
                                                        ->rows(4),
                                                ]),
                                                Section::make('Feature 2')->schema([
                                                    TextInput::make('feature_2_title')
                                                        ->label('Titel')
                                                        ->maxLength(120),
                                                    Textarea::make('feature_2_text')
                                                        ->label('Beschrijving')
                                                        ->rows(4),
                                                ]),
                                                Section::make('Feature 3')->schema([
                                                    TextInput::make('feature_3_title')
                                                        ->label('Titel')
                                                        ->maxLength(120),
                                                    Textarea::make('feature_3_text')
                                                        ->label('Beschrijving')
                                                        ->rows(4),
                                                ]),
                                            ]),
                                        ]),
                                ]),

                            Tab::make('Video')
                                ->schema([
                                    Section::make('Hero video')
                                        ->description('Optioneel: YouTube video-ID voor de hero-sectie.')
                                        ->schema([
                                            TextInput::make('hero_video_id')
                                                ->label('YouTube video ID')
                                                ->maxLength(32),
                                        ]),
                                ]),
                        ])
                        ->columnSpanFull(),
                ]);
        }

        // Voor overige pagina’s: behoud dynamisch schema maar toon in één Tab
        return $schema
            ->statePath('data')
            ->schema([
                Tabs::make('Pagina‑editor')
                    ->tabs([
                        Tab::make(Str::title($this->page ?: 'Inhoud'))
                            ->schema($this->schemaFor($this->page)),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    // Dropdown wijziging: concept bewaren, nieuwe state laden
    public function updatedPage(string $value): void
    {
        $this->pageStates[$this->page] = $this->data;
        $this->page = $value;
        $this->data = $this->pageStates[$value] ?? $this->loadStateFor($value);

        // In deze setup volstaat het wijzigen van $data; mocht je eager willen vullen:
        if (method_exists($this, 'form') && property_exists($this, 'form')) {
            try {
                $this->form->fill($this->data);
            } catch (\Throwable $e) {
                // stil doorgaan
            }
        }
    }

    // Alleen de actieve pagina opslaan
    public function save(): void
    {
        foreach ($this->data as $key => $value) {
            SiteSetting::set($key, is_null($value) ? null : (string) $value);
        }

        $this->pageStates[$this->page] = $this->data;

        // Client-iframe herladen
        $this->dispatch('site-settings-saved');
    }

    // Preview-paginalijst verversen
    public function refreshPages(): void
    {
        $this->previewPages = $this->getPreviewPages();
        $this->dispatch('preview-pages-refreshed', pages: $this->previewPages);
    }

    // ================== Schemas & keys per pagina ==================

    protected function schemaFor(string $label): array
    {
        $slug = Str::slug($label ?: '');

        // PROFILE (+ alias ‘account’/‘profiel’) — titel + 3 tekstkolommen
        if (in_array($slug, ['profile', 'profiel', 'account'], true)) {
            return [
                Section::make('Profiel Hero')
                    ->description('Titel en subtitel van de profielpagina.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        TextInput::make('profile_title')->label('Titel')->maxLength(120),
                        TextInput::make('profile_subtitle')->label('Subtitel')->maxLength(200),
                    ])
                    ->columns(2),

                Section::make('Profielteksten (3 kolommen)')
                    ->description('Beheer de drie tekstkolommen voor de profielpagina.')
                    ->icon('heroicon-o-squares-2x2')
                    ->schema([
                        Grid::make(3)->schema([
                            Section::make('Kolom 1')->schema([
                                TextInput::make('profile_col1_title')->label('Titel')->maxLength(120),
                                Textarea::make('profile_col1_text')->label('Tekst')->rows(4),
                            ]),
                            Section::make('Kolom 2')->schema([
                                TextInput::make('profile_col2_title')->label('Titel')->maxLength(120),
                                Textarea::make('profile_col2_text')->label('Tekst')->rows(4),
                            ]),
                            Section::make('Kolom 3')->schema([
                                TextInput::make('profile_col3_title')->label('Titel')->maxLength(120),
                                Textarea::make('profile_col3_text')->label('Tekst')->rows(4),
                            ]),
                        ]),
                    ]),
            ];
        }

        // CART (voorbeeld)
        if (in_array($slug, ['cart', 'winkelwagen'], true)) {
            return [
                Section::make('Winkelwagen Teksten')
                    ->description('Titel en subtitel van de winkelwagenpagina.')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        TextInput::make('cart_title')->label('Titel')->maxLength(120),
                        Textarea::make('cart_subtitle')->label('Subtitel')->rows(3),
                    ]),
            ];
        }

        // GENERIEKE fallback voor elke andere pagina
        $prefix = 'page_' . ($slug ?: 'page') . '_';

        return [
            Section::make(Str::title($label) ?: 'Pagina')
                ->description('Algemene titel, subtitel en drie tekstkolommen.')
                ->icon('heroicon-o-document-text')
                ->schema([
                    TextInput::make($prefix . 'title')->label('Titel')->maxLength(120),
                    TextInput::make($prefix . 'subtitle')->label('Subtitel')->maxLength(200),

                    Section::make('Tekstkolommen (3)')
                        ->icon('heroicon-o-squares-2x2')
                        ->schema([
                            Grid::make(3)->schema([
                                Section::make('Kolom 1')->schema([
                                    TextInput::make($prefix . 'col1_title')->label('Titel')->maxLength(120),
                                    Textarea::make($prefix . 'col1_text')->label('Tekst')->rows(4),
                                ]),
                                Section::make('Kolom 2')->schema([
                                    TextInput::make($prefix . 'col2_title')->label('Titel')->maxLength(120),
                                    Textarea::make($prefix . 'col2_text')->label('Tekst')->rows(4),
                                ]),
                                Section::make('Kolom 3')->schema([
                                    TextInput::make($prefix . 'col3_title')->label('Titel')->maxLength(120),
                                    Textarea::make($prefix . 'col3_text')->label('Tekst')->rows(4),
                                ]),
                            ]),
                        ]),
                ]),
        ];
    }

    protected function keysFor(string $label): array
    {
        $slug = Str::slug($label ?: '');

        if ($slug === 'home' || $slug === '') {
            return [
                'hero_title', 'hero_title_highlight', 'hero_subtitle', 'hero_video_id',
                'feature_1_title', 'feature_1_text',
                'feature_2_title', 'feature_2_text',
                'feature_3_title', 'feature_3_text',
            ];
        }

        if (in_array($slug, ['profile', 'profiel', 'account'], true)) {
            return [
                'profile_title', 'profile_subtitle',
                'profile_col1_title', 'profile_col1_text',
                'profile_col2_title', 'profile_col2_text',
                'profile_col3_title', 'profile_col3_text',
            ];
        }

        if (in_array($slug, ['cart', 'winkelwagen'], true)) {
            return ['cart_title', 'cart_subtitle'];
        }

        $prefix = 'page_' . ($slug ?: 'page') . '_';
        return [
            $prefix . 'title', $prefix . 'subtitle',
            $prefix . 'col1_title', $prefix . 'col1_text',
            $prefix . 'col2_title', $prefix . 'col2_text',
            $prefix . 'col3_title', $prefix . 'col3_text',
        ];
    }

    // ================== Preview-paginalijst (publieke GET web-routes) ==================

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

            // Admin/dev/auth routes overslaan
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

        // Home bovenaan
        if (isset($pages['Home'])) {
            $pages = ['Home' => $pages['Home']] + array_diff_key($pages, ['Home' => true]);
        }

        return $pages;
    }

    protected function loadStateFor(string $label): array
    {
        $state = [];
        foreach ($this->keysFor($label) as $key) {
            $state[$key] = SiteSetting::get($key, '');
        }
        return $state;
    }
}