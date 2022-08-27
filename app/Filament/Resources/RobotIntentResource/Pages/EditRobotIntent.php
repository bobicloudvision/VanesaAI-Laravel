<?php

namespace App\Filament\Resources\RobotIntentResource\Pages;

use App\Filament\Resources\RobotIntentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRobotIntent extends EditRecord
{
    protected static string $resource = RobotIntentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
