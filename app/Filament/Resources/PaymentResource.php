<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Order;

use Filament\Tables\Filters\SelectFilter;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Ventas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('payable_id')
                    ->label('Orden')
                    ->options(Order::all()->pluck('order_number', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Hidden::make('payable_type')
                    ->default(Order::class),
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'cash' => 'Efectivo',
                        'card' => 'Tarjeta',
                        'transfer' => 'Transferencia',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('transaction_id'),
                Forms\Components\Select::make('status')
                    ->options([
                        /*'paid' => 'Pagado',
                        'pending' => 'Pendiente',
                        'cancelled' => 'Cancelado',*/
                        'pending' => 'Pendiente',
                        'completed' => 'Completado',
                        'failed' => 'Fallido',
                        'refunded' => 'Reembolsado',
                    ])
                    ->default('pending'),
                Forms\Components\DatePicker::make('payment_date')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payable.order_number')
                    ->label('Orden'),
                    //->sortable(),
                /* //En caso de que tambien s ealmacena payments d esales aqui
                Tables\Columns\TextColumn::make('payable_label')
                    ->label('Relacionado con')
                    ->getStateUsing(function ($record) {
                        if ($record->payable_type === \App\Models\Order::class) {
                            return '' . optional($record->payable)->order_number;
                        }

                        if ($record->payable_type === \App\Models\Sale::class) {
                            return '' . optional($record->payable)->invoice_number;
                        }

                        return 'Otro';
                    }),
                    */

                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'card' => 'primary',
                        'transfer' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        /*'paid' => 'success',
                        'cancelled' => 'danger',
                        default => 'warning',*/
                        'completed' => 'success',
                        'refunded' => 'info',
                        'failed' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('payment_date')
                    ->date(),
            ])
            ->filters([
                /* //En caso de poner payments de sales aqui
                SelectFilter::make('payable_type')
                    ->label('Filtrar por tipo')
                    ->options([
                        Order::class => 'Solo Orders',
                        \App\Models\Sale::class => 'Solo Sales',
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $query->where('payable_type', $data['value']);
                        }
                    }),
                */
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    //Alerts

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        $count = static::getModel()::where('status', 'pending')->count();

        return $count > 0
            ? ($count > 10 ? 'danger' : 'warning')
            : null;
    }
/*  //Ejemplo de como contrar acceso con permisos
    public static function canAccess(): bool
    {
        return auth()->user()?->can('view-payments');
    }
*/

}