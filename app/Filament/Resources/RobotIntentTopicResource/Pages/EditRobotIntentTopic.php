<?php

namespace App\Filament\Resources\RobotIntentTopicResource\Pages;

use App\Filament\Resources\RobotIntentTopicResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRobotIntentTopic extends EditRecord
{
    protected static string $resource = RobotIntentTopicResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
