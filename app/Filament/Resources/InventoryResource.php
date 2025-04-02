<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Filament\Resources\InventoryResource\RelationManagers;
use App\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Inventario';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Básica')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('warehouse_id')
                            ->relationship('warehouse', 'name')
                            ->searchable()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Control de Stock')
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('min_stock')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('max_stock')
                            ->numeric(),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->color(fn (Inventory $record) => $record->quantity <= $record->min_stock ? 'danger' : 'success')
                    ->label('Stock Actual'),
                Tables\Columns\TextColumn::make('min_stock')
                    ->label('Stock Mínimo'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Activo'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('warehouse')
                    ->relationship('warehouse', 'name'),
                Tables\Filters\TernaryFilter::make('low_stock')
                    ->label('Stock Bajo')
                    ->placeholder('Todos')
                    ->trueLabel('Solo stock bajo')
                    ->queries(
                        //true: fn ($query) => $query->whereColumn('quantity', '<=', 'min_stock'), // Antes
                        true: fn ($query) => $query->whereColumn('quantity', '<=', 'min_stock'),
                        false: fn ($query) => $query, // Sin cambios en la consulta
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('ajustar')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->form([
                        Forms\Components\TextInput::make('cantidad')
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('tipo')
                            ->options([
                                'in' => 'Entrada',
                                'out' => 'Salida',
                                'adjustment' => 'Ajuste'
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('notas')
                            ->columnSpanFull(),
                    ])
                    ->action(function (Inventory $record, array $data) {
                        $record->updateStock(
                            $data['cantidad'],
                            $data['tipo'],
                            ['notes' => $data['notas']]
                        );
                    }),
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
            RelationManagers\MovementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}