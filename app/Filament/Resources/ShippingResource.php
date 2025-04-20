<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingResource\Pages;
use App\Models\Shipping;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
//Proporcionado por 3er chat
class ShippingResource extends Resource
{   
    protected static ?string $model = Shipping::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Logística';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'order_number')
                    ->required(),
                Forms\Components\Select::make('shipping_carrier_id')
                    ->relationship('carrier', 'name')
                    ->label('Transportista')
                    ->required(),
                Forms\Components\TextInput::make('tracking_number')
                    ->required(),
                Forms\Components\DatePicker::make('shipped_at')
                    ->required(),
                Forms\Components\DatePicker::make('estimated_delivery'),
                Forms\Components\Select::make('status')
                    ->options([
                        'processing' => 'Procesando',
                        'shipped' => 'Enviado',
                        'delivered' => 'Entregado',
                        'failed' => 'Fallido',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->sortable(),
                Tables\Columns\TextColumn::make('carrier.name')
                    ->badge()
                    ->color(fn (ShippingCarrier $carrier): string => match ($carrier->name) {
                        'FedEx' => 'purple',
                        'DHL' => 'yellow',
                        'UPS' => 'brown',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('tracking_number'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'delivered' => 'success',
                        'failed' => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('shipped_at')
                    ->date(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShippings::route('/'),
            'create' => Pages\CreateShipping::route('/create'),
            'edit' => Pages\EditShipping::route('/{record}/edit'),
        ];
    }
}