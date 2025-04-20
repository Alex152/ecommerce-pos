<?php
/*
namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Discount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->required()
                ->unique(),
            Forms\Components\Select::make('type')
                ->options([
                    'percentage' => 'Percentage',
                    'fixed' => 'Fixed Amount',
                ])
                ->required(),
            Forms\Components\TextInput::make('value')
                ->numeric()
                ->required(),
            Forms\Components\DateTimePicker::make('expires_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('code'),
            Tables\Columns\TextColumn::make('type'),
            Tables\Columns\TextColumn::make('value'),
            Tables\Columns\TextColumn::make('expires_at')
                ->dateTime(),
        ]);
    }


    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}

*/



namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Discount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Marketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configuración')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\TextInput::make('code')
                            ->unique()
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->options([
                                'percentage' => 'Porcentaje',
                                'fixed_amount' => 'Monto Fijo', //Antes solo fixed
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('value')
                            ->numeric()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Restricciones')
                    ->schema([
                        Forms\Components\TextInput::make('min_order_amount')
                            ->numeric(),
                        Forms\Components\TextInput::make('max_uses')
                            ->numeric(),
                        Forms\Components\Toggle::make('apply_to_shipping')
                            ->default(false),
                        Forms\Components\Toggle::make('exclude_discounted_products')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Vigencia')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date'),
                        Forms\Components\DatePicker::make('end_date')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'percentage' => 'info',
                        'fixed_amount' => 'success', //Antes solo fixed
                    }),
                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn ($state, $record) => $record->type === 'percentage' ? "{$state}%" : "$" . number_format($state, 2)),
                Tables\Columns\TextColumn::make('end_date')
                    ->date(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'percentage' => 'Porcentaje',
                        'fixed_amount' => 'Monto Fijo',   //Antes solo fixed
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RelationManagers\ProductsRelationManager::class,
            RelationManagers\CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}