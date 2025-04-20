<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\ProductVariant;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Productos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Básica')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('sku')
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Toggle::make('manage_inventory')
                            ->label('Gestionar Inventario')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Precios y Stock')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('cost_price')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('stock_quantity')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('has_variants')
                            ->live()
                            ->label('Tiene Variantes'),
                    ])->columns(3),

                Forms\Components\Section::make('Disponibilidad')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Activo (eCommerce)')
                            ->default(true),
                        Forms\Components\Toggle::make('pos_visible')
                            ->label('Visible en POS')
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Destacado'),
                    ])->columns(3),

                
                    Forms\Components\Section::make('Variantes')
                    ->schema([
                        Forms\Components\Repeater::make('variants')
                            ->relationship('variants')
                            ->schema([
                                Forms\Components\TextInput::make('name')->required(),
                                Forms\Components\TextInput::make('sku')->unique(),
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('stock_quantity')
                                    ->numeric()
                                    ->default(0),
                            ])
                            //->columnSpanFull(),
                    ])->visible(fn ($get) => $get('has_variants')),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title'),
                        Forms\Components\Textarea::make('meta_description'),
                    ]),
                
                

                //Para imagenes
                Forms\Components\Section::make('Imágenes del Producto')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('main_image')
                            ->collection('main_image')
                            ->label('Imagen Principal')
                            ->disk('media') // Asegúrate que coincide con tu disco configurado
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->openable()
                            ->downloadable()
                            ->maxSize(2048)
                            ->panelLayout('integrated')
                            ->columnSpanFull()
                            ->visibility('public')
                            ->conversion('thumb') // Usa la conversión que definiste en el modelo
                            ->required(fn ($operation) => $operation === 'create'),
                        /*
                        Forms\Components\FileUpload::make('main_image')
                            ->label('Imagen Principal')
                            ->disk('public')
    ->directory('products/main')
    ->image()
    ->preserveFilenames()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->openable()
                            ->downloadable()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->maxSize(2048)
                            ->rules(['image', 'max:2048'])
                            ->columnSpanFull()
                            ->panelLayout('integrated')
                            ->previewable(true)
                            ->visibility('public')
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get, $set, $record): string {
                                if ($record?->getFirstMediaUrl('main_image')) {
                                    return $record->getFirstMediaPath('main_image');
                                }
                                return ImageService::handleProductImageUpload($file, $record);
                            })
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file, $livewire) {
                                return ImageService::handleProductImageUpload($file, $livewire->record ?? null);
                            }),
                            */
                        /*    
                        Forms\Components\FileUpload::make('gallery')
                        ->disk('public')
                        ->directory('products/gallery')
                        ->multiple()
                        ->image()
                        ->preserveFilenames()
                            ->imageEditor()
                            ->openable()
                            ->downloadable()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->maxSize(2048)
                            ->rules(['array'])
                            ->rules(['*.image', '*.max:2048'])
                            ->panelLayout('integrated')
                            ->previewable(true)
                            ->reorderable() // evita duplicado de inputs invisibles
                            ->columnSpanFull()
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, $get, $set, $record): string {
                                return ImageService::handleProductImageUpload($file, $record, 'gallery', true);
                            })
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file, $livewire, $set) {
                                $path = ImageService::handleProductImageUpload($file, null, 'gallery', true);
                                
                                $galleryPaths = $livewire->data['gallery_paths'] ?? [];
                                $galleryPaths[] = $path;
                                $set('gallery_paths', $galleryPaths);
                                
                                return $path;
                            })
                            ->hint('Máx. 5 imágenes adicionales, 1200x1200 px cada una'),*/
                           

                            SpatieMediaLibraryFileUpload::make('gallery')
                                ->collection('gallery')
                                ->multiple()
                                ->maxFiles(5)
                                ->image()
                                ->downloadable()
                                ->openable()
                                ->reorderable()
                                //->responsiveImages()   //Genera varios tamaños 
                                ->columnSpanFull()
                    ])
                    ->collapsible(),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('main_image')
                    ->label('Imagen')
                    ->getStateUsing(function ($record) {
                        return $record->getFirstMediaUrl('main_image', 'thumb');
                    })
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\IconColumn::make('pos_visible')
                    ->label('POS')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Solo activos'),
                Tables\Filters\TernaryFilter::make('pos_visible')
                    ->label('Visible en POS'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('inventory')
                    ->icon('heroicon-o-archive-box')
                    ->url(fn (Product $record) => InventoryResource::getUrl('index', [
                        'tableFilters[product_id][value]' => $record->id
                    ])),
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
            RelationManagers\VariantsRelationManager::class,
            RelationManagers\InventoryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    protected function afterCreate(): void
    {
        // Procesar imagen principal
    if ($this->data['main_image'] ?? false) {
        ImageService::handleProductImageUpload(
            TemporaryUploadedFile::createFromLivewire($this->data['main_image']),
            $this->record
        );
    }
    
    // Procesar galería
    if ($this->data['gallery'] ?? false) {
        ImageService::handleGalleryUpload($this->data['gallery'], $this->record);
    }
        
        // Forzar actualización del estado
        $this->dispatch('file-upload-processed');
    }
}