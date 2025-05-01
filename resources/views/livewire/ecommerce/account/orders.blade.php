<div>
    <div class="bg-white py-6 border-b">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <h1 class="text-2xl font-bold">Mis Pedidos</h1>
                
                <div class="mt-4 md:mt-0">
                    <select wire:model="statusFilter" class="border rounded-md px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos los estados</option>
                        <option value="pending">Pendientes</option>
                        <option value="processing">Procesando</option>
                        <option value="shipped">Enviados</option>
                        <option value="completed">Completados</option>
                        <option value="cancelled">Cancelados</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if($orders->count())
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="divide-y divide-gray-200">
                @foreach($orders as $order)
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <div class="flex items-center">
                                <h3 class="text-lg font-medium text-indigo-600">Pedido #{{ $order->number }}</h3>
                                <span class="ml-3 px-2 py-1 text-xs rounded-full 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Realizado el {{ $order->created_at->format('d M Y') }}</p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-medium">${{ number_format($order->total, 2) }}</p>
                            </div>
                            
                            <a href="{{ route('ecommerce.account.orders.show', $order) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                    
                    <!-- Order Items Preview -->
                    <div class="mt-4">
                        <div class="flex space-x-4 overflow-x-auto pb-2">
                            @foreach($order->items as $item)
                            <div class="flex-shrink-0 w-16 h-16 border rounded-md overflow-hidden">
                                <img src="{{ $item->product->getFirstMediaUrl('default', 'thumb') }}" 
                                     alt="{{ $item->product->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($orders->hasMorePages())
            <div class="px-6 py-4 border-t text-center">
                <button wire:click="loadMore" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Cargar más pedidos
                </button>
            </div>
            @endif
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No has realizado ningún pedido</h3>
            <p class="text-gray-600 mb-6">Cuando realices un pedido, aparecerá aquí</p>
            <a href="{{ route('ecommerce.shop') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                <i class="fas fa-shopping-bag mr-2"></i> Ir a la tienda
            </a>
        </div>
        @endif
    </div>
</div>