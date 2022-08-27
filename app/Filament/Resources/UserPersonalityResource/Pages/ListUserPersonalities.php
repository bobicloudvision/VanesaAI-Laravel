<?php

namespace App\Filament\Resources\UserPersonalityResource\Pages;

use App\Filament\Resources\UserPersonalityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserPersonalities extends ListRecords
{
    protected static string $resource = UserPersonalityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
