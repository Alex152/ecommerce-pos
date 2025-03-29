<div>
    <div class="mb-6 flex gap-4">
        <input type="date" wire:model.live="startDate" class="border rounded px-4 py-2">
        <input type="date" wire:model.live="endDate" class="border rounded px-4 py-2">
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Sales Report</h2>
        <canvas 
            wire:ignore
            x-data="{
                chart: null,
                init() {
                    this.renderChart();
                    $wire.on('updateChart', () => this.renderChart());
                },
                renderChart() {
                    if (this.chart) this.chart.destroy();
                    this.chart = new Chart(this.$el, {
                        type: 'bar',
                        data: {
                            labels: Object.keys($wire.salesData),
                            datasets: [{
                                label: 'Sales (USD)',
                                data: Object.values($wire.salesData),
                                backgroundColor: '#3B82F6'
                            }]
                        }
                    });
                }
            }"
        ></canvas>
    </div>
</div>