<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum; // needed for the union type below
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
    // Must match Filament\Pages\Page exactly
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';

    // In Filament v5 this is NON-static
    protected string $view = 'filament.pages.edit-website';

    // Form state
    public ?array $data = [];

    // Pages for the live preview (label => url)
    public array $previewPages = [];

    public static function canAccess(): bool
    {
        // Adjust to your needs (optional)
        return auth()->check() && (auth()->user()->is_admin ?? false);
    }

    public function mount(): void
    {
        // Prefill from key/value SiteSetting table (pluck value by key)
        $this->data = SiteSetting::query()->pluck('value', 'key')->toArray();

        // Build initial preview pages from routes
        $this->previewPages = $this->getPreviewPages();
    }

    // Filament v5 style: use Schemas (container components) + Forms inputs
    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->schema([
                Section::make('Homepage Hero')
                    ->icon('heroicon-o-bolt')
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
                        TextInput::make('hero_video_id')
                            ->label('YouTube video ID')
                            ->maxLength(32),
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
            ]);
    }

    public function save(): void
    {
        if (! is_array($this->data)) {
            $this->data = [];
        }

        foreach ($this->data as $key => $value) {
            SiteSetting::set($key, is_null($value) ? null : (string) $value);
        }

        // Let the client reload the preview iframe
        $this->dispatch('site-settings-saved');
    }

    public function refreshPages(): void
    {
        $this->previewPages = $this->getPreviewPages();
        // Send to browser; Blade listens and updates the selector + reloads preview
        $this->dispatch('preview-pages-refreshed', pages: $this->previewPages);
    }

    /**
     * Find all public GET "web" routes without parameters (no {id} etc.).
     * Returns ['Home' => 'https://…', 'Cart' => 'https://…', ...].
     */
    protected function getPreviewPages(): array
    {
        $pages = [];

        foreach (Route::getRoutes() as $route) {
            $methods = $route->methods();
            $middleware = method_exists($route, 'middleware') ? (array) $route->middleware() : [];

            if (! in_array('GET', $methods, true)) {
                continue;
            }
            if (! in_array('web', $middleware, true)) {
                continue;
            }

            $name = (string) $route->getName();
            $uri  = trim($route->uri(), '/');

            // Skip admin/dev/auth routes
            if (
                ($name && Str::startsWith($name, ['filament.', 'livewire.', 'ignition.']))
                || Str::startsWith($uri, ['filament', 'telescope', 'vendor', 'sanctum'])
                || Str::contains($uri, ['login', 'logout', 'register', 'password', 'verification', 'email'])
            ) {
                continue;
            }

            // Skip dynamic routes (with params)
            if (Str::contains($uri, '{')) {
                continue;
            }

            $url = url($uri === '' ? '/' : '/' . $uri);
            $label = $name ?: ($uri === '' ? 'Home' : Str::title(str_replace(['-', '/'], ' ', $uri)));
            $pages[$label] = $url;
        }

        ksort($pages, SORT_NATURAL | SORT_FLAG_CASE);

        // Keep Home first
        if (isset($pages['Home'])) {
            $pages = ['Home' => $pages['Home']] + array_diff_key($pages, ['Home' => true]);
        }

        return $pages;
    }
}