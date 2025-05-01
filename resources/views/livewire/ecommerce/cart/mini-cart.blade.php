<div 
    x-data="{ open: false }"
    x-show="open"
    @cart-open.window="open = true"
    @click.away="open = false"
    class="fixed inset-y-0 right-0 z-50 w-full max-w-md bg-white shadow-xl transform transition-transform duration-300 ease-in-out"
    :class="{ 'translate-x-0': open, 'translate-x-full': !open }"
    x-cloak
>
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between border-b px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Tu Carrito</h3>
            <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto px-6 py-4">
            
            @if(\Cart::count() == 0)

                <div class="text-center py-12">
                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Tu carrito está vacío</p>
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach(\Cart::getContent() as $item)
                        <li class="py-4 flex">
                            <div class="flex-shrink-0 w-20 h-20 border border-gray-200 rounded-md overflow-hidden">
                                <img 
                                    src="{{ $item->associatedModel->getFirstMediaUrl('default', 'thumb') }}" 
                                    alt="{{ $item->name }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>

                            <div class="ml-4 flex-1 flex flex-col">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <h3>{{ $item->name }}</h3>
                                    <p>${{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                                <div class="flex-1 flex items-end justify-between text-sm">
                                    <div class="flex items-center">
                                        <select 
                                            wire:change="updateQuantity('{{ $item->id }}', $event.target.value)"
                                            class="border rounded-md py-1 px-2 text-sm"
                                        >
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ $i == $item->quantity ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button 
                                        wire:click="removeItem('{{ $item->id }}')"
                                        class="text-red-500 hover:text-red-700"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-200 px-6 py-4">
            <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                <p>Subtotal</p>
                <p>${{ number_format(\Cart::subtotal(), 2) }}</p>
            </div>
            <div class="flex justify-between text-sm text-gray-500 mb-4">
                <p>Envío</p>
                <p>Calculado al finalizar</p>
            </div>
            <a 
                href="{{ route('ecommerce.checkout') }}"
                class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center py-3 px-4 rounded-md font-medium transition"
            >
                Finalizar compra
            </a>
            <div class="mt-4 flex justify-center text-sm text-gray-500">
                <a href="{{ route('ecommerce.cart') }}" class="text-indigo-600 hover:text-indigo-500">
                    Ver carrito completo
                </a>
            </div>
        </div>
    </div>
</div>