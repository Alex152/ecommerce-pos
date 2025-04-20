<?php

namespace App\Filament\Resources\DiscountResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('recordId') // Antes id
                    ->label('Categoría')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre de Categoría')
                    ->searchable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Productos'),

                //Nuevo
                Tables\Columns\TextColumn::make('pivot.discount_value')
                    ->label('Valor Descuento')
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
                    //->preloadRecordSelect(),  // Antes sin nombres
                    ->form([
                        Forms\Components\Select::make('recordId')
                            ->label('Categoría')
                            ->options(\App\Models\Category::pluck('name', 'id')) // Carga directamente las categorías
                            ->searchable()
                            ->required(),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        $discount = $this->getOwnerRecord();
                        $data['discount_value'] = $discount->value;
                        return $data;
                    })
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}