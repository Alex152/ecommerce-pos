<div class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Productos Destacados</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Descubre nuestros productos más populares y mejor valorados</p>
        </div>

        <div 
            x-data="{
                animateCards() {
                    gsap.utils.toArray('.product-card').forEach((card, i) => {
                        gsap.from(card, {
                            duration: 0.6,
                            y: 50,
                            opacity: 0,
                            ease: 'back.out(1.7)',
                            delay: i * 0.1
                        });
                    });
                }
            }"
            x-init="animateCards()"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
        >
            @foreach($products as $product)
                <livewire:ecommerce.shop.product-card 
                    :product="$product" 
                    :key="'featured-'.$product->id" 
                    class="product-card"
                />
            @endforeach
        </div>

        @if($products->count() >= $perPage)
            <div class="text-center mt-10">
                <button 
                    wire:click="loadMore"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:-translate-y-1"
                >
                    Ver más productos
                    <i class="fas fa-arrow-down ml-2"></i>
                </button>
            </div>
        @endif
    </div>
</div>