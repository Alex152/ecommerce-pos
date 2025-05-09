<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionResource\Pages;
use App\Filament\Resources\PromotionResource\RelationManagers;
use App\Models\Promotion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Ecommerce';
    protected static ?string $label = 'Slider';
    protected static ?string $pluralLabel = 'Sliders';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('subtitle'),
            Forms\Components\Textarea::make('description'),

            Forms\Components\TextInput::make('image_url')
                ->label('URL de Imagen')
                ->required(),

            Forms\Components\TextInput::make('button_text'),
            Forms\Components\TextInput::make('button_url'),

            Forms\Components\Select::make('text_color')
                ->options([
                    'text-white' => 'Blanco',
                    'text-black' => 'Negro',
                    'text-gray-900' => 'Gris oscuro',
                    // Agrega más si usas clases personalizadas
                ])
                ->required(),

            Forms\Components\Select::make('overlay_color')
                ->label('Color del Overlay')
                ->options([
                    'bg-black bg-opacity-40' => 'Negro Opaco',
                    'bg-white bg-opacity-30' => 'Blanco Opaco',
                    'bg-indigo-900 bg-opacity-50' => 'Indigo',
                ])
                ->required(),

            Forms\Components\Select::make('text_position')
                ->options([
                    'left' => 'Izquierda',
                    'center' => 'Centro',
                    'right' => 'Derecha',
                ])
                ->required(),

            Forms\Components\Select::make('type')
                ->options([
                    'hero_slider' => 'Hero Slider',
                    'banner' => 'Banner',
                    'popup' => 'Popup',
                ])
                ->default('hero_slider'),

            Forms\Components\Toggle::make('is_active')
                ->label('¿Activo?')
                ->default(true),

            Forms\Components\TextInput::make('priority')
                ->numeric()
                ->default(0)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\ImageColumn::make('image_url')->label('Imagen'),
            Tables\Columns\TextColumn::make('type')->badge(),
            Tables\Columns\ToggleColumn::make('is_active')->label('Activo'),
            Tables\Columns\TextColumn::make('priority')->sortable(),
        ])
        ->defaultSort('priority', 'asc')
        
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
 
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
          
            Tables\Actions\DeleteBulkAction::make(),
        
        ]);//Antes desc
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotion::route('/create'),
            'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }
}