<?php

namespace App\Filament\Resources\UserPersonalityResource\Pages;

use App\Filament\Resources\UserPersonalityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserPersonality extends EditRecord
{
    protected static string $resource = UserPersonalityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
