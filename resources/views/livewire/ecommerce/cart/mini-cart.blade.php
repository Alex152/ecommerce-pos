<div 
    x-data="{
        open: false,
        headerHeight: 0,
        calculateHeaderHeight() {
            const header = document.querySelector('header');
            this.headerHeight = header ? header.offsetHeight : 80;
        }
    }"
    x-init="calculateHeaderHeight(); $watch('open', () => open && calculateHeaderHeight())"
    @cart-open.window="open = true"
    @cart-close.window="open = false"
    @keydown.escape.window="open = false"
    @click.away="open = false"
    class="fixed inset-0 z-50 overflow-hidden"
    x-cloak
    x-show="open"
>
    <!-- Overlay con efecto de blur -->
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
         x-show="open"
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false">
    </div>
    
    <!-- Panel del carrito     (En caso de desaer que el carrito no se sobreponga al header)
    <div class="absolute inset-y-0 right-0 max-w-full flex"
         :style="`top: ${headerHeight}px; height: calc(100vh - ${headerHeight}px)`">  -->
    <div class="absolute top-0 bottom-0 right-0 max-w-full flex h-full">
        <div class="relative w-screen max-w-md"
             x-show="open"
             x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">
            
            <div class="flex flex-col h-full bg-white shadow-xl">
                <!-- Header del carrito -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Tu Carrito
                    </h2>
                    <button @click="open = false" class="p-2 -mr-2 text-gray-400 hover:text-gray-500 rounded-full hover:bg-gray-100 transition-all">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Contenido del carrito -->
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    @if(Cart::count() == 0)
                        <!-- Estado vacío -->
                        <div class="text-center py-12">
                            <div class="mx-auto h-24 w-24 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Carrito vacío</h3>
                            <p class="mt-1 text-gray-500">Comienza a agregar algunos productos increíbles</p>
                            <div class="mt-6">
                                <button @click="open = false" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Continuar comprando
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Lista de productos -->
                        <ul class="divide-y divide-gray-200">
                            @foreach(Cart::content() as $item)
                                <li class="py-6 flex group" wire:key="cart-item-{{ $item->rowId }}">
                                    <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden relative">
                                        {{--<img src="{{ $item->model->getFirstMediaUrl('default', 'thumb') }}"    DE ERROR model null--}}
                                        <img src="{{ optional($item->model)->main_image_url }}"
                                             alt="{{ $item->name }}" 
                                             class="w-full h-full object-cover object-center">
                                        <button wire:click="removeItem('{{ $item->rowId }}')"
                                                class="absolute -top-2 -right-2 bg-white rounded-full p-1 shadow-sm border border-gray-200 text-gray-400 hover:text-red-500 hover:border-red-200 transition-all opacity-0 group-hover:opacity-100">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3 class="hover:text-indigo-600 transition-colors">
                                                    {{--<a href="{{ route('ecommerce.product.show', $item->model->slug) }}">{{ $item->name }}</a>--}}
                                                    @if($item->model)
                                                        <a href="{{ route('ecommerce.product.show', $item->model->slug) }}">
                                                            {{ $item->name }}
                                                        </a>
                                                    @else
                                                        <span>{{ $item->name }}</span>
                                                    @endif

                                                </h3>
                                                <p class="ml-4">${{ number_format($item->price * $item->qty, 2) }}</p>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">{{ $item->model->short_description }}</p>
                                        </div>
                                        <div class="flex-1 flex items-end justify-between text-sm">
                                            <div class="flex items-center">
                                                <label for="quantity-{{ $item->rowId }}" class="sr-only">Cantidad</label>
                                                <select id="quantity-{{ $item->rowId }}"
                                                        wire:change="updateQuantity('{{ $item->rowId }}', $event.target.value)"
                                                        class="max-w-full rounded-md border border-gray-300 py-1.5 px-3 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                                    @foreach(range(1, 10) as $qty)
                                                        <option value="{{ $qty }}" {{ $qty == $item->qty ? 'selected' : '' }}>{{ $qty }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="flex">
                                                <button wire:click="removeItem('{{ $item->rowId }}')"
                                                        class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                                                    Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Resumen del pedido -->
                <div class="border-t border-gray-200 px-6 py-4">
                    <div class="flex justify-between text-base font-medium text-gray-900 mb-2">
                        <p>Subtotal</p>
                        <p>${{ Cart::subtotal() }}</p>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500 mb-4">
                        <p>Envío</p>
                        <p>Calculado al finalizar</p>
                    </div>
                    <div class="mb-4">
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" name="discount-code" id="discount-code" 
                                   class="block w-full rounded-md border-gray-300 pl-4 pr-12 py-3 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="Código de descuento">
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                <button type="button" class="h-full rounded-r-md border border-transparent bg-indigo-600 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                    Aplicar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('ecommerce.checkout') }}" 
                           class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 w-full transition-all transform hover:-translate-y-0.5 hover:shadow-lg">
                            Finalizar compra
                        </a>
                    </div>
                    <div class="mt-4 flex justify-center text-sm text-gray-500">
                        <p>
                            o <button @click="open = false" class="font-medium text-indigo-600 hover:text-indigo-500 ml-1">Continuar comprando<span aria-hidden="true"> &rarr;</span></button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>