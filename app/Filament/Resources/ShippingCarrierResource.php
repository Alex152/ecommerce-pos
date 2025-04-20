<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingCarrierResource\Pages;
use App\Filament\Resources\ShippingCarrierResource\RelationManagers;
use App\Models\ShippingCarrier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
//Aun no mejorado con el 3er chat
class ShippingCarrierResource extends Resource
{
    protected static ?string $model = ShippingCarrier::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Logística';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required(),
            Forms\Components\TextInput::make('tracking_url')
                ->url()
                ->required(),
            Forms\Components\Toggle::make('is_active')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\BooleanColumn::make('is_active'),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ShippingRatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShippingCarriers::route('/'),
            'create' => Pages\CreateShippingCarrier::route('/create'),
            'edit' => Pages\EditShippingCarrier::route('/{record}/edit'),
        ];
    }
}
