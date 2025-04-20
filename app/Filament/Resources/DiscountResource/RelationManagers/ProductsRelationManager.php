<?php
/*
namespace App\Filament\Resources\DiscountResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('id')
                ->relationship('product', 'name')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('price')
                ->money('USD'),
        ]);
    }
}
*/





namespace App\Filament\Resources\DiscountResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('recordId') // Antes id
                    ->label('Producto')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->required()
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric(),


                //Nuevo
                Tables\Columns\TextColumn::make('pivot.discount_value')
                    ->label('Descuento aplicado')
                    ->formatStateUsing(function ($record) {
                        $discount = $this->getOwnerRecord();
                        return $discount->type === 'percentage' 
                            ? "{$record->pivot->discount_value}%" 
                            : "$".number_format($record->pivot->discount_value, 2);
                    }),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    //->preloadRecordSelect(),    // Antes cuando salia el select como "product"
                    ->recordSelect(function () {
                        return Forms\Components\Select::make('recordId')    // Al principio product_id se cambia para que filament reconozca la variable
                            ->label('Producto')
                            ->options(\App\Models\Product::pluck('name', 'id'))
                            ->searchable();
                    })
                    //Nuevo
                    ->mutateFormDataUsing(function (array $data, $action): array {
                        // Obtenemos el descuento principal y su valor
                        $discount = $this->getOwnerRecord();
                        
                        // Forzamos que siempre use el valor principal
                        $data['discount_value'] = $discount->value;
                        
                        return $data;
                    }),
                
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}