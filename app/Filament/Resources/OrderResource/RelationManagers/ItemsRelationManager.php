<?php
/*
namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public  function form(Form $form): Form //antes static
    {
        return $form->schema([
            Forms\Components\Select::make('product_id')
                ->relationship('product', 'name')
                ->required(),
            Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->required(),
        ]);
    }

    public  function table(Table $table): Table  //antes static
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('product.name'),
            Tables\Columns\TextColumn::make('quantity'),
            Tables\Columns\TextColumn::make('unit_price')
                ->money('USD'),
        ]);
    }
}
*/