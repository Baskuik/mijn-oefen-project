<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum; // nodig voor het union type
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
    // Filament v5: exact dezelfde type-union als de parent
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';

    // Filament v5: $view is niet-static
    protected string $view = 'filament.pages.edit-website';

    // Dropdown + preview
    public array $previewPages = [];
    public string $page = '';

    // Form state voor de actieve pagina
    public array $data = [];

    // Concepten (onopgeslagen) per pagina
    public array $pageStates = [];

    public function mount(): void
    {
        $this->previewPages = $this->getPreviewPages();

        $labels = array_keys($this->previewPages);
        $this->page = in_array('Home', $labels, true) ? 'Home' : ($labels[0] ?? 'Home');

        // Laad de state voor de startpagina
        $this->data = $this->loadStateFor($this->page);
    }

    // Dynamische form o.b.v. geselecteerde pagina
    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->schema($this->schemaFor($this->page));
    }

    // Wisselen van pagina via dropdown
    public function updatedPage(string $value): void
    {
        // 1) Bewaar huidig concept
        $this->pageStates[$this->page] = $this->data;

        // 2) Schakel naar nieuwe pagina
        $this->page = $value;

        // 3) Herstel concept of laad uit DB
        $this->data = $this->pageStates[$value] ?? $this->loadStateFor($value);

        // 4) Vul het formulier met de nieuwe state
        $this->form->fill($this->data);
    }

    // Opslaan: alleen de huidige pagina persistent maken
    public function save(): void
    {
        foreach ($this->data as $key => $value) {
            // Alles blijft flat key/value → strings of null
            SiteSetting::set($key, is_null($value) ? null : (string) $value);
        }

        // Concept up-to-date houden voor de huidige pagina
        $this->pageStates[$this->page] = $this->data;

        // Preview iframe herladen
        $this->dispatch('site-settings-saved');

        $this->notify('success', 'Instellingen voor ' . $this->page . ' opgeslagen');
    }

    public function refreshPages(): void
    {
        $this->previewPages = $this->getPreviewPages();
        $this->dispatch('preview-pages-refreshed', pages: $this->previewPages);
    }

    // ----------------- Schema & keys per pagina -----------------

    protected function schemaFor(string $label): array
    {
        $slug = Str::slug($label ?: '');

        // HOME (bestaand)
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
                            TextInput::make('feature_1_title')->label('Kolom 1 titel'),
                            TextInput::make('feature_2_title')->label('Kolom 2 titel'),
                            TextInput::make('feature_3_title')->label('Kolom 3 titel'),

                            Textarea::make('feature_1_text')->label('Kolom 1 tekst')->rows(2),
                            Textarea::make('feature_2_text')->label('Kolom 2 tekst')->rows(2),
                            Textarea::make('feature_3_text')->label('Kolom 3 tekst')->rows(2),
                        ]),
                    ]),
            ];
        }

        // PROFILE → hero + 3 tekstkolommen (volledig bewerkbaar)
        if ($slug === 'profile' || $slug === 'profiel') {
            return [
                Section::make('Profiel Hero')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        TextInput::make('profile_title')->label('Titel')->maxLength(120),
                        TextInput::make('profile_subtitle')->label('Subtitel')->maxLength(200),
                    ])
                    ->columns(2),

                Section::make('Profielteksten (3 kolommen)')
                    ->icon('heroicon-o-squares-2x2')
                    ->schema([
                        Grid::make(3)->schema([
                            // Kolom 1
                            Section::make('Kolom 1')->schema([
                                TextInput::make('profile_col1_title')->label('Titel')->maxLength(120),
                                Textarea::make('profile_col1_text')->label('Tekst')->rows(4),
                            ]),
                            // Kolom 2
                            Section::make('Kolom 2')->schema([
                                TextInput::make('profile_col2_title')->label('Titel')->maxLength(120),
                                Textarea::make('profile_col2_text')->label('Tekst')->rows(4),
                            ]),
                            // Kolom 3
                            Section::make('Kolom 3')->schema([
                                TextInput::make('profile_col3_title')->label('Titel')->maxLength(120),
                                Textarea::make('profile_col3_text')->label('Tekst')->rows(4),
                            ]),
                        ]),
                    ]),
            ];
        }

        // CART (voorbeeld)
        if ($slug === 'cart' || $slug === 'winkelwagen') {
            return [
                Section::make('Winkelwagen Teksten')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        TextInput::make('cart_title')->label('Titel')->maxLength(120),
                        Textarea::make('cart_subtitle')->label('Subtitel')->rows(3),
                    ])
                    ->columns(1),
            ];
        }

        // GENERIEKE VANGNET-SCHEMA → werkt voor ELKE andere pagina
        // keys: page_{slug}_title, page_{slug}_subtitle, page_{slug}_col{1..3}_{title|text}
        $prefix = 'page_' . ($slug ?: 'page') . '_';

        return [
            Section::make(Str::title($label) ?: 'Pagina')
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
                ])
                ->columns(1),
        ];
    }

    protected function keysFor(string $label): array
    {
        $slug = Str::slug($label ?: '');

        // HOME
        if ($slug === 'home' || $slug === '') {
            return [
                'hero_title',
                'hero_title_highlight',
                'hero_subtitle',
                'hero_video_id',
                'feature_1_title', 'feature_1_text',
                'feature_2_title', 'feature_2_text',
                'feature_3_title', 'feature_3_text',
            ];
        }

        // PROFILE
        if ($slug === 'profile' || $slug === 'profiel') {
            return [
                'profile_title',
                'profile_subtitle',
                'profile_col1_title', 'profile_col1_text',
                'profile_col2_title', 'profile_col2_text',
                'profile_col3_title', 'profile_col3_text',
            ];
        }

        // CART
        if ($slug === 'cart' || $slug === 'winkelwagen') {
            return ['cart_title', 'cart_subtitle'];
        }

        // Fallback: dynamische keys voor elke andere pagina
        $prefix = 'page_' . ($slug ?: 'page') . '_';
        return [
            $prefix . 'title',
            $prefix . 'subtitle',
            $prefix . 'col1_title', $prefix . 'col1_text',
            $prefix . 'col2_title', $prefix . 'col2_text',
            $prefix . 'col3_title', $prefix . 'col3_text',
        ];
    }

    // ----------------- Routes scannen voor preview -----------------

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

    // ----------------- State laden voor pagina -----------------

    protected function loadStateFor(string $label): array
    {
        $state = [];
        foreach ($this->keysFor($label) as $key) {
            $state[$key] = SiteSetting::get($key, '');
        }
        return $state;
    }
}