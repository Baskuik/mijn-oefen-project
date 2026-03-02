<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Form; // VERANDERD: In v3 gebruik je Form, niet Schema
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // FIX 1: Verwijder de '?string' type hint of gebruik de brede hint
    protected static ?string $navigationIcon = 'heroicon-o-users'; 
    // Als bovenstaande nog steeds een error geeft, gebruik: protected static $navigationIcon = 'heroicon-o-users';

    protected static ?string $slug = 'users';

    // FIX 2: De functie moet 'form(Form $form)' zijn, niet 'Schema'
    public static function form(Form $form): Form
    {
        return $form
            ->schema([ // In v3 gebruik je ->schema() in plaats van ->components()
                TextInput::make('name')->label('Naam')->required(),
                TextInput::make('email')->label('E-mail')->email()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Naam')->sortable()->searchable(),
                TextColumn::make('email')->label('E-mail')->sortable()->searchable(),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}