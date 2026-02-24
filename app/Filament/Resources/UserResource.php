<?php

namespace App\Filament\Resources; // Namespace MOET nu dit zijn

use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
// We importeren de pagina's uit de submap die is blijven staan
use App\Filament\Resources\Users\Pages; 

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    
    // We forceren de naam van de route
    protected static ?string $slug = 'users';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-users';
    }

    public static function form(Schema $schema): Schema
    {
        return \App\Filament\Resources\Users\Schemas\UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\Users\Tables\UsersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'), // Als dit CreateUser is, moet het bestand ook zo heten
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}