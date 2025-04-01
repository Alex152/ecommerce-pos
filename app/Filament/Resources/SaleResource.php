<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    /* Form antiguo
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cashier_id')
                    ->relationship('cashier', 'name')
                    ->required(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name'),
                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'cash' => 'Cash',
                        'card' => 'Credit Card',
                        'transfer' => 'Bank Transfer',
                    ])
                    ->required(),
            ]);
    }*/

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Selector de Cajero (User)
                Forms\Components\Select::make('cashier_id')
                    ->relationship(
                        name: 'cashier',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->whereHas('roles', fn ($q) => $q->whereIn('name', ['super-admin', 'cashier']))
                    )
                    ->required()
                    ->searchable(['name', 'email'])
                    ->preload()
                    ->label('Cajero'),
                
                /* Old selector
                    // Selector de Cliente (Customer)
                Forms\Components\Select::make('customer_id')
                    ->relationship(
                        name: 'customer',
                        titleAttribute: 'dni',
                        modifyQueryUsing: fn (Builder $query) => $query->with('user')->orderBy('company_name')
                    )
                    ->getOptionLabelFromRecordUsing(function (Customer $record) {
                        $label = $record->dni;
                        
                        if ($record->company_name) {
                            $label .= " - {$record->company_name}";
                        } elseif ($record->user) {
                            $label .= " - {$record->user->name}";
                        }
                        
                        return $label;
                    })
                    ->searchable(['dni', 'company_name', 'phone', 'user.name'])
                    ->preload()
                    ->label('Cliente (DNI/RUC)')
                    ->createOptionForm([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Usuario asociado (opcional)'),
                        Forms\Components\TextInput::make('dni')
                            ->label('DNI/RUC')
                            ->required(),
                        Forms\Components\TextInput::make('company_name')
                            ->label('Razón Social (opcional para personas)'),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required(),
                    ])
                    ->helperText('Busque por DNI, RUC o nombre'),
                

                    */

                Forms\Components\Select::make('customer_id')
                    ->relationship(
                        name: 'customer',
                        titleAttribute: 'dni',
                        modifyQueryUsing: fn (Builder $query) => $query->with('user')->orderBy('company_name')
                    )
                    ->getOptionLabelFromRecordUsing(function (\App\Models\Customer $record) {
                        $label = $record->dni;
                        
                        if ($record->company_name) {
                            $label .= " - {$record->company_name}";
                        } elseif ($record->user) {
                            $label .= " - {$record->user->name}";
                        }
                        
                        return $label;
                    })
                    ->searchable(['dni', 'company_name', 'phone', 'user.name'])
                    ->preload()
                    ->label('Cliente (DNI/RUC)')
                    ->createOptionForm([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Usuario asociado (opcional)'),
                        Forms\Components\TextInput::make('dni')
                            ->label('DNI/RUC')
                            ->required(),
                        Forms\Components\TextInput::make('company_name')
                            ->label('Razón Social (opcional para personas)'),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required(),
                    ])
                    ->helperText('Busque por DNI, RUC o nombre'),
                // Resto de campos
                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'cash' => 'Efectivo',
                        'card' => 'Tarjeta',
                        'transfer' => 'Transferencia',
                    ])
                    ->required(),
            ]);
    }

    /* Old table
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cashier.name')
                    ->label('Cashier'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('USD')
                    ->sortable(),
                 Mal Enum ya no se utiliza    
                Tables\Columns\TextColumn::make('payment_method')
                    ->enum([
                        'cash' => 'Cash',
                        'card' => 'Card',
                        'transfer' => 'Transfer',
                    ]),
                

                Tables\Columns\TextColumn::make('payment_method')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'cash' => 'Cash',
                            'card' => 'Card',
                            'transfer' => 'Transfer',
                            default => $state,
                        };
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'cash' => 'Cash',
                        'card' => 'Card',
                        'transfer' => 'Transfer',
                    ]),
            ]);
    }
    */




    //Nueva table
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->label('Factura'),
                    
                Tables\Columns\TextColumn::make('cashier.name')
                    ->label('Cajero'),
                    
                Tables\Columns\TextColumn::make('customer.dni')
                    ->label('Cliente')
                   // ->formatStateUsing(fn ($state, Sale $sale) => $sale->customer?->getCustomerLabel())  // Simplemente para mostrar nombre
                   // De momento se usa asi para mostrar o DNI O name o id
                   ->formatStateUsing(fn ($state, Sale $sale) => $sale->customer?->getCustomerLabel())
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('customer', function ($q) use ($search) {
                            $q->where('dni', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%")
                            ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                        });
                    }),
                    
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('USD')
                    ->sortable()
                    ->label('Total'),
                    
                Tables\Columns\TextColumn::make('payment_method')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'cash' => 'Efectivo',
                        'card' => 'Tarjeta',
                        'transfer' => 'Transferencia',
                        default => $state,
                    })
                    ->label('Método Pago'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Fecha'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'cash' => 'Efectivo',
                        'card' => 'Tarjeta',
                        'transfer' => 'Transferencia',
                    ])
                    ->label('Método de Pago'),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
