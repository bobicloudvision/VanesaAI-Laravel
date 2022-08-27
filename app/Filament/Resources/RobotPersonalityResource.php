<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RobotPersonalityResource\Pages;
use App\Filament\Resources\RobotPersonalityResource\RelationManagers;
use App\Models\RobotPersonality;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RobotPersonalityResource extends Resource
{
    protected static ?string $model = RobotPersonality::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListRobotPersonality::route('/'),
            'create' => Pages\CreateRobotPersonality::route('/create'),
            'edit' => Pages\EditRobotPersonality::route('/{record}/edit'),
        ];
    }
}
