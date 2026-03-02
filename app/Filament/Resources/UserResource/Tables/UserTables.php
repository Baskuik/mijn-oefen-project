<?php

namespace App\Filament\Resources\UserResource\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UserTables
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}