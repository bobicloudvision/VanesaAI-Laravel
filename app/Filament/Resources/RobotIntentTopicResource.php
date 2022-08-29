<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RobotIntentTopicResource\Pages;
use App\Filament\Resources\RobotIntentTopicResource\RelationManagers;
use App\Models\RobotIntentTopic;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RobotIntentTopicResource extends Resource
{
    protected static ?string $model = RobotIntentTopic::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->autofocus()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRobotIntentTopics::route('/'),
            'create' => Pages\CreateRobotIntentTopic::route('/create'),
            'edit' => Pages\EditRobotIntentTopic::route('/{record}/edit'),
        ];
    }
}
