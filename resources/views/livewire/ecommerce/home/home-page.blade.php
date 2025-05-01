<div>
    <!-- Hero Slider -->
    <livewire:ecommerce.home.hero-slider />
    
    <!-- Featured Categories -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Nuestras Categorías</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('ecommerce.shop.category', $category->slug) }}" 
                   class="group relative overflow-hidden rounded-xl shadow-md h-64">
                    <img src="{{ $category->getFirstMediaUrl('default', 'category_card') }}" 
                         alt="{{ $category->name }}"
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                        <h3 class="text-white text-xl font-bold">{{ $category->name }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <livewire:ecommerce.home.featured-products />
    
    <!-- Promotional Banner -->
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ofertas Especiales</h2>
            <p class="text-xl mb-6">Hasta 50% de descuento en la colección de verano</p>
            <a href="{{ route('ecommerce.shop') }}" 
               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition">
                Ver Ofertas
            </a>
        </div>
    </section>
</div>