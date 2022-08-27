<?php

namespace App\Filament\Resources\RobotIntentResource\Pages;

use App\Filament\Resources\RobotIntentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRobotIntents extends ListRecords
{
    protected static string $resource = RobotIntentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
