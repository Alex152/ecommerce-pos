<?php

namespace App\Filament\Resources\ShippingCarrierResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShippingRatesRelationManager extends RelationManager
{
    protected static string $relationship = 'shippingRates';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required(),
            Forms\Components\TextInput::make('rate')
                ->numeric()
                ->prefix('$')
                ->required(),
            Forms\Components\TextInput::make('min_order_amount')
                ->numeric()
                ->prefix('$'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('rate')
                ->money('USD'),
            Tables\Columns\TextColumn::make('min_order_amount')
                ->money('USD'),
        ]);
    }
}
