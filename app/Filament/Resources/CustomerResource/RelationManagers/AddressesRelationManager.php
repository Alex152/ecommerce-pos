<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'shipping' => 'Envío',
                        'billing' => 'Facturación',
                        'both' => 'Ambos'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('street')
                    ->required(),
                Forms\Components\TextInput::make('city')
                    ->required(),
                Forms\Components\TextInput::make('state')
                    ->required(),
                Forms\Components\TextInput::make('zip_code')
                    ->required(),
                Forms\Components\TextInput::make('country')
                    ->required(),
                Forms\Components\Toggle::make('is_default')
                    ->label('Dirección Principal'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'shipping' => 'info',
                        'billing' => 'warning',
                        'both' => 'success',
                    }),
                Tables\Columns\TextColumn::make('street'),
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\IconColumn::make('is_default')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'shipping' => 'Envío',
                        'billing' => 'Facturación',
                        'both' => 'Ambos'
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}