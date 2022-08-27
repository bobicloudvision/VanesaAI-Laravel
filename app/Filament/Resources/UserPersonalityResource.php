<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserPersonalityResource\Pages;
use App\Filament\Resources\UserPersonalityResource\RelationManagers;
use App\Models\User;
use App\Models\UserPersonality;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserPersonalityResource extends Resource
{
    protected static ?string $model = UserPersonality::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\TextInput::make('personality_key')->autofocus()->required(),
                Forms\Components\TextInput::make('personality_value')->autofocus()->required(),
                Forms\Components\Select::make('user_id')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search) => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
                    ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('personality_key'),
                Tables\Columns\TextColumn::make('personality_value'),
                // ...
            ])
            ->filters([
                Tables\Filters\Filter::make('Registered')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('user_id')),
                // ...
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
            'index' => Pages\ListUserPersonalities::route('/'),
            'create' => Pages\CreateUserPersonality::route('/create'),
            'edit' => Pages\EditUserPersonality::route('/{record}/edit'),
        ];
    }
}
