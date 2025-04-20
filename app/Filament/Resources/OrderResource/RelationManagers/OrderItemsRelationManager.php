<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Product;
use App\Models\Tax;
use App\Models\OrderItemTax;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\Pivot;


class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    // app/Filament/Resources/OrderResource/RelationManagers/OrderItemsRelationManager.php
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $product = Product::find($state);
                        $set('unit_price', $product->price ?? 0);
                        $set('name', $product->name ?? '');
                        $set('sku', $product->sku ?? '');
                    }),
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Forms\Set $set, $state, $get) {
                        $set('subtotal', $state * $get('unit_price'));
                        // Recalcula tax_amount si hay un tax_id seleccionado
                        /*if ($get('tax_id')) {
                            $taxRate = Tax::find($get('tax_id'))?->rate ?? 0;
                            $set('tax_amount', ($state * $get('unit_price')) * ($taxRate / 100));
                        }*/
                        $this->updateTaxAmount($set, $get);
                    })
                    ,
                
                Forms\Components\TextInput::make('unit_price')
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Forms\Set $set, $state, $get) {
                        /*$set('subtotal', $get('quantity') * $state);
                        if ($get('tax_id')) {
                            $taxRate = Tax::find($get('tax_id'))?->rate ?? 0;
                            $set('tax_amount', ($get('quantity') * $state) * ($taxRate / 100));
                        }
                            */
                        $this->updateTaxAmount($set, $get);
                    }),
                Forms\Components\TextInput::make('discount')
                    ->numeric()
                    ->prefix('$')
                    ->default(0),
                    Forms\Components\Hidden::make('options')
                    ->default('[]') // Asegura que sea un JSON string vacío por defecto
                    ->dehydrateStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state),
                    Forms\Components\Hidden::make('tax')
                    ->default(0), 
                    Forms\Components\Select::make('tax_id')
                    ->relationship('tax', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        $this->updateTaxAmount($set, $get);
                    }),
                Forms\Components\TextInput::make('tax_amount')
                    ->label('Tax Amount')
                    ->numeric()
                    ->prefix('$')
                    ->readOnly()
                    ->default(0),
                    

                //Se incluye de manera oculta campos necesario para validar insercion
                Forms\Components\Hidden::make('name')
                    ->default(fn() => $product->name ?? ''), // Aquí se obtiene el 'name' del producto seleccionado
                
                Forms\Components\Hidden::make('sku')
                    ->default(fn() => $product->sku ?? ''), // Aquí se obtiene el 'sku' del producto seleccionado
                
                Forms\Components\Hidden::make('options')
                    ->default(fn() => $product->options ?? ''), // Aquí se obtienen las 'options' del producto seleccionado
                
                
                Forms\Components\Hidden::make('cost_price')
                    ->default(fn() => $product->cost_price ?? 0), // Aquí se obtiene el 'cost_price' del producto seleccionado
                
                    
                
                
                
                
            ]);
            
    }

    public function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('product.name'),
            Tables\Columns\TextColumn::make('quantity'),
            Tables\Columns\TextColumn::make('unit_price')
                ->money('USD'),
            Tables\Columns\TextColumn::make('discount')
                ->money('USD'),
            Tables\Columns\TextColumn::make('tax_amount')  // Cambiado de 'tax' a 'tax_amount'
                ->label('Tax')
                ->money('USD'),
            Tables\Columns\TextColumn::make('subtotal')
                ->money('USD')
                ->state(fn ($record) => $record->quantity * $record->unit_price),
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    // Calcular subtotal
                    $data['subtotal'] = ($data['quantity'] ?? 1) * ($data['unit_price'] ?? 0);
                    
                    // Calcular impuestos si hay tax_id
                    if (isset($data['tax_id'])) {
                        $taxRate = Tax::find($data['tax_id'])?->rate ?? 0;
                        $data['tax_amount'] = $data['subtotal'] * ($taxRate / 100);
                    } else {
                        $data['tax_amount'] = 0;
                    }
                    
                    // Manejar options como JSON
                    $data['options'] = isset($data['options']) && is_array($data['options']) 
                        ? json_encode($data['options']) 
                        : '[]';
                    
                    return $data;
                })
                ->using(function (array $data) {  // Eliminado el type-hint string $model
                    /** @var OrderItem $orderItem */
                    $orderItem = new OrderItem($data);
                    $orderItem->order()->associate($this->getOwnerRecord());
                    $orderItem->save();
                    
                    // Manejar relación de impuestos
                    if (isset($data['tax_id'])) {
                        $orderItem->tax()->attach($data['tax_id'], [
                            'amount' => $data['tax_amount'] ?? 0
                        ]);
                    }
                    
                    // Recalcular totales
                    $orderItem->order->recalculateTotals();
                    
                    return $orderItem;
                }),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
}

protected function updateTaxAmount(Forms\Set $set, Forms\Get $get): void
{
    $quantity = $get('quantity') ?? 1;
    $unitPrice = $get('unit_price') ?? 0;
    $taxId = $get('tax_id');
    
    $subtotal = $quantity * $unitPrice;
    $set('subtotal', $subtotal);
    
    if ($taxId) {
        $taxRate = Tax::find($taxId)?->rate ?? 0;
        $taxAmount = $subtotal * ($taxRate / 100);
        $set('tax_amount', $taxAmount);
    } else {
        $set('tax_amount', 0);
    }
}
    
}