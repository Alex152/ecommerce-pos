<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Ventas';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Básica')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\Select::make('type')
                            ->options([
                                'individual' => 'Individual',
                                'business' => 'Empresa'
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('birthdate'),
                    ])->columns(2),

                Forms\Components\Section::make('Información Financiera')
                    ->schema([
                        Forms\Components\TextInput::make('credit_limit')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('balance')
                            ->numeric()
                            ->prefix('$')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax_id')
                            ->label('Identificación Fiscal'),
                        Forms\Components\Select::make('preferred_payment_method')
                            ->options([
                                'cash' => 'Efectivo',
                                'card' => 'Tarjeta',
                                'transfer' => 'Transferencia'
                            ]),
                    ])->columns(2),

                Forms\Components\Section::make('Dirección Principal')
                    ->schema([
                        Forms\Components\TextInput::make('address'),
                        Forms\Components\TextInput::make('city'),
                        Forms\Components\TextInput::make('state'),
                        Forms\Components\TextInput::make('zip_code'),
                        Forms\Components\TextInput::make('country'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'individual' => 'info',
                        'business' => 'success',
                    }),
                Tables\Columns\TextColumn::make('credit_limit')
                    ->money('USD'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'individual' => 'Individual',
                        'business' => 'Empresa'
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Estado')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                /*Tables\Actions\Action::make('history')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->url(fn (Customer $record) => OrderResource::getUrl('index', [
                        'tableFilters[customer_id][value]' => $record->id
                    ])),*/     //Histial no dirije bien
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AddressesRelationManager::class,
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}