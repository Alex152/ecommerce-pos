<header x-data="{ 
    mobileMenuOpen: false, 
    searchOpen: false, 
    mobileSubmenus: {},
    scrolled: false,
    megaMenuOpen: null,
    cartPreviewOpen: false,
    announcementClosed: false
}" 
@scroll.window="scrolled = window.scrollY > 10"
class="sticky top-0 z-50 bg-white transition-all duration-300"
:class="{ 'shadow-xl': scrolled || mobileMenuOpen || searchOpen }">

    <!-- Premium Announcement Bar with Close Button -->
    <div x-show="!announcementClosed" x-transition
         class="bg-gradient-to-r from-indigo-900 via-purple-800 to-pink-700 text-white text-center py-2 px-4 text-sm font-medium relative">
        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
        <div class="container mx-auto flex justify-center items-center relative">
            <div class="flex items-center animate-pulse">
                <span class="mr-2">✨</span>
                <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full bg-white bg-opacity-20 text-xs font-medium">
                    EXCLUSIVO
                </span>
            </div>
            <span class="mx-3 truncate font-semibold">¡FLASH SALE! 40% DE DESCUENTO + Envío GRATIS en pedidos +$50</span>
            <button class="ml-2 px-3 py-1 bg-white bg-opacity-0 hover:bg-opacity-10 rounded-full text-xs font-semibold transition-all duration-200 border border-white border-opacity-30 hover:border-opacity-50 flex items-center">
                <span class="hidden sm:inline">Aplicar código</span>
                <span class="inline sm:hidden">¡OFERTA!</span>
                <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <button @click="announcementClosed = true" class="ml-3 p-1 rounded-full hover:bg-white hover:bg-opacity-10 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Main Header -->
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16 md:h-20">
                
                <!-- Logo & Mobile Menu Button -->
                <div class="flex items-center flex-1 md:flex-none">
                    <!-- Premium Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen; searchOpen = false" 
                            class="md:hidden p-2 -ml-2 rounded-md text-gray-600 hover:text-indigo-600 hover:bg-gray-50 group transition-all"
                            aria-label="Menú principal">
                        <div class="flex flex-col items-center justify-center w-6 h-6">
                            <span class="block h-0.5 w-6 bg-current transform transition duration-300 ease-in-out" 
                                  :class="{'rotate-45 translate-y-1.5': mobileMenuOpen}"></span>
                            <span class="block h-0.5 w-6 bg-current mt-1.5 transform transition duration-300 ease-in-out" 
                                  :class="{'opacity-0': mobileMenuOpen}"></span>
                            <span class="block h-0.5 w-6 bg-current mt-1.5 transform transition duration-300 ease-in-out" 
                                  :class="{'-rotate-45 -translate-y-1.5': mobileMenuOpen}"></span>
                        </div>
                    </button>
                    
                    <!-- Premium Logo with Animation -->
                    <a href="{{ route('ecommerce.home') }}" class="flex items-center group transform hover:-translate-y-0.5 transition-all duration-200">
                        <div class="flex items-center justify-center w-10 h-10 md:w-12 md:h-12 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 group-hover:from-indigo-500 group-hover:to-purple-500 transition-all shadow-lg group-hover:shadow-xl relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-white to-transparent opacity-0 group-hover:opacity-10 transition-opacity"></div>
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="ml-3 text-xl md:text-2xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent tracking-tight">
                            <span class="font-extrabold">Beauty</span>Store
                        </span>
                    </a>
                </div>

                <!-- Premium Desktop Navigation -->
                <nav class="hidden md:flex mx-6 space-x-1">
                    @foreach($categories->take(4) as $category)
                    <div x-data="{ open: false }" class="relative" 
                         @mouseenter="open = true; megaMenuOpen = '{{ $category->id }}'" 
                         @mouseleave="open = false; megaMenuOpen = null">
                        <button @click="open = !open"
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-md transition-all group"
                                :class="{ 'text-indigo-600': open }">
                            <span class="relative">
                                {{ $category->name }}
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
                                      :class="{'w-full': open}"></span>
                            </span>
                            @if($category->children->count())
                            <svg class="ml-1 h-4 w-4 transform transition-transform" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            @endif
                        </button>

                        <!-- Premium Mega Menu -->
                        @if($category->children->count())
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-1/2 z-20 w-96 max-w-6xl px-4 transform -translate-x-1/2">
                            <div class="overflow-hidden rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 bg-white">
                                <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8 lg:grid-cols-2">
                                    @foreach($category->children as $child)
                                    <a href="{{ route('ecommerce.shop.category', $child->slug) }}" 
                                       class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50 transition-all duration-200 group">
                                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-gradient-to-br from-indigo-500 to-purple-500 text-white sm:h-12 sm:w-12 shadow-sm group-hover:shadow-md transition-all">
                                            <i class="fas fa-{{ $child->icon ?? 'tag' }} text-sm"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-base font-medium text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                {{ $child->name }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $child->description ?? 'Ver todos los productos' }}
                                            </p>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-5 sm:p-8 border-t border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 text-white shadow-md">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">Colección {{ $category->name }}</h3>
                                            <p class="mt-1 text-sm text-gray-600">Descubre nuestros productos más populares en esta categoría.</p>
                                            <a href="{{ route('ecommerce.shop.category', $category->slug) }}" class="mt-2 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors">
                                                Ver colección completa
                                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    
                    <!-- Premium "More" dropdown -->
                    @if($categories->count() > 5)
                    <div x-data="{ open: false }" class="relative"
                         @mouseenter="open = true" 
                         @mouseleave="open = false">
                        <button @click="open = !open" 
                                
                                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-md transition-colors group"
                                :class="{ 'text-indigo-600': open }">
                            <span class="relative">
                                Más
                                <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
                                      :class="{'w-full': open}"></span>
                            </span>
                            <svg class="ml-1 h-4 w-4 transform transition-transform" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div x-show="open" x-cloak
                             @click.away="open = false"
                             class="absolute left-0 z-10 mt-2 w-56 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden">
                            <div class="py-1">
                                @foreach($categories->slice(4) as $category)
                                <a href="{{ route('ecommerce.shop.category', $category->slug) }}" 
                                   class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-200 mr-3 transition-all group-hover:bg-indigo-600"></span>
                                    {{ $category->name }}
                                </a>
                                @endforeach
                                <div class="border-t border-gray-100 mt-1 pt-1 bg-gray-50">
                                    <a href="#" class="block px-4 py-2.5 text-sm font-medium text-indigo-600 hover:bg-indigo-50 transition-colors flex items-center">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 mr-3"></span>
                                        Ver todas las categorías
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </nav>

                <!-- Premium Action Buttons -->
                <div class="flex items-center space-x-3 md:space-x-5">
                    <!-- Premium Search Button (Mobile) -->
                    <button @click="searchOpen = !searchOpen; mobileMenuOpen = false" 
                            class="md:hidden p-2 rounded-md text-gray-500 hover:text-indigo-600 hover:bg-gray-50 transition-all relative">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    
                    <!-- Premium Search Bar (Desktop) -->
                    <div class="hidden md:block relative w-64 xl:w-80">
                        <form action="{{ route('ecommerce.shop') }}" method="GET" class="relative">
                            <input type="text" name="search" placeholder="Buscar productos, marcas..." 
                                   class="block w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-full focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 shadow-sm hover:shadow-md transition-all duration-300 bg-gray-50 focus:bg-white">
                            <button type="submit" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Premium User Account -->
                    @auth
                    <div x-data="{ open: false }" class="relative hidden md:block">
                        <button @click="open = !open" 
                                class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors group relative"
                                aria-label="Mi cuenta">
                            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 border-2 border-indigo-50 group-hover:border-indigo-100 transition-all shadow-sm group-hover:shadow-md relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-white to-transparent opacity-0 group-hover:opacity-20 transition-opacity"></div>
                                <span class="text-sm font-medium text-indigo-700">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </div>
                            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-600"></span>
                            </span>
                        </button>
                        
                        <div x-show="open" x-cloak
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none z-30 overflow-hidden">
                            <div class="py-1.5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50 px-4 py-3">
                                <p class="text-sm font-medium text-gray-900 truncate">Hola, {{ auth()->user()->name }}</p>
                                <p class="text-xs text-indigo-600 mt-0.5">Nivel Oro <span class="text-gray-500">· 240 pts</span></p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('ecommerce.account.dashboard') }}" 
                                   class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Mi perfil
                                </a>
                                <a href="{{ route('ecommerce.account.orders') }}" 
                                   class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Mis pedidos
                                </a>
                                <a href="{{ route('ecommerce.account.wishlist') }}" 
                                   class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Lista de deseos
                                    <span class="ml-auto bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                        {{ auth()->user()->wishlist()->count() }}
                                    </span>
                                </a>
                            </div>
                            <div class="border-t border-gray-100 py-1 bg-gray-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                        <svg class="h-4 w-4 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('ecommerce.login') }}" 
                       class="hidden md:flex items-center space-x-1 text-gray-700 hover:text-indigo-600 transition-colors group"
                       aria-label="Iniciar sesión">
                        <div class="flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-50 border-2 border-gray-100 hover:border-indigo-100 transition-all shadow-sm group-hover:shadow-md">
                            <svg class="h-5 w-5 text-gray-500 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </a>
                    @endauth
                    
                    <!-- Premium Wishlist -->
                    @auth
                    <a href="{{ route('ecommerce.account.wishlist') }}" 
                       class="hidden md:flex items-center justify-center w-9 h-9 rounded-full text-gray-600 hover:text-indigo-600 hover:bg-gray-50 transition-all relative group"
                       aria-label="Lista de deseos">
                        <div class="absolute inset-0 rounded-full border-2 border-transparent group-hover:border-indigo-100 transition-all"></div>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span x-show="{{ auth()->user()->wishlist()->count() > 0 }}" 
                              class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center border-2 border-white shadow-sm">
                            {{ min(auth()->user()->wishlist()->count(), 9) }}{{ auth()->user()->wishlist()->count() > 9 ? '+' : '' }}
                        </span>
                    </a>
                    @endauth
                    
                    <!-- Premium Cart with Preview -->
                    <div x-data="{ open: false }" class="relative"
                         @mouseenter="open = true"
                         @mouseleave="open = false">{{--
                        <button @click="open = !open; $dispatch('open-cart')" 
                                
                                class="flex items-center justify-center w-9 h-9 rounded-full text-gray-600 hover:text-indigo-600 hover:bg-gray-50 transition-all relative group"
                                aria-label="Carrito de compras">
                            <div class="absolute inset-0 rounded-full border-2 border-transparent group-hover:border-indigo-100 transition-all"></div>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span x-show="{{ Cart::count() > 0 }}" 
                                  class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center border-2 border-white shadow-sm">
                                {{ min(Cart::count(), 9) }}{{ Cart::count() > 9 ? '+' : '' }}
                            </span>
                        </button>--}}
                        <!-- Este reemplaza el botón actual del carrito por este: -->
                        <button @click="$dispatch('cart-open')" 
                                class="flex items-center justify-center w-9 h-9 rounded-full text-gray-600 hover:text-indigo-600 hover:bg-gray-50 transition-all relative group"
                                aria-label="Carrito de compras">
                            <div class="absolute inset-0 rounded-full border-2 border-transparent group-hover:border-indigo-100 transition-all"></div>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span x-show="{{ Cart::count() > 0 }}" 
                                class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center border-2 border-white shadow-sm">
                                {{ min(Cart::count(), 9) }}{{ Cart::count() > 9 ? '+' : '' }}
                            </span>
                        </button>
                        
                        <!-- Premium Cart Preview -->
                        <div x-show="open" x-cloak
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none z-30 overflow-hidden">
                            <div class="py-2 px-4 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-gray-900">Tu carrito</h3>
                                    <span class="text-xs font-medium text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full">
                                        {{ Cart::count() }} {{ Cart::count() === 1 ? 'item' : 'items' }}
                                    </span>
                                </div>
                            </div>
                            <div class="py-2 px-4 max-h-96 overflow-y-auto">
                                @if(Cart::count() > 0)
                                    <!-- Sample cart items - in a real app you would loop through cart items -->
                                    <div class="flex py-3 border-b border-gray-100 group">
                                        <div class="flex-shrink-0 relative">
                                            <img class="h-14 w-14 rounded-md object-cover border border-gray-200 group-hover:border-indigo-300 transition-colors" src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&h=100&q=80" alt="Product">
                                            <button class="absolute -top-2 -right-2 bg-white rounded-full p-0.5 shadow-sm border border-gray-200 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="flex justify-between">
                                                <p class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors">Crema Facial Premium</p>
                                                <p class="text-sm font-medium text-gray-900">$19.99</p>
                                            </div>
                                            <p class="text-xs text-gray-500">Cuidado de la piel</p>
                                            <div class="mt-1 flex items-center">
                                                <button class="text-gray-400 hover:text-indigo-600">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <span class="mx-2 text-xs font-medium">1</span>
                                                <button class="text-gray-400 hover:text-indigo-600">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex py-3 border-b border-gray-100 group">
                                        <div class="flex-shrink-0 relative">
                                            <img class="h-14 w-14 rounded-md object-cover border border-gray-200 group-hover:border-indigo-300 transition-colors" src="https://images.unsplash.com/photo-1596755094514-f87e34085b2c?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&h=100&q=80" alt="Product">
                                            <button class="absolute -top-2 -right-2 bg-white rounded-full p-0.5 shadow-sm border border-gray-200 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="flex justify-between">
                                                <p class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors">Kit Maquillaje Profesional</p>
                                                <p class="text-sm font-medium text-gray-900">$29.99</p>
                                            </div>
                                            <p class="text-xs text-gray-500">Maquillaje</p>
                                            <div class="mt-1 flex items-center">
                                                <button class="text-gray-400 hover:text-indigo-600">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>
                                                <span class="mx-2 text-xs font-medium">2</span>
                                                <button class="text-gray-400 hover:text-indigo-600">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="py-6 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Carrito vacío</h3>
                                        <p class="mt-1 text-sm text-gray-500">Agrega productos para comenzar</p>
                                        <div class="mt-4">
                                            <a href="{{ route('ecommerce.shop') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Explorar productos
                                                <svg class="ml-1 -mr-0.5 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if(Cart::count() > 0)
                            <div class="py-3 px-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-t border-gray-100 rounded-b-xl">
                                <div class="flex justify-between text-sm font-medium text-gray-900 mb-3">
                                    <p>Subtotal</p>
                                    <p>${{ number_format(Cart::total(), 2) }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('ecommerce.cart') }}" class="flex-1 text-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                        Ver carrito
                                    </a>
                                    <a href="{{ route('ecommerce.checkout') }}" class="flex-1 text-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:from-indigo-700 hover:to-purple-700 transition-all">
                                        Comprar
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Premium Mobile Search Bar -->
            <div x-show="searchOpen" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden pb-3">
                <form action="{{ route('ecommerce.shop') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Buscar productos..." 
                           class="block w-full pl-4 pr-10 py-2.5 border border-gray-200 rounded-full focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 shadow-sm bg-gray-50 focus:bg-white transition-all">
                    <button type="submit" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Premium Mobile Menu -->
    <div x-show="mobileMenuOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white shadow-2xl border-t border-gray-200 max-h-[80vh] overflow-y-auto">
        <div class="container mx-auto px-4 py-3">
            <!-- Premium User Auth Section -->
            <div class="flex items-center space-x-4 py-3 border-b border-gray-100">
                @auth
                <div class="flex-shrink-0 relative">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-700 font-medium shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="absolute bottom-0 right-0 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-600 border border-white"></span>
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <div class="flex items-center mt-1">
                        <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded-full">Nivel Oro</span>
                        <a href="{{ route('ecommerce.account.dashboard') }}" class="ml-2 text-xs text-indigo-600 hover:text-indigo-500">Mi cuenta</a>
                    </div>
                </div>
                @else
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 text-gray-500 shadow-sm">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <a href="{{ route('ecommerce.login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Iniciar sesión</a>
                    <p class="text-xs text-gray-500">o <a href="{{ route('ecommerce.register') }}" class="text-indigo-600 hover:text-indigo-500">Registrarse</a></p>
                </div>
                @endauth
            </div>
            
            <!-- Premium Mobile Navigation -->
            <nav class="py-2 space-y-1">
                <a href="{{ route('ecommerce.home') }}" 
                   class="block px-3 py-3 rounded-lg text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-600 transition-colors flex items-center">
                    <svg class="h-5 w-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Inicio
                </a>
                
                @foreach($categories as $category)
                <div x-data="{ open: false }" class="border-b border-gray-100 last:border-b-0">
                    <button @click="open = !open" 
                            class="w-full flex justify-between items-center px-3 py-3 rounded-lg text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <div class="flex items-center">
                            <i class="fas fa-{{ $category->icon ?? 'tag' }} text-indigo-500 w-5 mr-3 text-center"></i>
                            {{ $category->name }}
                        </div>
                        @if($category->children->count())
                        <svg class="h-4 w-4 transform transition-transform text-gray-400" 
                             :class="{ 'rotate-180': open }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        @endif
                    </button>
                    
                    @if($category->children->count())
                    <div x-show="open" x-collapse
                         class="pl-4 space-y-1 my-1 ml-8 border-l-2 border-indigo-100">
                        @foreach($category->children as $child)
                        <a href="{{ route('ecommerce.shop.category', $child->slug) }}" 
                           class="block px-3 py-2 rounded-md text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-200 mr-3"></span>
                            {{ $child->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
                
                <a href="#" 
                   class="block px-3 py-3 rounded-lg text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-600 transition-colors flex items-center">
                    <svg class="h-5 w-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                    </svg>
                    Ofertas
                </a>
                <a href="#" 
                   class="block px-3 py-3 rounded-lg text-base font-medium text-gray-900 hover:bg-indigo-50 hover:text-indigo-600 transition-colors flex items-center">
                    <svg class="h-5 w-5 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contacto
                </a>
            </nav>
            
            <!-- Premium Social & Additional Links -->
            <div class="pt-4 pb-2 border-t border-gray-200">
                <div class="px-3 mb-3">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Síguenos</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition-colors">
                            <span class="sr-only">TikTok</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                            </svg>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition-colors">
                            <span class="sr-only">YouTube</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="px-3">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Configuración</h3>
                    <div class="flex items-center justify-between text-sm">
                        <button class="flex items-center text-gray-700 hover:text-indigo-600">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                            Idioma
                        </button>
                        <button class="flex items-center text-gray-700 hover:text-indigo-600">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>
                            Moneda
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>