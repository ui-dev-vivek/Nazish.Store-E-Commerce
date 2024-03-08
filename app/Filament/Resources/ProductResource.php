<?php

namespace App\Filament\Resources;


use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\PriceTagRelationManager;
use App\Models\Category;
use App\Models\Group;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group as ComponentsGroup;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    // protected static ?string $navigationGroup = 'Products';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationBadgeTooltip = 'Active Products';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', 1)->count();
    }

    public static function form(Form $form): Form
    {
        $loggedInUserId = Auth::id();
        return $form
            ->schema([
                Split::make([

                    Forms\Components\Section::make('Information')
                        ->schema([

                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('sub_title')
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('points')
                                ->required()
                                ->label('Highlights')
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Active')
                                ->onIcon('heroicon-m-check-circle')
                                ->offIcon('heroicon-m-x-circle')
                                ->onColor('success')
                                ->offColor('danger')
                                ->default(true)
                                ->required(),
                            Forms\Components\Select::make('groups')
                                ->relationship('groups', 'group_name')
                                ->searchable()
                                ->multiple()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('group_name')
                                        ->label('Group Name')
                                        ->required()
                                        ->maxLength(100),
                                    Forms\Components\TextInput::make('group_code')
                                        ->label('Group Code')
                                        ->required()
                                        ->maxLength(6)
                                        ->required()
                                        ->unique()
                                ])
                                ->required(),
                            Forms\Components\Select::make('categories')
                                ->relationship('categories', 'name')
                                ->searchable()
                                ->multiple()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Category Name')
                                        ->required()
                                        ->maxLength(100),
                                    Forms\Components\Select::make('parent')
                                        ->options(function () {
                                            return Category::where('parent', null)->pluck('name', 'id');
                                        })
                                ])
                                ->required(),
                            Forms\Components\FileUpload::make('thumbnail')
                                ->image()
                                ->directory('thumbnail/products'),
                        ])->grow(false),
                ])->from('md'),

                Forms\Components\Section::make('Descriptions')
                    ->schema([

                        Forms\Components\RichEditor::make('body')
                            ->required()
                            // ->fileAttachmentsDisk('disks')
                            ->fileAttachmentsDirectory('attachments')
                            ->fileAttachmentsVisibility('private')
                            ->columnSpanFull(),
                    ])->columns(2),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Admin')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('group.group_code')
                    ->numeric()
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priceTag.platform')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_title')
                    ->searchable()
                    ->toggleable()->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')->label('Status')
                    ->boolean()->sortable(),
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
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label('')
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
            ImagesRelationManager::class,
            PriceTagRelationManager::class

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            // 'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
