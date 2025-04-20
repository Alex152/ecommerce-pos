<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Filters\DateRangeFilter;


class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('payment_method')   // Antes method

                    ->label('Método de Pago')
                    ->options([
                        'credit_card' => 'Tarjeta de Crédito',
                        'paypal' => 'PayPal',
                        'bank_transfer' => 'Transferencia Bancaria',
                        'cash' => 'Efectivo',
                    ])
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('transaction_id')
                    ->label('ID de Transacción')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_approved')
                    ->label('Aprobado')
                    ->required(),
                Forms\Components\DatePicker::make('payment_date')
                    ->label('Fecha de Pago')
                    ->required(),
                //Faltaba notes:
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_method')    //Antes method
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'credit_card' => 'primary',
                        'paypal' => 'success',
                        'bank_transfer' => 'blue',
                        'cash' => 'gray',
                        default => 'warning',
                    })
                    ->label('Método'),
                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Aprobado'),
                //Añadido status
                Tables\Columns\TextColumn::make('status') // Añadida columna status
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_date')
                    ->date()
                    ->label('Fecha'),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('ID Transacción')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')   // Antes method 
                    ->options([
                        'credit_card' => 'Tarjeta',
                        'paypal' => 'PayPal',                    
                        //Añadidos
                        'bank_transfer' => 'Transferencia',
                        'cash' => 'Efectivo',
                    ]),
                //Añadidos
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'completed' => 'Completado',
                        'failed' => 'Fallido',
                    ]),
                Tables\Filters\Filter::make('is_approved')
                    ->label('Solo pagos aprobados')
                    ->query(fn ($query) => $query->where('is_approved', true)),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Registrar Pago'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}