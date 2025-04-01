<?php
/*   //Antiguo
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Sale;

class SalesExport implements FromCollection
{
    public function __construct(public array $dates) {}

    public function collection()
    {
        return Sale::whereBetween('created_at', $this->dates)
            ->get()
            ->map(fn($sale) => [
                'ID' => $sale->id,
                'Date' => $sale->created_at->format('Y-m-d'),
                'Total' => $sale->total_amount,
                'Payment Method' => $sale->payment_method,
            ]);
    }
}
*/



namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Sale;

class SalesExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnFormatting
{
    public function __construct(public array $dates) {}

    // Título de la hoja
    public function title(): string
    {
        return 'Ventas';
    }

    // Encabezados
    public function headings(): array
    {
        return [
            ['REPORTE DE VENTAS'],
            ['Fecha de generación: ' . now()->format('d/m/Y H:i')],
            [],
            ['ID', 'Fecha', 'Monto Total', 'Método de Pago']
        ];
    }

    // Datos
    public function collection()
    {
        return Sale::whereBetween('created_at', $this->dates)
            ->get()
            ->map(fn($sale) => [
                $sale->id,
                $sale->created_at->format('d/m/Y H:i'),
                $sale->total_amount,
                $this->formatPaymentMethod($sale->payment_method)
            ]);
    }

    // Estilos
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el título principal
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => 'center']
            ],
            
            // Estilo para la fecha de generación
            2 => [
                'font' => ['italic' => true],
                'alignment' => ['horizontal' => 'left']
            ],
            
            // Estilo para los encabezados de columna
            4 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'D9D9D9']
                ]
            ],
            
            // Formato para la columna de montos
            'C' => [
                'alignment' => ['horizontal' => 'right']
            ]
        ];
    }

    // Formato de columnas
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE, // Columna de montos
            'B' => 'dd/mm/yyyy hh:mm' // Formato de fecha
        ];
    }

    // Formatear método de pago
    private function formatPaymentMethod($method)
    {
        $methods = [
            'cash' => 'Efectivo',
            'card' => 'Tarjeta',
            'transfer' => 'Transferencia'
        ];
        
        return $methods[$method] ?? $method;
    }
}