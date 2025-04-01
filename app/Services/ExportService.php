<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use App\Exports\InventoryExport;

class ExportService
{
    public function exportSales(array $dates): string
    {
        $filename = 'sales-' . now()->format('Ymd') . '.xlsx';
        Excel::store(new SalesExport($dates), $filename);
        return $filename;
    }

    public function exportInventory(): string
    {
        $filename = 'inventory-' . now()->format('Ymd') . '.xlsx';
        Excel::store(new InventoryExport(), $filename);
        return $filename;
    }
}