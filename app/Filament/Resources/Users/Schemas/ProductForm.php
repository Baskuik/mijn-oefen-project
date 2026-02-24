<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                    FileUpload::make('image')
                    ->image()
                    ->disk('public') // DIT MOET ER STAAN
                    ->directory('products')
                    ->visibility('public')
                    ->preserveFilenames(),
                TextInput::make('bonus_percentage')
                    ->numeric()
                    ->default(null),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
