<?php

namespace App\Filament\Resources\RobotIntentResource\Widgets;

use App\Models\RobotIntent;
use App\Models\RobotIntentPattern;
use App\Models\RobotIntentResponse;
use App\Models\RobotIntentTopic;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class RobotIntentStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Intents', RobotIntent::count()),
            Card::make('Total Patterns', RobotIntentPattern::count()),
            Card::make('Total Responses', RobotIntentResponse::count()),
            Card::make('Total Topics', RobotIntentTopic::count()),
        ];
    }
}
