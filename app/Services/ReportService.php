<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Order;
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportService
{
    /*public function generateSalesReport(array $dates): array
    {
        $period = CarbonPeriod::create($dates['start'], $dates['end']);
        $report = [];

        foreach ($period as $date) {
            $report[] = [
                'date' => $date->format('Y-m-d'),
                'sales' => Sale::whereDate('created_at', $date)->count(),
                'revenue' => Sale::whereDate('created_at', $date)->sum('total_amount'),
            ];
        }

        return $report;
    }*/

    public function generateSalesReport(array $params): array
{
    $period = CarbonPeriod::create($params['start'], $params['end']);
    $report = [];

    foreach ($period as $date) {
        $report[] = [
            'date' => $date->format('Y-m-d'),
            'sales' => Sale::whereDate('created_at', $date)->count(),
            'revenue' => Sale::whereDate('created_at', $date)->sum('total_amount')
        ];
    }

    return $report; // Devuelve array con estructura esperada
}

    public function exportToPDF(array $data): string
    {
        $pdf = PDF::loadView('reports.sales', compact('data'));
        return $pdf->download('sales-report.pdf');
    }
}