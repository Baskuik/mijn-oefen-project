<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use BackedEnum;

class EditWebsite extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'Website bewerken';
    protected static ?string $title = 'Website bewerken';
    protected string $view = 'filament.pages.edit-website';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('open_frontend')
                ->label('Open frontend bewerker')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(route('home', ['preview' => 'true']))
                ->color('primary'),
        ];
    }
}