<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationBadgeTooltip = 'Active Blogs';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', 1)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Forms\Components\Section::make('Information')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('body')
                                ->required()
                                ->fileAttachmentsDirectory('blogs')
                                ->fileAttachmentsVisibility('private')
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Section::make('Information')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->required()
                                ->label('Active')
                                ->onIcon('heroicon-m-check-circle')
                                ->offIcon('heroicon-m-x-circle')
                                ->onColor('success')
                                ->offColor('danger')
                                ->default(true),
                            Forms\Components\TextInput::make('views_count')
                                ->required()
                                ->disabled()
                                // ->default('10')
                                ->numeric()
                                ->default(0),

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
                                ->directory('thumbnail/blogs')
                                ->columnSpanFull(),
                        ])->grow(false),

                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('views_count')->label('Views')
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
