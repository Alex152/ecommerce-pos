<?php

namespace App\Filament\Resources\SaleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Product;
//use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\SaleItem;

class SaleItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

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
                        //$this->updateTaxAmount($set, $get);
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
                Forms\Components\TextInput::make('tax_amount')
                    ->label('Tax Amount')
                    ->numeric()
                    ->prefix('$')
                    ->readOnly()
                    ->default(0),
       
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('items')
            ->columns([
                Tables\Columns\TextColumn::make('product.name'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('unit_price')
                    ->money('USD'),
                Tables\Columns\TextColumn::make('discount')
                    ->money('USD'),
              /*  Tables\Columns\TextColumn::make('tax_amount')  // Cambiado de 'tax' a 'tax_amount'
                    ->label('Tax')
                    ->money('USD'), 
                Tables\Columns\TextColumn::make('subtotal')
                    ->money('USD')
                    ->state(fn ($record) => $record->quantity * $record->unit_price),*/
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
