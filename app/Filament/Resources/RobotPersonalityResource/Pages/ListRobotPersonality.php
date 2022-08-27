<?php

namespace App\Filament\Resources\RobotPersonalityResource\Pages;

use App\Filament\Resources\RobotPersonalityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRobotPersonality extends ListRecords
{
    protected static string $resource = RobotPersonalityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
