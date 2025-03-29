<div class="bg-white p-4 rounded-lg shadow">
    <h2 class="text-lg font-bold mb-2 text-red-600">⚠️ Low Stock Alerts</h2>
    
    @if($lowStockProducts->count() > 0)
        <ul class="space-y-2">
            @foreach($lowStockProducts as $product)
                <li class="flex justify-between items-center">
                    <span>{{ $product->name }}</span>
                    <span class="font-mono bg-red-100 px-2 py-1 rounded">
                        {{ $product->stock_quantity }} left
                    </span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-green-600">All products are well stocked</p>
    @endif
</div>