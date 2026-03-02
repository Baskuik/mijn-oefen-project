<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationLabel = 'Gebruikers';

    protected static ?string $modelLabel = 'Gebruiker';

    protected static ?string $pluralModelLabel = 'Gebruikers';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-users';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Gebruikersinformatie')
                    ->description('Beheer de basisinformatie van de gebruiker')
                    ->schema([
                        TextInput::make('name')
                            ->label('Naam')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('email')
                            ->label('E-mailadres')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('password')
                            ->label('Wachtwoord')
                            ->password()
                            ->revealable()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(8)
                            ->maxLength(255)
                            ->helperText('Minimaal 8 tekens. Laat leeg om ongewijzigd te laten.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Status en Machtigingen')
                    ->description('Bepaal de status en rol van deze gebruiker')
                    ->schema([
                        Toggle::make('user_active')
                            ->label('Gebruiker Actief')
                            ->helperText('Inactieve gebruikers kunnen niet meer inloggen')
                            ->inline(false)
                            ->default(true),

                        Toggle::make('is_admin')
                            ->label('Administrator')
                            ->helperText('Administrators hebben volledige toegang tot het admin panel')
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('user_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->tooltip(fn (User $record): string => $record->user_active ? 'Actief' : 'Inactief'),

                TextColumn::make('name')
                    ->label('Naam')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('E-mailadres')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                IconColumn::make('is_admin')
                    ->label('Rol')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-user')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable()
                    ->tooltip(fn (User $record): string => $record->is_admin ? 'Administrator' : 'Gebruiker'),

                IconColumn::make('email_verified_at')
                    ->label('E-mail Geverifieerd')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(fn (User $record): string => 
                        $record->email_verified_at 
                            ? 'Geverifieerd op ' . $record->email_verified_at->format('d-m-Y H:i')
                            : 'Niet geverifieerd'
                    ),

                TextColumn::make('created_at')
                    ->label('Aangemaakt')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('user_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Actief',
                        '0' => 'Inactief',
                    ])
                    ->placeholder('Alle statussen'),

                SelectFilter::make('is_admin')
                    ->label('Rol')
                    ->options([
                        '1' => 'Administrator',
                        '0' => 'Gebruiker',
                    ])
                    ->placeholder('Alle rollen'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Bewerken'),
                DeleteAction::make()
                    ->label('Verwijderen')
                    ->requiresConfirmation()
                    ->modalHeading('Gebruiker permanent verwijderen?')
                    ->modalDescription('Deze actie kan niet ongedaan worden gemaakt.')
                    ->modalSubmitActionLabel('Ja, verwijderen'),
            ])
            ->groupedBulkActions([
                BulkAction::make('activate')
                    ->label('Activeren')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        $records->each(function ($record) {
                            $record->update(['user_active' => true]);
                        });
                    })
                    ->deselectRecordsAfterCompletion(),
                    
                BulkAction::make('deactivate')
                    ->label('Deactiveren')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        $records->each(function ($record) {
                            $record->update(['user_active' => false]);
                        });
                    })
                    ->deselectRecordsAfterCompletion(),
                    
                BulkAction::make('delete')
                    ->label('Permanent verwijderen')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Gebruikers permanent verwijderen?')
                    ->modalDescription('Deze actie kan niet ongedaan worden gemaakt.')
                    ->action(fn ($records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([25, 50, 100, 500])
            ->poll('30s')
            ->striped()
            ->deferLoading();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}