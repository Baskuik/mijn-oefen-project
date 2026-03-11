<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;

class EditWebsite extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationLabel = 'Website bewerken';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $title = 'Website bewerken';

    // Filament v5: non-static $view
    protected string $view = 'filament.pages.edit-website';

    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->check() && (bool) auth()->user()->is_admin;
    }

    public function mount(): void
    {
        // Defaults voor Home
        $defaults = [
            'hero_title'           => 'Welkom bij de',
            'hero_title_highlight' => 'Pokémon go Webstore',
            'hero_subtitle'        => 'Jouw bestemming voor kwaliteitsproducten. Shop nu en profiteer van gratis verzending vanaf €50!',
            'hero_video_id'        => 'gsuG1HiS-gA',
            'feature_1_title'      => 'Gratis Verzending',
            'feature_1_text'       => 'Vanaf €50 bezorgen we gratis bij je thuis',
            'feature_2_title'      => 'Veilig Betalen',
            'feature_2_text'       => 'Beveiligd met Stripe & SSL encryptie',
            'feature_3_title'      => '24/7 Support',
            'feature_3_text'       => 'Wij staan altijd voor je klaar',

            // Cart
            'cart_title'           => 'Jouw winkelwagen',
            'cart_empty_text'      => 'Je winkelwagen is nog leeg.',
            'cart_cta_text'        => 'Afrekenen',
            'cart_help_text'       => 'Heb je vragen? Neem contact met ons op.',

            // Algemeen
            'site_name'            => 'MijnShop',
            'footer_text'          => '© ' . date('Y') . ' MijnShop. Alle rechten voorbehouden.',
        ];

        $values = [];
        foreach ($defaults as $key => $default) {
            $values[$key] = SiteSetting::get($key, $default);
        }

        $this->form->fill($values);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Pagina’s')
                    ->tabs([
                        // HOME
                        Tab::make('🏠 Home')
                            ->schema([
                                Section::make('Hero sectie')
                                    ->description('Banner bovenaan de homepage.')
                                    ->icon('heroicon-o-film')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('hero_title')
                                                ->label('Titel – gewone tekst')
                                                ->placeholder('Welkom bij de')
                                                ->required(),
                                            TextInput::make('hero_title_highlight')
                                                ->label('Titel – gekleurde tekst (highlight)')
                                                ->placeholder('Pokémon go Webstore')
                                                ->required(),
                                        ]),
                                        Textarea::make('hero_subtitle')
                                            ->label('Ondertitel / beschrijving')
                                            ->rows(3)
                                            ->placeholder('Jouw bestemming voor kwaliteitsproducten…'),
                                        TextInput::make('hero_video_id')
                                            ->label('YouTube Video ID (optioneel)')
                                            ->placeholder('gsuG1HiS-gA')
                                            ->helperText('Alleen het video-ID. Voorbeeld: voor "youtube.com/watch?v=gsuG1HiS-gA" vul je "gsuG1HiS-gA" in.'),
                                    ]),

                                Section::make('Kenmerken')
                                    ->description('De drie kaarten onderaan de homepage.')
                                    ->icon('heroicon-o-star')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('feature_1_title')->label('Kenmerk 1 – Titel'),
                                            TextInput::make('feature_1_text')->label('Kenmerk 1 – Tekst'),
                                        ]),
                                        Grid::make(2)->schema([
                                            TextInput::make('feature_2_title')->label('Kenmerk 2 – Titel'),
                                            TextInput::make('feature_2_text')->label('Kenmerk 2 – Tekst'),
                                        ]),
                                        Grid::make(2)->schema([
                                            TextInput::make('feature_3_title')->label('Kenmerk 3 – Titel'),
                                            TextInput::make('feature_3_text')->label('Kenmerk 3 – Tekst'),
                                        ]),
                                    ]),
                            ]),

                        // CART
                        Tab::make('🛒 Winkelwagen')
                            ->schema([
                                Section::make('Cart pagina')
                                    ->description('Teksten voor de /cart pagina.')
                                    ->icon('heroicon-o-shopping-cart')
                                    ->schema([
                                        TextInput::make('cart_title')->label('Titel')->placeholder('Jouw winkelwagen'),
                                        Textarea::make('cart_empty_text')->label('Lege winkelwagen tekst')->rows(2),
                                        TextInput::make('cart_cta_text')->label('CTA knop tekst')->placeholder('Afrekenen'),
                                        TextInput::make('cart_help_text')->label('Hulptekst onderaan')->placeholder('Heb je vragen? Neem contact met ons op.'),
                                    ]),
                            ]),

                        // ALGEMEEN
                        Tab::make('⚙️ Algemeen')
                            ->schema([
                                Section::make('Globale instellingen')
                                    ->icon('heroicon-o-cog-6-tooth')
                                    ->schema([
                                        TextInput::make('site_name')->label('Sitenaam'),
                                        Textarea::make('footer_text')->label('Footer tekst')->rows(2),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    // Defensieve render: duidelijke fout als Blade niet gevonden wordt
    public function render(): View
    {
        $view = 'filament.pages.edit-website';

        if (! view()->exists($view)) {
            $expected = base_path('resources/views/filament/pages/edit-website.blade.php');
            abort(500, "Blade view '$view' niet gevonden. Verwacht bestand: $expected");
        }

        return view($view, [
            'this' => $this,
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value);
        }

        // Auto‑refresh preview in Blade
        $this->dispatch('site-settings-saved');

        Notification::make()
            ->title('Wijzigingen opgeslagen')
            ->body('De website is bijgewerkt.')
            ->success()
            ->send();
    }
}