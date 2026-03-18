<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Models\SiteSettingHistory;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class EditWebsite extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';

    protected string $view = 'filament.pages.edit-website';

    /** Preview dropdown (label => url) */
    public array $previewPages = [];

    /** Actieve pagina-label */
    public string $page = '';

    /** Huidige form-state voor actieve pagina */
    public array $data = [];

    /** Concepten per pagina (niet opgeslagen) */
    public array $pageStates = [];

    /** Laatste versiegeschiedenissen */
    public array $histories = [];

    // ─────────────────────────────────────────────
    // Lifecycle
    // ─────────────────────────────────────────────

    public function mount(): void
    {
        $this->previewPages = $this->getPreviewPages();

        $labels     = array_keys($this->previewPages);
        $this->page = in_array('Home', $labels, true) ? 'Home' : ($labels[0] ?? 'Home');
        $this->data = $this->loadStateFor($this->page);

        $this->histories = $this->getHistories();
    }

    /**
     * Livewire 4: vuurt na elke property-update.
     * Stuur een browser-event zodat Alpine de "unsaved" vlag kan tonen.
     */
    public function updated(string $property): void
    {
        if (str_starts_with($property, 'data.')) {
            $this->dispatch('site-settings-changed');
        }
    }

    // ─────────────────────────────────────────────
    // Formulier
    // ─────────────────────────────────────────────

    public function form(Schema $schema): Schema
    {
        $slug = Str::slug($this->page ?: '');

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
                                                    TextInput::make('feature_1_title')->label('Titel')->maxLength(120),
                                                    Textarea::make('feature_1_text')->label('Beschrijving')->rows(4),
                                                ]),
                                                Section::make('Feature 2')->schema([
                                                    TextInput::make('feature_2_title')->label('Titel')->maxLength(120),
                                                    Textarea::make('feature_2_text')->label('Beschrijving')->rows(4),
                                                ]),
                                                Section::make('Feature 3')->schema([
                                                    TextInput::make('feature_3_title')->label('Titel')->maxLength(120),
                                                    Textarea::make('feature_3_text')->label('Beschrijving')->rows(4),
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

    // ─────────────────────────────────────────────
    // Acties
    // ─────────────────────────────────────────────

    /** Sla pagina op + snapshot huidige staat als geschiedenis */
    public function save(): void
    {
        // 1. Snapshot ALLE huidige instellingen vóór de wijziging
        $snapshot = SiteSetting::all()->pluck('value', 'key')->toArray();

        SiteSettingHistory::create([
            'snapshot'   => $snapshot,
            'page_label' => $this->page,
            'saved_by'   => auth()->id(),
        ]);

        // Bewaar maximaal 10 versies
        $toDelete = SiteSettingHistory::orderByDesc('id')->skip(10)->pluck('id');
        if ($toDelete->isNotEmpty()) {
            SiteSettingHistory::whereIn('id', $toDelete)->delete();
        }

        // 2. Sla de nieuwe waarden op
        foreach ($this->data as $key => $value) {
            SiteSetting::set($key, is_null($value) ? null : (string) $value);
        }

        $this->pageStates[$this->page] = $this->data;
        $this->histories = $this->getHistories();

        $this->dispatch('site-settings-saved');

        Notification::make()
            ->title('Wijzigingen opgeslagen')
            ->body('De aanpassingen zijn live op de website.')
            ->success()
            ->send();
    }

    /** Herstel een eerdere versie */
    public function rollback(int $historyId): void
    {
        $history = SiteSettingHistory::find($historyId);

        if (! $history) {
            Notification::make()
                ->title('Versie niet gevonden')
                ->danger()
                ->send();
            return;
        }

        // Snapshot van de HUIDIGE staat vóór we terugzetten
        $snapshot = SiteSetting::all()->pluck('value', 'key')->toArray();
        SiteSettingHistory::create([
            'snapshot'   => $snapshot,
            'page_label' => '(voor rollback)',
            'saved_by'   => auth()->id(),
        ]);

        // Herstel alle waarden uit de snapshot
        foreach ($history->snapshot as $key => $value) {
            SiteSetting::set($key, $value);
        }

        // Herlaad de form-state voor de actieve pagina
        $this->data = $this->loadStateFor($this->page);
        $this->pageStates = [];
        $this->histories = $this->getHistories();

        $this->dispatch('site-settings-saved');

        Notification::make()
            ->title('Versie hersteld')
            ->body('De website is teruggezet naar de versie van ' . $history->created_at->format('d-m-Y H:i') . '.')
            ->success()
            ->send();
    }

    /** Dropdown wijziging: concept bewaren, nieuwe pagina laden */
    public function updatedPage(string $value): void
    {
        $this->pageStates[$this->page] = $this->data;
        $this->page = $value;
        $this->data = $this->pageStates[$value] ?? $this->loadStateFor($value);
    }

    /** Preview-paginalijst verversen */
    public function refreshPages(): void
    {
        $this->previewPages = $this->getPreviewPages();
        $this->dispatch('preview-pages-refreshed', pages: $this->previewPages);
    }

    // ─────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────

    protected function getHistories(): array
    {
        return SiteSettingHistory::with('editor')
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->toArray();
    }

    protected function schemaFor(string $label): array
    {
        $slug = Str::slug($label ?: '');

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

        if (in_array($slug, ['cart', 'winkelwagen'], true)) {
            return [
                Section::make('Winkelwagen Teksten')
                    ->icon('heroicon-o-shopping-cart')
                    ->schema([
                        TextInput::make('cart_title')->label('Titel')->maxLength(120),
                        Textarea::make('cart_subtitle')->label('Subtitel')->rows(3),
                    ]),
            ];
        }

        $prefix = 'page_' . ($slug ?: 'page') . '_';

        return [
            Section::make(Str::title($label) ?: 'Pagina')
                ->icon('heroicon-o-document-text')
                ->schema([
                    TextInput::make($prefix . 'title')->label('Titel')->maxLength(120),
                    TextInput::make($prefix . 'subtitle')->label('Subtitel')->maxLength(200),
                    Section::make('Tekstkolommen (3)')->icon('heroicon-o-squares-2x2')->schema([
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

    protected function getPreviewPages(): array
    {
        $pages = [];

        foreach (Route::getRoutes() as $route) {
            $methods    = $route->methods();
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

            $url   = url($uri === '' ? '/' : '/' . $uri);
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