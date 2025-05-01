<div>
    <!-- Shop Header -->
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <h1 class="text-3xl font-bold mb-4 md:mb-0">Nuestros Productos</h1>
                
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <!-- Search -->
                    <div class="relative flex-1">
                        <input type="text" 
                               wire:model.debounce.500ms="search"
                               placeholder="Buscar productos..."
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    
                    <!-- Sort -->
                    <select wire:model="sort"
                            class="border rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="latest">Más recientes</option>
                        <option value="price_asc">Precio: Menor a Mayor</option>
                        <option value="price_desc">Precio: Mayor a Menor</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-4">
                    <h3 class="font-bold text-lg mb-4">Filtrar por</h3>
                    
                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Categorías</h4>
                        <ul class="space-y-2">
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('ecommerce.shop.category', $category->slug) }}"
                                   class="flex items-center justify-between hover:text-indigo-600 transition">
                                    <span>{{ $category->name }}</span>
                                    <span class="bg-gray-100 px-2 py-1 rounded-full text-xs">
                                        {{ $category->products_count }}
                                    </span>
                                </a>
                                
                                @if($category->children->count())
                                <ul class="ml-4 mt-2 space-y-2">
                                    @foreach($category->children as $child)
                                    <li>
                                        <a href="{{ route('ecommerce.shop.category', $child->slug) }}"
                                           class="flex items-center justify-between hover:text-indigo-600 transition">
                                            <span>{{ $child->name }}</span>
                                            <span class="bg-gray-100 px-2 py-1 rounded-full text-xs">
                                                {{ $child->products_count }}
                                            </span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Price Filter -->
                    <div>
                        <h4 class="font-medium mb-2">Rango de precios</h4>
                        <!-- Implementar slider de precios -->
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="lg:w-3/4">
                @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <livewire:ecommerce.shop.product-card :product="$product" :key="'product-'.$product->id" />
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
                @else
                <div class="text-center py-12">
                    <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No se encontraron productos</p>
                    <a href="{{ route('ecommerce.shop') }}" 
                       class="inline-block mt-4 text-indigo-600 hover:text-indigo-800">
                        Ver todos los productos
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>