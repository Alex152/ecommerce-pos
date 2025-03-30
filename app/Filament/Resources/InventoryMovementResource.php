<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryMovementResource\Pages;
use App\Filament\Resources\InventoryMovementResource\RelationManagers;
use App\Models\InventoryMovement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryMovementResource extends Resource
{
    protected static ?string $model = InventoryMovement::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('product_id')
                ->relationship('product', 'name')
                ->required(),
            Forms\Components\Select::make('warehouse_id')
                ->relationship('warehouse', 'name')
                ->required(),
            Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->required(),
            Forms\Components\Select::make('type')
                ->options([
                    'in' => 'Entry',
                    'out' => 'Withdrawal',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('product.name')
                ->searchable(),
            Tables\Columns\TextColumn::make('warehouse.name'),
            Tables\Columns\TextColumn::make('quantity')
                ->color(fn (string $state): string => match (true) {
                    $state > 0 => 'success',
                    $state < 0 => 'danger',
                    default => 'gray',
                }),
            Tables\Columns\TextColumn::make('type')
                ->enum([
                    'in' => 'Entry',
                    'out' => 'Withdrawal',
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
            'index' => Pages\ListInventoryMovements::route('/'),
            'create' => Pages\CreateInventoryMovement::route('/create'),
            //'edit' => Pages\EditInventoryMovement::route('/{record}/edit'),
        ];
    }
}
