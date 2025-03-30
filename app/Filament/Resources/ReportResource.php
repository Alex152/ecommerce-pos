<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
//use App\Models\Report;   // No aplica
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = null;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('start_date')
                ->required(),
            Forms\Components\DatePicker::make('end_date')
                ->required(),
            Forms\Components\Select::make('report_type')
                ->options([
                    'sales' => 'Sales',
                    'inventory' => 'Inventory',
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            // Columnas para previsualización
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\GenerateReport::route('/'),
        ];
    }
}
