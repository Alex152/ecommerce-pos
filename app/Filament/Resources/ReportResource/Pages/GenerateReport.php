<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Forms;

class GenerateReport extends Page
{
    protected static string $resource = ReportResource::class;
    protected static string $view = 'filament.resources.report-resource.pages.generate-report';

    public ?string $start_date = null;
    public ?string $end_date = null;
    public ?string $report_type = null;

    public bool $canExport = false;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('start_date')
                ->required()
                ->native(false)
                ->reactive()
                ->afterStateUpdated(fn () => $this->canExport = false),
                
            Forms\Components\DatePicker::make('end_date')
                ->required()
                ->native(false)
                ->minDate(fn ($get) => $get('start_date'))
                ->reactive()
                ->afterStateUpdated(fn () => $this->canExport = false),
                
            Forms\Components\Select::make('report_type')
                ->options([
                    'sales' => 'Sales',
                    'inventory' => 'Inventory',
                ])
                ->required()
                ->reactive()
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_pdf')
                ->label('Export PDF')
                ->color('danger')
                ->icon('heroicon-o-document-text')
                ->url(function () {
                    return route('sales.report', [
                        'start' => $this->form->getState()['start_date'],
                        'end' => $this->form->getState()['end_date'],
                        'type' => $this->form->getState()['report_type'],
                        'format' => 'pdf'
                    ]);
                })
                ->hidden(fn () => !$this->canExport),
                
            Action::make('export_excel')
                ->label('Export Excel')
                ->color('success')
                ->icon('heroicon-o-document-chart-bar')
                ->url(function () {
                    return route('sales.report', [
                        'start' => $this->form->getState()['start_date'],
                        'end' => $this->form->getState()['end_date'],
                        'type' => $this->form->getState()['report_type'],
                        'format' => 'excel'
                    ]);
                })
                ->hidden(fn () => !$this->canExport)
        ];
    }

    public function generateReport()
    {
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'report_type' => 'required|in:sales,inventory'
        ]);

        $this->canExport = true;
        
        Notification::make()
            ->title('Report generated successfully!')
            ->success()
            ->send();
    }
}
