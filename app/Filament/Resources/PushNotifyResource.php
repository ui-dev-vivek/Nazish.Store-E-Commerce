<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PushNotifyResource\Pages;
use App\Filament\Resources\PushNotifyResource\RelationManagers;
use App\Models\PushNotify;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PushNotifyResource extends Resource
{
    protected static ?string $model = PushNotify::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_url')
                    ->image(),
                Forms\Components\TextInput::make('body')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('pushing_date')
                    ->required(),
                Forms\Components\TextInput::make('ref_link')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('image_url')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('body')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pushing_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ref_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPushNotifies::route('/'),
            'create' => Pages\CreatePushNotify::route('/create'),
            'view' => Pages\ViewPushNotify::route('/{record}'),
            'edit' => Pages\EditPushNotify::route('/{record}/edit'),
        ];
    }
}
