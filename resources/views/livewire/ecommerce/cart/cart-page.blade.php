<div>
    <!-- Cart Header -->
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Tu Carrito</h1>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="container mx-auto px-4 py-8">
        @if(count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Table Header -->
                    <div class="hidden md:grid grid-cols-12 bg-gray-50 px-6 py-3 border-b">
                        <div class="col-span-6 font-medium text-gray-700">Producto</div>
                        <div class="col-span-2 font-medium text-gray-700">Precio</div>
                        <div class="col-span-2 font-medium text-gray-700">Cantidad</div>
                        <div class="col-span-2 font-medium text-gray-700">Total</div>
                    </div>
                    
                    <!-- Items -->
                    @foreach($cartItems as $item)
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-6 border-b last:border-b-0">
                        <!-- Product Image & Name -->
                        <div class="md:col-span-6 flex items-center">
                            <div class="flex-shrink-0 w-20 h-20 border rounded-md overflow-hidden">
                                <img src="{{ $item->associatedModel->getFirstMediaUrl('default', 'thumb') }}" 
                                     alt="{{ $item->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-900">{{ $item->name }}</h3>
                                @if($item->attributes->has('variant'))
                                <p class="text-sm text-gray-500">{{ $item->attributes->variant }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Price -->
                        <div class="md:col-span-2 flex md:block items-center">
                            <span class="md:hidden font-medium mr-2">Precio: </span>
                            <span>${{ number_format($item->price, 2) }}</span>
                        </div>
                        
                        <!-- Quantity -->
                        <div class="md:col-span-2 flex items-center">
                            <span class="md:hidden font-medium mr-2">Cantidad: </span>
                            <div class="flex items-center border rounded-md overflow-hidden">
                                <button wire:click="updateQuantity('{{ $item->id }}', {{ $item->quantity - 1 }})"
                                        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 transition"
                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="px-4 py-1">{{ $item->quantity }}</span>
                                <button wire:click="updateQuantity('{{ $item->id }}', {{ $item->quantity + 1 }})"
                                        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 transition">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Total -->
                        <div class="md:col-span-2 flex items-center justify-between">
                            <div>
                                <span class="md:hidden font-medium mr-2">Total: </span>
                                <span class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                            <button wire:click="removeItem('{{ $item->id }}')"
                                    class="text-red-500 hover:text-red-700 ml-4">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Coupon Code -->
                <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-medium text-lg mb-2">¿Tienes un código de descuento?</h3>
                    <div class="flex">
                        <input type="text" 
                               placeholder="Ingresa tu código"
                               class="flex-1 px-4 py-2 border rounded-l-md focus:ring-indigo-500 focus:border-indigo-500">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-md transition">
                            Aplicar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <h3 class="font-medium text-lg mb-4">Resumen del pedido</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span>Envío</span>
                            <span class="text-gray-600">Calculado al finalizar</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4 flex justify-between font-medium">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('ecommerce.checkout') }}"
                       class="mt-6 block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center py-3 px-4 rounded-md font-medium transition">
                        Proceder al pago
                    </a>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('ecommerce.shop') }}"
                           class="text-indigo-600 hover:text-indigo-800 text-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Continuar comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Tu carrito está vacío</h3>
            <p class="text-gray-600 mb-6">Aún no has agregado ningún producto a tu carrito</p>
            <a href="{{ route('ecommerce.shop') }}"
               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md font-medium transition">
                Explorar productos
            </a>
        </div>
        @endif
    </div>
</div>