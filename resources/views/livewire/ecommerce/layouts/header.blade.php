<header class="sticky top-0 z-50 bg-white shadow-sm">
    <!-- Top Bar -->
    <div class="bg-indigo-900 text-white text-sm py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex space-x-4">
                <span><i class="fas fa-phone-alt mr-1"></i> +1 234 567 890</span>
                <span><i class="fas fa-envelope mr-1"></i> contacto@tienda.com</span>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-indigo-300 transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-indigo-300 transition"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-indigo-300 transition"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('ecommerce.home') }}" class="text-3xl font-bold text-indigo-600 flex items-center">
                <svg class="h-10 w-10 text-indigo-800" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                <span class="ml-2">ShopName</span>
            </a>

            <!-- Search Bar -->
            <div class="hidden md:block mx-8 flex-1 max-w-xl">
                <form action="{{ route('ecommerce.shop') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Buscar productos..." 
                               class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Icons -->
            <div class="flex items-center space-x-6">
                @auth
                <a href="{{ route('ecommerce.account.wishlist') }}" class="text-gray-600 hover:text-indigo-600 transition relative">
                    <i class="far fa-heart text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ auth()->user()->wishlist()->count() }}
                    </span>
                </a>
                @endauth
                
                <button @click="$dispatch('open-cart')" class="text-gray-600 hover:text-indigo-600 transition relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ Cart::count() }}
                    </span>
                </button>
                
                @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600">
                        <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                        <i class="fas fa-user-circle text-xl"></i>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('ecommerce.account.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Mi Cuenta</a>
                        <a href="{{ route('ecommerce.account.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Mis Pedidos</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('ecommerce.login') }}" class="text-gray-600 hover:text-indigo-600 transition">
                    <i class="fas fa-user text-xl"></i>
                    <span class="hidden sm:inline ml-1">Ingresar</span>
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="hidden md:block bg-indigo-800 text-white">
        <div class="container mx-auto px-4">
            <div class="flex space-x-8">
                <a href="{{ route('ecommerce.home') }}" class="py-3 px-2 font-medium hover:bg-indigo-700 transition">Inicio</a>
                
                @foreach($categories as $category)
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center py-3 px-2 font-medium hover:bg-indigo-700 transition">
                        {{ $category->name }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    @if($category->children->count())
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute z-10 mt-0 w-48 bg-white shadow-lg rounded-b-md">
                        @foreach($category->children as $child)
                        <a href="{{ route('ecommerce.shop.category', $child->slug) }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                            {{ $child->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
                
                <a href="#" class="py-3 px-2 font-medium hover:bg-indigo-700 transition">Ofertas</a>
                <a href="#" class="py-3 px-2 font-medium hover:bg-indigo-700 transition">Contacto</a>
            </div>
        </div>
    </nav>
</header>