<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Bekijken'),
            DeleteAction::make()
                ->label('Verwijderen')
                ->requiresConfirmation()
                ->modalHeading('Bestelling permanent verwijderen?')
                ->modalDescription('Deze actie kan niet ongedaan worden gemaakt.')
                ->modalSubmitActionLabel('Ja, verwijderen'),
        ];
    }
}