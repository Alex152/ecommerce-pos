<div 
    x-data="{
        hover: false,
        quickViewOpen: @entangle('showQuickView'),
        init() {
            // Variant selection
            Livewire.on('variantSelected', (variantId) => {
                this.$wire.selectedVariant = variantId;
            });
        }
    }"
    @mouseenter="hover = true" 
    @mouseleave="hover = false"
    class="relative bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl"
>
    <!-- Badges -->
    @if($product->sale_price)
        <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full z-10">
            -{{ number_format(100 - ($product->sale_price / $product->price * 100), 0) }}%
        </div>
    @endif

    <!-- Product Image -->
    <a href="{{ route('ecommerce.product.show', $product->slug) }}" class="block relative h-64 overflow-hidden">
        <img 
            src="{{ $product->getFirstMediaUrl('default', 'product_card') }}" 
            alt="{{ $product->name }}"
            class="w-full h-full object-cover transition-opacity duration-300"
            :class="{ 'opacity-100': !hover, 'opacity-90': hover }"
        >
        <div 
            class="absolute inset-0 bg-black bg-opacity-0 flex items-center justify-center transition-all duration-300"
            :class="{ 'bg-opacity-0': !hover, 'bg-opacity-20': hover }"
        >
            <button 
                @click.stop="quickViewOpen = true" 
                class="bg-white rounded-full p-3 shadow-lg transform transition-all duration-300"
                :class="{ 'scale-0': !hover, 'scale-100': hover }"
            >
                <i class="fas fa-eye text-gray-800"></i>
            </button>
        </div>
    </a>

    <!-- Product Info -->
    <div class="p-4">
        <div class="flex justify-between items-start mb-1">
            <a href="{{ route('ecommerce.product.show', $product->slug) }}" class="font-semibold text-gray-900 hover:text-indigo-600 transition">
                {{ $product->name }}
            </a>
            @if($product->variants->isNotEmpty())
                <button 
                    @click.stop="quickViewOpen = true"
                    class="text-gray-400 hover:text-indigo-600 transition"
                    title="Ver variantes"
                >
                    <i class="fas fa-list-ul"></i>
                </button>
            @endif
        </div>

        <div class="flex items-center mb-2">
            <div class="flex text-yellow-400 mr-2">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= $product->rating ? '' : '-half-alt' }}"></i>
                @endfor
            </div>
            <span class="text-sm text-gray-500">({{ $product->reviews_count }})</span>
        </div>

        <div class="flex items-center justify-between">
            <div>
                @if($product->sale_price)
                    <span class="text-lg font-bold text-gray-900">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-sm text-gray-500 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            <button 
                wire:click="addToCart"
                class="text-indigo-600 hover:text-indigo-800 transition"
                title="Añadir al carrito"
            >
                <i class="fas fa-cart-plus text-xl"></i>
            </button>
        </div>
    </div>

    <!-- Quick View Modal -->
    <x-modal wire:model.defer="showQuickView" maxWidth="4xl">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Product Gallery -->
                <div>
                    <div class="sticky top-6">
                        <livewire:ecommerce.product.image-gallery :product="$product" />
                    </div>
                </div>

                <!-- Product Details -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $product->rating ? '' : '-half-alt' }}"></i>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">({{ $product->reviews_count }} reseñas)</span>
                    </div>

                    <div class="mb-6">
                        @if($product->sale_price)
                            <span class="text-3xl font-bold text-gray-900">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-lg text-gray-500 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <div class="prose max-w-none text-gray-600 mb-6">
                        {!! $product->description !!}
                    </div>

                    <!-- Variants -->
                    @if($product->variants->isNotEmpty())
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Variantes:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->variants as $variant)
                                    <button 
                                        wire:key="variant-{{ $variant->id }}"
                                        @click="$dispatch('variantSelected', {{ $variant->id }})"
                                        class="px-3 py-1 border rounded-full text-sm transition"
                                        :class="{ 
                                            'border-indigo-500 bg-indigo-50 text-indigo-700': $wire.selectedVariant === {{ $variant->id }}, 
                                            'border-gray-300 hover:border-gray-400': $wire.selectedVariant !== {{ $variant->id }} 
                                        }"
                                    >
                                        {{ $variant->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Add to Cart -->
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center border rounded-md overflow-hidden">
                            <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition">-</button>
                            <span class="px-4 py-2">1</span>
                            <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition">+</button>
                        </div>
                        <button 
                            wire:click="addToCart"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md font-medium transition flex items-center justify-center"
                        >
                            <i class="fas fa-cart-plus mr-2"></i>
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
</div>