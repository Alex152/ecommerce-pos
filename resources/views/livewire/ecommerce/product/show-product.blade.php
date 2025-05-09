<div class="bg-white">
    <!-- Breadcrumb -->
    <nav class="container mx-auto px-4 py-4 flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('ecommerce.home') }}" class="text-indigo-600 hover:text-indigo-800 transition">
                    <i class="fas fa-home mr-2"></i>
                    Inicio
                </a>
            </li>
            {{--
            <!-- En caso que sea coleccion de muchos-->
            @foreach($product->category as $category)
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a 
                            href="{{ route('ecommerce.shop.category', $category->slug) }}" 
                            class="text-indigo-600 hover:text-indigo-800 transition"
                        >
                            {{ $category->name }}
                        </a>
                    </div>
                </li>
            @endforeach
            
           <!-- Cambiar a for each si se cambia a coleccion -->
            @if($product->category)
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a 
                        href="{{ route('ecommerce.shop.category', $product->category->slug) }}" 
                        class="text-indigo-600 hover:text-indigo-800 transition"
                    >
                        {{ $product->category->name }}
                    </a>
                </div>
            </li>
        @endif    --}}
            
        @if($product->category)
            @php
                $category = $product->category;
                $ancestors = [];
                while ($category->parent) {
                    $ancestors[] = $category->parent;
                    $category = $category->parent;
                }
                $ancestors = array_reverse($ancestors);
            @endphp

            @foreach($ancestors as $ancestor)
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('ecommerce.shop.category', $ancestor->slug) }}" class="text-indigo-600 hover:text-indigo-800 transition">
                            {{ $ancestor->name }}
                        </a>
                    </div>
                </li>
            @endforeach

            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('ecommerce.shop.category', $product->category->slug) }}" class="text-indigo-600 hover:text-indigo-800 transition">
                        {{ $product->category->name }}
                    </a>
                </div>
            </li>
        @endif


            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Product Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Gallery -->
            <div>
                <div class="sticky top-6">
                    <!-- Main Image -->
                    <div class="mb-4 bg-gray-50 rounded-xl overflow-hidden">
                        <img 
                            src="{{ $selectedImage }}" 
                            alt="{{ $product->name }}"
                            class="w-full h-auto object-cover rounded-xl"
                            id="mainProductImage"
                            x-data="{
                                init() {
                                    const image = this.$el;
                                    new Drift(image, {
                                        paneContainer: image.parentElement,
                                        inlinePane: false,
                                        zoomFactor: 3,
                                        containInline: true,
                                        hoverBoundingBox: true
                                    });
                                }
                            }"
                        >
                    </div>

                    <!-- Thumbnails -->
                    <div class="grid grid-cols-5 gap-3">
                        @foreach($product->media as $media)
                            <button 
                                wire:click="selectImage('{{ $media->getUrl('large') }}')"
                                class="border rounded-lg overflow-hidden transition"
                                :class="{ 'border-indigo-500 ring-2 ring-indigo-300': '{{ $media->getUrl('large') }}' === selectedImage }"
                            >
                                <img 
                                    src="{{ $media->getUrl('thumb') }}" 
                                    alt="{{ $product->name }}"
                                    class="w-full h-auto object-cover"
                                >
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $product->rating ? '' : '-half-alt' }} text-yellow-400"></i>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500 ml-2">({{ $product->reviews_count }} reseñas)</span>
                    <span class="mx-2 text-gray-300">|</span>
                    <span class="text-sm text-green-600">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ $product->stock_quantity > 0 ? 'En stock' : 'Agotado' }}
                    </span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    @if($product->sale_price)
                        <span class="text-4xl font-bold text-gray-900">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-xl text-gray-500 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                        <span class="ml-3 bg-red-100 text-red-800 text-sm font-semibold px-2 py-1 rounded-full">
                            {{ number_format(100 - ($product->sale_price / $product->price * 100), 0) }}% OFF
                        </span>
                    @else
                        <span class="text-4xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <!-- Variants -->
                @if($product->variants->isNotEmpty())
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Variantes:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->variants as $variant)
                                <button 
                                    wire:key="variant-{{ $variant->id }}"
                                    wire:click="selectVariant({{ $variant->id }})"
                                    class="px-4 py-2 border rounded-full text-sm transition"
                                    :class="{ 
                                        'border-indigo-500 bg-indigo-50 text-indigo-700': {{ $variant->id }} === selectedVariant, 
                                        'border-gray-300 hover:border-gray-400': {{ $variant->id }} !== selectedVariant 
                                    }"
                                >
                                    {{ $variant->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description Short -->
                <div class="prose max-w-none text-gray-600 mb-6">
                    {!! $product->short_description !!}
                </div>

                <!-- Add to Cart -->
                <div class="flex items-center space-x-4 mb-8">
                    <div class="flex items-center border rounded-md overflow-hidden">
                        <button 
                            wire:click="decreaseQuantity"
                            class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition"
                            :disabled="quantity <= 1"
                        >
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="px-4 py-2">{{ $quantity }}</span>
                        <button 
                            wire:click="increaseQuantity"
                            class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition"
                        >
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <button 
                        wire:click="addToCart"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-md font-medium transition flex items-center justify-center"
                    >
                        <i class="fas fa-cart-plus mr-2"></i>
                        Añadir al carrito
                    </button>
                    <button class="p-3 text-gray-400 hover:text-red-500 transition">
                        <i class="far fa-heart text-xl"></i>
                    </button>
                </div>

                <!-- Details -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="sr-only">Detalles</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 text-indigo-600">
                                <i class="fas fa-truck text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Envíos y devoluciones</h4>
                                <p class="text-sm text-gray-500">Envío gratuito en pedidos superiores a $50. Devoluciones fáciles dentro de 30 días.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 text-indigo-600">
                                <i class="fas fa-shield-alt text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Garantía</h4>
                                <p class="text-sm text-gray-500">Garantía del fabricante de 2 años en todos los productos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mt-16" x-data="{ activeTab: 'description' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button
                        @click="activeTab = 'description'"
                        class="py-4 px-1 border-b-2 font-medium text-sm"
                        :class="activeTab === 'description' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    >
                        Descripción
                    </button>
                    <button
                        @click="activeTab = 'specifications'"
                        class="py-4 px-1 border-b-2 font-medium text-sm"
                        :class="activeTab === 'specifications' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    >
                        Especificaciones
                    </button>
                    <button
                        @click="activeTab = 'reviews'"
                        class="py-4 px-1 border-b-2 font-medium text-sm"
                        :class="activeTab === 'reviews' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    >
                        Reseñas ({{ $product->reviews_count }})
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="py-8">
                <div x-show="activeTab === 'description'" class="prose max-w-none" x-cloak>
                    {!! $product->description !!}
                </div>

                {{-- Especificaciones (puedes descomentar si usas esto) --}}
                {{-- 
                <div x-show="activeTab === 'specifications'" class="space-y-4" x-cloak>
                    <h3 class="text-lg font-medium text-gray-900">Especificaciones técnicas</h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            @foreach($product->specifications as $spec)
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">{{ $spec['name'] }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $spec['value'] }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>
                --}}

                <div x-show="activeTab === 'reviews'" class="space-y-8" x-cloak>
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Opiniones de clientes</h3>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Escribir una reseña
                        </button>
                    </div>

                    <div class="space-y-8">
                        @foreach($product->reviews as $review)
                            <div class="border-b border-gray-200 pb-8">
                                <div class="flex items-center mb-4">
                                    <div class="flex items-center mr-4">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $review->rating ? '' : '-half-alt' }} text-yellow-400"></i>
                                        @endfor
                                    </div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $review->customer->name }}</h4>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                                <p class="text-gray-600 mb-2">{{ $review->comment }}</p>
                                @if($review->response)
                                    <div class="bg-gray-50 p-4 rounded-lg mt-4">
                                        <p class="text-sm font-medium text-gray-900 mb-1">Respuesta de la tienda:</p>
                                        <p class="text-gray-600 text-sm">{{ $review->response }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <!-- Related Products -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Productos relacionados</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($product->relatedProducts() as $related)
                    <livewire:ecommerce.shop.product-card :product="$related" :key="'related-'.$related->id" />
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Drift/1.4.1/Drift.min.js"></script>
@endpush