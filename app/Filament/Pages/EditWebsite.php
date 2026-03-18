<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class EditWebsite extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $title = 'Website bewerken (Frontend Editing)';
    protected static string $view = 'filament.pages.edit-website';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('open_frontend_editor')
                ->label('Open frontend editor')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(route('home', ['preview' => 'true']))
                ->color('primary'),
        ];
    }
}