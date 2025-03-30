<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\Page;

class GenerateReport extends Page
{
    protected static string $resource = ReportResource::class;
    protected static string $view = 'filament.resources.report-resource.pages.generate-report';

    protected function getActions(): array
    {
        return [
            Action::make('export_pdf')
                ->label('Export PDF')
                ->color('danger')
                ->icon('heroicon-o-document-download'),
            Action::make('export_excel')
                ->label('Export Excel')
                ->color('success')
                ->icon('heroicon-o-document-download'),
        ];
    }
}