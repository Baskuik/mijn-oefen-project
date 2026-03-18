<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class EditWebsite extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static string $view = 'filament.pages.edit-website';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('naar_editor')
                ->label('Open Website Editor')
                ->icon('heroicon-m-arrow-top-right-on-square')
                ->color('primary')
                ->url(fn () => route('home', ['edit_mode' => 'active'])), 
        ];
    }
}