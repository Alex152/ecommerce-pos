<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

//Ya mejorado 3er Chat
class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('position')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_visible')
                    ->default(true),

                    Forms\Components\Section::make('Imagen de Categoría')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('category_image')
                            ->collection('category_image')
                            ->label('Imagen Principal')
                            ->disk('public')   //  Antes media 
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->imageResizeMode('cover')
                            //->imageCropAspectRatio('1:1')
                            ->openable()
                            ->downloadable()
                            ->maxSize(2048)
                            ->panelLayout('integrated')
                            ->columnSpanFull()
                            ->visibility('public')
                            ->conversion('thumb'),
                    ])->collapsible(),

                Forms\Components\TextInput::make('meta_title'),
                Forms\Components\Textarea::make('meta_description')
                    ->columnSpanFull(),
                //Forms\Components\TagsInput::make('meta_keywords'),  // Irrelevante para navegadores actuales
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('category_image') // Cambiado de 'image_url' a 'category_image'
                    ->label('Imagen')
                    ->getStateUsing(function ($record) {
                        return $record->getFirstMediaUrl('category_image', 'thumb');
                    })
                    ->size(50)
                    ->defaultImageUrl(asset('images/default-category.png')),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Categoría Padre'),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('position')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('parent')
                    ->relationship('parent', 'name'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
