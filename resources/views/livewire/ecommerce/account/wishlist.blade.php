<div>
    <div class="bg-white py-6 border-b">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold">Mi Lista de Deseos</h1>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform hover:-translate-y-1 hover:shadow-lg">
                <a href="{{ route('ecommerce.product.show', $product->slug) }}" class="block relative h-48 overflow-hidden">
                    <img src="{{ $product->getFirstMediaUrl('default', 'product_card') }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover transition duration-300 hover:opacity-90">
                    <button wire:click="removeFromWishlist({{ $product->id }})"
                            class="absolute top-2 right-2 bg-white rounded-full p-2 text-red-500 hover:text-red-700 shadow-md transition"
                            title="Eliminar de la lista">
                        <i class="fas fa-heart"></i>
                    </button>
                </a>
                <div class="p-4">
                    <a href="{{ route('ecommerce.product.show', $product->slug) }}" class="block font-medium text-gray-900 hover:text-indigo-600 mb-1">
                        {{ $product->name }}
                    </a>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        <button wire:click="$emit('addToCart', {{ $product->id }})"
                                class="text-indigo-600 hover:text-indigo-800 transition"
                                title="Añadir al carrito">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($products->hasMorePages())
        <div class="mt-8 text-center">
            <button wire:click="loadMore"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Cargar más productos
            </button>
        </div>
        @endif
        @else
        <div class="text-center py-12">
            <i class="fas fa-heart text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tu lista de deseos está vacía</h3>
            <p class="text-gray-600 mb-6">Guarda tus productos favoritos aquí para verlos más tarde</p>
            <a href="{{ route('ecommerce.shop') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Explorar productos
            </a>
        </div>
        @endif
    </div>
</div>