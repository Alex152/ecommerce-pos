<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentsRelationManager extends RelationManager
{
    // Cambiamos esto para usar una relación personalizada
    protected static ?string $title = 'Historial de Pagos';

    // Sobreescribimos el método para usar nuestra relación personalizada
    public static function getRelationshipName(): string
    {
        return 'allPayments';
    }

    public function table(Table $table): Table
    {
        return $table
        //Añadido para ver orden asociada
        ->modifyQueryUsing(fn (Builder $query) => $query->with(['payable']))
        ////////////////
            ->columns([
                Tables\Columns\TextColumn::make('payment_date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Fecha'),
                
                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->sortable()
                    ->label('Monto'),
                
                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->formatStateUsing(fn ($state) => [
                        'cash' => 'Efectivo',
                        'card' => 'Tarjeta', 
                        'transfer' => 'Transferencia',
                        'check' => 'Cheque'
                    ][$state] ?? $state)
                    ->color(fn ($state) => [
                        'cash' => 'gray',
                        'card' => 'primary',
                        'transfer' => 'success',
                        'check' => 'warning'
                    ][$state] ?? 'info'),
                
                    // Columna para la orden asociada (versión mejorada)
                Tables\Columns\TextColumn::make('payable.order_number')
                    ->label('Orden Asociada')
                    ->formatStateUsing(function ($state, $record) {
                        if (!$state && $record->payable_type === Order::class) {
                            // Intenta cargar la relación si no está cargada
                            $record->loadMissing('payable');
                            $state = $record->payable->order_number ?? null;
                        }
                        return $state ? '#'.$state : 'Pago Directo';
                    })
                    ->url(function ($record) {
                        if ($record->payable_type === Order::class) {
                            if (!$record->relationLoaded('payable')) {
                                $record->loadMissing('payable');
                            }
                            return \App\Filament\Resources\OrderResource::getUrl('edit', [
                                'record' => $record->payable_id
                            ]);
                        }
                        return null;
                    })
                    ->openUrlInNewTab(),

                    //////////////////

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => [
                        'pending' => 'Pendiente',
                        'completed' => 'Completado',
                        'failed' => 'Fallido'
                    ][$state] ?? $state)
                    ->color(fn ($state) => [
                        'pending' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger'
                    ][$state] ?? 'gray'),
                
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Aprobado'),
                /*  Antiguo para mostrar order NO VALIA
                Tables\Columns\TextColumn::make('source')
                    ->label('Origen')
                    ->formatStateUsing(function ($record) {
                        return $record->payable_type === \App\Models\Order::class
                            ? 'Orden #' . ($record->payable->order_number ?? 'N/A')
                            : 'Pago Directo';
                    })
                    ->url(function ($record) {
                        if ($record->payable_type === \App\Models\Order::class) {
                            return \App\Filament\Resources\OrderResource::getUrl('edit', [
                                'record' => $record->payable_id
                            ]);
                        }
                        return null;
                    })
                    ->openUrlInNewTab(),
                */
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transacción')
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'cash' => 'Efectivo',
                        'card' => 'Tarjeta',
                        'transfer' => 'Transferencia',
                        'check' => 'Cheque'
                    ])
                    ->label('Método de Pago'),
                
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'completed' => 'Completado',
                        'failed' => 'Fallido'
                    ])
                    ->label('Estado'),
                
                Tables\Filters\Filter::make('payment_date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('to')
                            ->label('Hasta')
                            ->default(now())
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $date) => $q->whereDate('payment_date', '>=', $date))
                            ->when($data['to'], fn($q, $date) => $q->whereDate('payment_date', '<=', $date));
                    })
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nuevo Pago')
                    ->modalHeading('Registrar Pago')
                    ->form([
                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'cash' => 'Efectivo',
                                'card' => 'Tarjeta',
                                'transfer' => 'Transferencia',
                                'check' => 'Cheque'
                            ])
                            ->required()
                            ->label('Método'),
                        
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->prefix('$')
                            ->label('Monto'),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pendiente',
                                'completed' => 'Completado',
                                'failed' => 'Fallido'
                            ])
                            ->default('completed')
                            ->required(),
                        
                        Forms\Components\DatePicker::make('payment_date')
                            ->default(now())
                            ->required()
                            ->label('Fecha'),
                        
                        Forms\Components\Toggle::make('is_approved')
                            ->default(true)
                            ->required()
                            ->label('Aprobado'),
                        
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('ID Transacción (Opcional)'),
                        
                        Forms\Components\Textarea::make('notes')
                            ->label('Notas')
                            ->columnSpanFull()
                    ])
                    ->using(function (array $data, string $model): \App\Models\Payment {
                        $data['payable_type'] = Customer::class;
                        $data['payable_id'] = $this->getOwnerRecord()->id;
                        $data['customer_id'] = $this->getOwnerRecord()->id;
                        return $model::create($data);
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'cash' => 'Efectivo',
                                'card' => 'Tarjeta',
                                'transfer' => 'Transferencia',
                                'check' => 'Cheque'
                            ])
                            ->required(),
                        
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->prefix('$'),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pendiente',
                                'completed' => 'Completado',
                                'failed' => 'Fallido'
                            ])
                            ->required(),
                        
                        Forms\Components\Toggle::make('is_approved')
                            ->required(),
                        
                        Forms\Components\DatePicker::make('payment_date')
                            ->required(),
                        
                        Forms\Components\TextInput::make('transaction_id'),
                        
                        Forms\Components\Textarea::make('notes')
                            ->columnSpanFull()
                    ]),
                
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No hay pagos registrados')
            ->emptyStateDescription('Cuando realices pagos, aparecerán aquí')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Registrar Pago')
                    ->button()
            ])
            ->defaultSort('payment_date', 'desc');
    }

    
}