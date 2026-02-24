<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\UserResource; // Zonder 'Users' ertussen
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}