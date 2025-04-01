<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;

use Maatwebsite\Excel\Facades\Excel; // Añade esto al inicio
use App\Exports\SalesExport;   // Asegúrate de importar tu exportador



class ReportController extends Controller
{
    /*Old
    public function salesReport(ReportService $service)
    {
        $data = $service->generateSalesReport(request()->all());
        return Pdf::loadView('reports.sales', compact('data'))->download();
    }
    */

    public function salesReport(ReportService $service)
{
    $validated = request()->validate([
        'start' => 'required|date',
        'end' => 'required|date|after_or_equal:start',
        'type' => 'required|in:sales,inventory',
        'format' => 'required|in:pdf,excel'
    ]);

    if ($validated['format'] === 'pdf') {
        $reportData = $service->generateSalesReport($validated);
        return Pdf::loadView('reports.sales', [
            'data' => $reportData,
            'params' => [
                'start_date' => $validated['start'],
                'end_date' => $validated['end'],
                'report_type' => $validated['type']
            ]
        ])->download('sales_report_'.now()->format('Ymd').'.pdf');
    }
    
    // Para Excel usa tu SalesExport existente
    return Excel::download(
        new SalesExport([
            $validated['start'], 
            $validated['end']
        ]),
        'sales_export_'.now()->format('Ymd').'.xlsx'
    );
}
}