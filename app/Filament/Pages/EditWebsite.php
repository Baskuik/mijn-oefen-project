<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class EditWebsite extends Page
{
    // Moet exact matchen met Filament\Pages\Page
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';

    // In Filament v5 is $view niet static
    protected string $view = 'filament.pages.edit-website';

    // Preview keuzelijst (label => url)
    public array $previewPages = [];

    // Geselecteerde pagina (label)
    public string $page = '';

    // Huidige formulierstate (enkel voor geselecteerde pagina)
    public array $data = [];

    // Onopgeslagen concepten per pagina (label => state)
    public array $pageStates = [];

    public function mount(): void
    {
        $this->previewPages = $this->getPreviewPages();

        $labels = array_keys($this->previewPages);
        $this->page = in_array('Home', $labels, true) ? 'Home' : ($labels[0] ?? 'Home');

        $this->data = $this->loadStateFor($this->page);
    }

    // Filament v5: Schema i.p.v. Forms\Form, containers uit Schemas\Components, inputs uit Forms\Components
    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->schema($this->schemaFor($this->page));
    }

    // Bij wisselen van dropdown: concept bewaren en nieuwe state laden
    public function updatedPage(string $value): void
    {
        $this->pageStates[$this->page] = $this->data;
        $this->page = $value;
        $this->data = $this->pageStates[$value] ?? $this->loadStateFor($value);
        $this->form->fill($this->data);
        // Client-iframe herlaadt zichzelf al op page-wissel via Alpine watcher
    }

    // Alleen de huidige pagina opslaan
    public function save(): void
    {
        foreach ($this->data as $key => $value) {
            SiteSetting::set($key, is_null($value) ? null : (string) $value);
        }

        $this->pageStates[$this->page] = $this->data;

        $this->dispatch('site-settings-saved');

        Notification::make()
            ->title("Instellingen voor {$this->page} opgeslagen")
            ->success()
            ->send();
    }

    // Lijst van pagina’s opnieuw opbouwen (knop in toolbar)
    public function refreshPages(): void
    {
        $this->previewPages = $this->getPreviewPages();
        $this->dispatch('preview-pages-refreshed', pages: $this->previewPages);
    }

    // ---------- Per-pagina schema en keys ----------

    protected function schemaFor(string $label): array
    {
        $slug = Str::slug($label ?: '');

        // HOME
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

                Section::make('Kernfeatures (3 kolommen)')
                    ->icon('heroicon-o-star')
                    ->schema([
                        Grid::make(3)->schema([
                            Section::make('Kolom 1')->schema([
                                TextInput::make('feature_1_title')->label('Titel')->maxLength(120),
                                Textarea::make('feature_1_text')->label('Tekst')->rows(4),
                            ]),
                            Section::make('Kolom 2')->schema([
                                TextInput::make('feature_2_title')->label('Titel')->maxLength(120),
                                Textarea::make('feature_2_text')->label('Tekst')->rows(4),
                            ]),
                            Section::make('Kolom 3')->schema([
                                TextInput::make('feature_3_title')->label('Titel')->maxLength(120),
                                Textarea::make('feature_3_text')->label('Tekst')->rows(4),
                            ]),
                        ]),
                    ]),
            ];
        }

        // PROFILE
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
        if ($slug === 'cart' || $slug === 'winkelwagen') {
            return [
                Section::make('Winkelwagen Teksten')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        TextInput::make('cart_title')->label('Titel')->maxLength(120),
                        Textarea::make('cart_subtitle')->label('Subtitel')->rows(3),
                    ]),
            ];
        }

        // GENERIEKE fallback voor ELKE andere pagina (About, Contact, etc.)
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

        if ($slug === 'profile' || $slug === 'profiel') {
            return [
                'profile_title', 'profile_subtitle',
                'profile_col1_title', 'profile_col1_text',
                'profile_col2_title', 'profile_col2_text',
                'profile_col3_title', 'profile_col3_text',
            ];
        }

        if ($slug === 'cart' || $slug === 'winkelwagen') {
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

    // ---------- Preview: publieke GET web-routes zonder parameters ----------

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

            if (
                ($name && Str::startsWith($name, ['filament.', 'livewire.', 'ignition.']))
                || Str::startsWith($uri, ['filament', 'telescope', 'vendor', 'sanctum'])
                || Str::contains($uri, ['login', 'logout', 'register', 'password', 'verification', 'email'])
            ) continue;

            if (Str::contains($uri, '{')) continue;

            $url = url($uri === '' ? '/' : '/' . $uri);
            $label = $name ?: ($uri === '' ? 'Home' : Str::title(str_replace(['-', '/'], ' ', $uri)));
            $pages[$label] = $url;
        }

        ksort($pages, SORT_NATURAL | SORT_FLAG_CASE);

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