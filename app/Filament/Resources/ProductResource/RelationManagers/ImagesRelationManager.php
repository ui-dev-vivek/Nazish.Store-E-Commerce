<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\User;
use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('source')
                    ->directory('product-images')
                    ->visibility('private'),
                TextInput::make('image_alt')
                    ->label('Image Description')
                    ->required()
                    ->maxLength(100),

                Forms\Components\Toggle::make('product_images.is_thumbnail')
                    ->label('Is Thumbnail')
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(False)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('source')
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('source')
                        ->height('100%')
                        ->width('100%'),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('image_alt')
                            ->weight(FontWeight::Bold),

                    ]),

                ])->columnSpan(3),

            ])
            ->filters([
                //
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
