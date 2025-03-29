<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use App\Models\Sale;
use Carbon\Carbon;

class SalesDashboard extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function getSalesDataProperty()
    {
        return Sale::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');
    }

    public function render()
    {
        return view('livewire.reports.sales-dashboard');
    }
}