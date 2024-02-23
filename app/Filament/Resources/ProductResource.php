<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Group;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group as ComponentsGroup;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Products';
    protected static ?string $navigationLable = 'Add Product';


    public static function form(Form $form): Form
    {
        $loggedInUserId = Auth::id();
        return $form
            ->schema([
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

                    ])->columns(2),
                Forms\Components\Section::make('Information')
                    ->schema([

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live()
                            ->columnSpanFull()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                if (($get('slug') ?? '') !== Str::slug($old)) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Product::class, 'slug', ignoreRecord: true),

                        Forms\Components\TextInput::make('sub_title')
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Maping')
                    ->schema([
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
                                    ->maxLength(100)
                                    ->live()
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Category::class, 'slug', ignoreRecord: true),
                                Forms\Components\Select::make('parent')
                                    ->options(function () {
                                        return Category::all()->pluck('name', 'id');
                                    })
                            ])
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make('Descriptions')
                    ->schema([
                        Forms\Components\MarkdownEditor::make('points')
                            ->required()
                            ->label('Highlights')
                            // ->fileAttachmentsDisk('disks')
                            ->fileAttachmentsDirectory('attachments')
                            ->fileAttachmentsVisibility('private')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('body')
                            ->required()
                            // ->fileAttachmentsDisk('disks')
                            ->fileAttachmentsDirectory('attachments')
                            ->fileAttachmentsVisibility('private')
                            ->columnSpanFull(),
                    ])->columns(2),
                Forms\Components\Select::make('images')
                    ->relationship('images', 'source') // Use the image source field for display
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        FileUpload::make('source')
                            ->directory('product-images')
                            ->visibility('private'),
                        TextInput::make('image_alt')
                            ->label('Image Description')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Toggle::make('images.is_thumbnail')
                            ->label('Active')
                            ->onIcon('heroicon-m-check-circle')
                            ->offIcon('heroicon-m-x-circle')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true)
                            ->required(),
                    ])
                    ->required(),


            ])->columns(2);
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

                Tables\Columns\IconColumn::make('is_active')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
