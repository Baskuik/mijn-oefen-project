<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Bewerken'),
            DeleteAction::make()
                ->label('Verwijderen'),
            RestoreAction::make()
                ->label('Herstellen'),
            ForceDeleteAction::make()
                ->label('Definitief verwijderen'),
        ];
    }
}