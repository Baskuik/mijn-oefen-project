<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditWebsite extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string                $navigationLabel = 'Website Bewerken';
    protected static BackedEnum|string|null $navigationIcon  = 'heroicon-o-pencil-square';
    protected static ?string                $title           = 'Website Bewerken';
    protected string                        $view            = 'filament.pages.edit-website';
    protected static ?int                   $navigationSort  = 99;

    /** Alleen admins mogen deze pagina zien */
    public static function canAccess(): bool
    {
        return auth()->check() && (bool) auth()->user()->is_admin;
    }

    public ?array $data = [];

    public function mount(): void
    {
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
        ];

        $values = [];
        foreach ($defaults as $key => $default) {
            $values[$key] = SiteSetting::get($key, $default);
        }

        $this->form->fill($values);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Pagina\'s')
                    ->tabs([

                        Tab::make('🏠 Homepagina')
                            ->schema([

                                Section::make('Hero Sectie')
                                    ->description('De grote banner helemaal bovenaan de homepage.')
                                    ->icon('heroicon-o-film')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('hero_title')
                                                ->label('Titel – gewone tekst')
                                                ->placeholder('Welkom bij de')
                                                ->required(),

                                            TextInput::make('hero_title_highlight')
                                                ->label('Titel – gekleurde tekst (paars)')
                                                ->placeholder('Pokémon go Webstore')
                                                ->required(),
                                        ]),

                                        Textarea::make('hero_subtitle')
                                            ->label('Ondertitel / Beschrijving')
                                            ->rows(3)
                                            ->placeholder('Jouw bestemming voor kwaliteitsproducten…'),

                                        TextInput::make('hero_video_id')
                                            ->label('YouTube Video ID')
                                            ->placeholder('gsuG1HiS-gA')
                                            ->helperText(
                                                'Vul alleen het video-ID in. Voorbeeld: voor "youtube.com/watch?v=gsuG1HiS-gA" vul je "gsuG1HiS-gA" in.'
                                            ),
                                    ]),

                                Section::make('Kenmerken Sectie')
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

                        // Hier kun je later extra tabs toevoegen: 🛒 Winkelwagen, 📦 Bestellingen, etc.
                        Tab::make('🛒 Winkelwagen')
                            ->schema([
                                Section::make('Binnenkort beschikbaar')
                                    ->description('Hier komen bewerkopties voor de winkelwagen-pagina.')
                                    ->schema([]),
                            ]),

                        Tab::make('📦 Mijn Bestellingen')
                            ->schema([
                                Section::make('Binnenkort beschikbaar')
                                    ->description('Hier komen bewerkopties voor de bestellingen-pagina.')
                                    ->schema([]),
                            ]),

                    ])
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value);
        }

        Notification::make()
            ->title('Wijzigingen opgeslagen!')
            ->body('De website is bijgewerkt.')
            ->success()
            ->send();
    }
}