<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('Categorie'),

                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->unique('products', 'slug', ignoreRecord: true),

                Textarea::make('description')
                    ->label('Omschrijving'),

                TextInput::make('price')
                    ->numeric()
                    ->prefix('€')
                    ->required(),

                TextInput::make('bonus_percentage')
                    ->numeric()
                    ->suffix('%')
                    ->label('Bonus Percentage'),

                FileUpload::make('image')
                    ->image()
                    ->directory('products'),

                Toggle::make('is_featured')
                    ->label('Toon op voorpagina'),
            ]);
    }
}