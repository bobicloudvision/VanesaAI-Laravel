<?php

namespace App\Filament\Resources\RobotIntentTopicResource\Pages;

use App\Filament\Resources\RobotIntentTopicResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRobotIntentTopics extends ListRecords
{
    protected static string $resource = RobotIntentTopicResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
