<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WidgetResource\Pages;
use App\Filament\Resources\WidgetResource\RelationManagers;
use App\Models\Widget;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetResource extends Resource
{
    protected static ?string $model = Widget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('wi_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('wi_image')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('wi_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ref_url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('wi_h1')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('wi_p')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('wi_p2')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('style_type')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wi_name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('wi_image'),
                Tables\Columns\TextColumn::make('wi_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ref_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wi_h1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('style_type')
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
            'index' => Pages\ListWidgets::route('/'),
            'create' => Pages\CreateWidget::route('/create'),
            'view' => Pages\ViewWidget::route('/{record}'),
            'edit' => Pages\EditWidget::route('/{record}/edit'),
        ];
    }
}
