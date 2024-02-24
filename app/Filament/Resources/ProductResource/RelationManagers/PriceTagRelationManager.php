<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PriceTagRelationManager extends RelationManager
{
    protected static string $relationship = 'priceTag';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('platform')
                    ->options([
                        'Flipkart' => 'Flipkart',
                        'Meesho' => 'Meesho',
                        'Amazon' => 'Amazon',
                        'Other' => 'other'
                    ]),
                TextInput::make('price')->numeric()->required(),
                Select::make('discount_type')
                    ->options([
                        'Per' => '%',
                        'num' => 'Number',

                    ]),
                TextInput::make('discount')->numeric()->required(),
                Forms\Components\TextInput::make('ref_link')
                    ->required()
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('platform')
            ->columns([
                Tables\Columns\TextColumn::make('platform'),
                Tables\Columns\TextColumn::make('price')
                    ->icon('heroicon-o-currency-rupee')
                    ->iconColor('success'),
                Tables\Columns\TextColumn::make('discount')




            ])
            ->filters([
                //
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
