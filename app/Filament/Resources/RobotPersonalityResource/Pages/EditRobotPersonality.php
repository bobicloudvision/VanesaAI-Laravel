<?php

namespace App\Filament\Resources\RobotPersonalityResource\Pages;

use App\Filament\Resources\RobotPersonalityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRobotPersonality extends EditRecord
{
    protected static string $resource = RobotPersonalityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
