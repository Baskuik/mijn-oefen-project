<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\UserResource; // Zonder 'Users' ertussen
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
}