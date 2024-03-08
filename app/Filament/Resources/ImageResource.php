<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageResource\Pages;
use App\Filament\Resources\ImageResource\RelationManagers;
use App\Models\Image;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImageResource extends Resource
{
    protected static ?string $model = Image::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?int $navigationSort = 4;

    // protected static ?string $navigationBadgeTooltip = 'Active Products';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('source')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\FileUpload::make('image_alt')->label('Name')
                //     ->image()
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('source')
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('source')
                        ->height('50%')
                        ->width('50%')->columnSpan(3),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('image_alt')
                            ->weight(FontWeight::Bold),
                    ]),

                ])->columnSpan(3),

            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->paginated([
                18,
                36,
                72,
                'all',
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ListImages::route('/'),
            // 'create' => Pages\CreateImage::route('/create'),
            // 'view' => Pages\ViewImage::route('/{record}'),
            // 'edit' => Pages\EditImage::route('/{record}/edit'),
        ];
    }
}
