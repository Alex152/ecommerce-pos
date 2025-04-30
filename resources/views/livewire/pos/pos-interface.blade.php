<div class="pos-container bg-gray-50 min-h-screen">
    <!-- Header Component -->
    <livewire:pos.pos-header />
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
       
    <!--Componente notificaciones-->
    <livewire:pos.notification-handler />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product List Section -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-gray-800">Productos</h2>
                        <div class="relative w-64">
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="search"
                                placeholder="Buscar productos..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            >
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Barcode Scanner Input -->
                    <div class="mt-4">
                        <div class="relative">
                            <input 
                                type="text" 
                                wire:model.live="barcodeInput"
                                wire:keydown.enter="searchByBarcode"
                                placeholder="Escanee el código de barras..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                autofocus
                            >
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Products Grid -->
                <div class="p-6">
                    @if($products->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-700">No se encontraron productos</h3>
                            <p class="mt-1 text-sm text-gray-500">Intente ajustar su búsqueda o filtro</p>
                        </div>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($products as $product)
                                <div 
                                    wire:click="addToCart({{ $product->id }})"
                                    class="group relative bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 cursor-pointer"
                                >
                                    <!-- Product Image -->
                                    <div class="aspect-square bg-gray-50 flex items-center justify-center overflow-hidden">
                                        @if($product->hasMedia('main_image'))
                                            <img 
                                                src="{{ $product->getFirstMediaUrl('main_image', 'thumb') }}" 
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                            >
                                        @else
                                            <div class="text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="p-3">
                                        <h3 class="font-medium text-gray-800 truncate">{{ $product->name }}</h3>
                                        <!--<p class="text-xs text-gray-500 mt-1">{{ $product->barcode }}</p>-->

                                        <div class="flex justify-between items-center mt-1">
                                            <p class="text-xs text-gray-500">{{ $product->barcode }}</p>
                                            <span class="text-xs px-2 py-0.5 rounded-full 
                                                {{ $product->stock_quantity > 5 ? 'bg-green-50 text-green-700' : ($product->stock_quantity > 0 ? 'bg-yellow-50 text-yellow-700' : 'bg-red-50 text-red-700') }}">
                                                Stock: {{ $product->stock_quantity }}
                                            </span>
                                        </div>

                                        <div class="mt-2 flex justify-between items-center">
                                            <span class="font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                                            <span class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded-full">{{ $product->category->name ?? '' }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Add to cart hover effect -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        <div class="bg-white rounded-full p-2 shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Cart Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800">Venta actual</h2>
                </div>
                
                <!-- Customer Selection -->
                <div class="p-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                    
                    @if($selectedCustomerName)
                        <div class="flex items-center justify-between bg-blue-50 rounded-lg p-3 mb-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="font-medium text-blue-700">{{ $selectedCustomerName }}</span>
                            </div>
                            <button 
                                wire:click="clearCustomer"
                                class="text-blue-500 hover:text-blue-700 transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="relative">
                            <input 
                                type="text" 
                                wire:model.live.debounce.300ms="customerSearch"
                                placeholder="Buscar cliente..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            >
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            
                            @if($customerSearch && $filteredCustomers->isNotEmpty())
                                <div class="absolute z-10 mt-1 w-full bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
                                    @foreach($filteredCustomers as $customer)
                                        <div 
                                            wire:click="selectCustomer({{ $customer->id }})"
                                            class="px-4 py-2.5 hover:bg-gray-50 cursor-pointer flex items-center"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span>{{ $customer->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <button 
                            wire:click="showCustomers"
                            class="mt-2 text-sm text-blue-600 hover:text-blue-800 flex items-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Agregar nuevo cliente
                        </button>
                    @endif
                </div>
                
                <!-- Cart Items -->
                <div class="p-6 border-b border-gray-200 max-h-96 overflow-y-auto">
                    @if(empty($cart))
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-700">Tu carrito está vacío</h3>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($cart as $index => $item)
                                <div class="flex items-start gap-3">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-md overflow-hidden border border-gray-200">
                                        @if($item['image'])
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-800 truncate">{{ $item['name'] }}</h4>
                                        <div class="flex items-center justify-between mt-1">
                                            <div class="flex items-center space-x-2">
                                                <button 
                                                    wire:click="decrementQuantity({{ $index }})"
                                                    class="w-6 h-6 flex items-center justify-center border border-gray-300 rounded-md text-gray-500 hover:bg-gray-100 transition"
                                                    {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <span class="text-sm">{{ $item['quantity'] }}</span>
                                                <button 
                                                    wire:click="incrementQuantity({{ $index }})"
                                                    class="w-6 h-6 flex items-center justify-center border border-gray-300 rounded-md text-gray-500 hover:bg-gray-100 transition"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Remove Button -->
                                    <button 
                                        wire:click="removeFromCart({{ $index }})"
                                        class="text-gray-400 hover:text-red-500 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Totals -->
                <div class="p-6 border-b border-gray-200">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Subtotal</span>
                            <span class="text-sm font-medium text-gray-700">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Impuestos (10%)</span>
                            <span class="text-sm font-medium text-gray-700">${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-200">
                            <span class="text-base font-medium text-gray-800">Total</span>
                            <span class="text-base font-bold text-blue-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="p-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Metodo de pago</label>
                    <select 
                        wire:model="paymentMethod"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    >
                        <option value="cash">Efectivo</option>
                        <option value="card">Tarjeta de Credito</option>
                        <option value="transfer">Transferencia Bancaria</option>
                    </select>
                    
                    @if($payment_method === 'cash')
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Efectivo recibido</label>
                            <input 
                                type="number" 
                                wire:model.live="cashReceived"
                                min="0"
                                step="0.01"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            >
                            
                            @if($cash_received > 0)
                                <div class="mt-3 p-3 bg-green-50 rounded-lg border border-green-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-green-700">Change Due</span>
                                        <span class="text-lg font-bold text-green-600">${{ number_format($change, 2) }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                
                <!-- Complete Sale Button -->
                <div class="p-6">
                    <button 
                        wire:click="completeSale"
                        @class([
                            'w-full py-3 px-6 rounded-lg font-medium transition-all duration-200',
                            'bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-lg' => !empty($cart),
                            'bg-gray-200 text-gray-500 cursor-not-allowed' => empty($cart),
                        ])
                        {{ empty($cart) ? 'disabled' : '' }}
                    >
                        Completar Venta
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

