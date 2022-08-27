<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RobotIntentResource\Pages;
use App\Filament\Resources\RobotIntentResource\RelationManagers;
use App\Models\RobotIntent;
use App\Models\RobotIntentPattern;
use App\Models\RobotIntentResponse;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RobotIntentResource extends Resource
{
    protected static ?string $model = RobotIntent::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('tag')
                    ->label('Tag')
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Robot Intent Patterns')
                            ->schema([
                                Forms\Components\Repeater::make('patterns')
                                    ->relationship()
                                    ->schema([
                                    Forms\Components\TextInput::make('value')
                                        ->required(),
                                    ])
                                    ->defaultItems(1)
                                    ->disableLabel()
                                    ->required(),
                            ]),
                        Forms\Components\Section::make('Robot Intent Responses')
                            ->schema([
                                Forms\Components\Repeater::make('responses')
                                    ->relationship()
                                    ->schema([
                                    Forms\Components\TextInput::make('value')
                                        ->required(),
                                    ])
                                    ->defaultItems(1)
                                    ->disableLabel()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => fn (?RobotIntent $record) => $record === null ? 3 : 2]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn (RobotIntent $record): string => $record->created_at->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn (RobotIntent $record): string => $record->updated_at->diffForHumans()),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?RobotIntent $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('tag'),

                Tables\Columns\TextColumn::make('Patterns')
                    ->getStateUsing(fn ($record): ?string => RobotIntentPattern::where('robot_intent_id',$record->id)->count() ?? null)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('Responses')
                    ->getStateUsing(fn ($record): ?string => RobotIntentResponse::where('robot_intent_id',$record->id)->count() ?? null)
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

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
            'index' => Pages\ListRobotIntents::route('/'),
            'create' => Pages\CreateRobotIntent::route('/create'),
            'edit' => Pages\EditRobotIntent::route('/{record}/edit'),
        ];
    }
}
