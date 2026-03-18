<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;

class EditWebsite extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-pencil-square';

    protected string $view = 'filament.pages.edit-website';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('open_frontend_editor')
                ->label('Website bewerken (frontend)')
                ->url(route('home', ['preview' => 'true']))
                ->openUrlInNewTab()
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('primary'),
        ];
    }
}