<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IpconfigResource\Pages;
use App\Filament\Resources\IpconfigResource\RelationManagers;
use App\Models\Ipconfig;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IpconfigResource extends Resource
{
    protected static ?string $model = Ipconfig::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';
    protected static ?string $navigationLabel = 'Visitors';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_ip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cookies_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_ip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cookies_id')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListIpconfigs::route('/'),
            'create' => Pages\CreateIpconfig::route('/create'),
            'view' => Pages\ViewIpconfig::route('/{record}'),
            'edit' => Pages\EditIpconfig::route('/{record}/edit'),
        ];
    }
}
