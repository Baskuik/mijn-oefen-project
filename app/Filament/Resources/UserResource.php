<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema; 
use Filament\Tables\Table;   
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $slug = 'users';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Naam')
                    ->required(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Naam')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                // We dwingen PHP om hier te kijken:
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // We dwingen PHP om hier te kijken:
                \Filament\Tables\Actions\DeleteBulkAction::make(),
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