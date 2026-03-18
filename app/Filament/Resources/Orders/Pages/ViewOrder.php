<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Bewerken'),
            DeleteAction::make()
                ->label('Verwijderen')
                ->requiresConfirmation()
                ->modalHeading('Bestelling permanent verwijderen?')
                ->modalDescription('Deze actie kan niet ongedaan worden gemaakt.')
                ->modalSubmitActionLabel('Ja, verwijderen'),
        ];
    }
}