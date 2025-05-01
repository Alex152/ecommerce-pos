<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tienda Online' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .animate-fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-900" x-data="{ mobileMenuOpen: false, cartOpen: false }">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('ecommerce.home') }}" class="text-2xl font-bold text-indigo-600">
                    <span class="text-indigo-800">Shop</span>Name
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    @foreach($categories as $category)
                        <x-ecommerce.dropdown-category :category="$category" />
                    @endforeach
                </nav>

                <!-- Icons -->
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-600 hover:text-indigo-600 transition">
                        <i class="fas fa-search"></i>
                    </button>
                    <button 
                        @click="cartOpen = true" 
                        class="p-2 text-gray-600 hover:text-indigo-600 transition relative"
                    >
                        <i class="fas fa-shopping-cart"></i>
                        @if($cartItemsCount > 0)
                            <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $cartItemsCount }}
                            </span>
                        @endif
                    </button>
                    <button class="md:hidden p-2" @click="mobileMenuOpen = !mobileMenuOpen">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-white border-t"
        >
            <div class="container mx-auto px-4 py-3">
                @foreach($categories as $category)
                    <x-ecommerce.mobile-category-item :category="$category" />
                @endforeach
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <!-- Footer content -->
        </div>
    </footer>

    <!-- Cart Sidebar -->
    <livewire:ecommerce.cart.mini-cart />

    <!-- Login Modal -->
    <livewire:ecommerce.auth.login-modal />

    <!-- Scripts -->
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
</body>
</html>