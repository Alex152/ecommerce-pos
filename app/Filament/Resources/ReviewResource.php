<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Tienda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
                Forms\Components\Select::make('rating')
                    ->options([
                        1 => '1 Estrella',
                        2 => '2 Estrellas',
                        3 => '3 Estrellas',
                        4 => '4 Estrellas',
                        5 => '5 Estrellas',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->maxLength(500),
                Forms\Components\Toggle::make('is_approved')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('rating')
                    ->icon('heroicon-o-star')
                    ->color('warning'),
                Tables\Columns\TextColumn::make('comment')
                    ->limit(50),
            ])
            ->filters([])
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }

    //Notify
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_approved', false)->count();
        return $count > 0 ? (string) $count : null;
    }

}