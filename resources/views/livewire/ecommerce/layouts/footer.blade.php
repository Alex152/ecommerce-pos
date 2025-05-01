<footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Logo y Descripción -->
            <div>
                <a href="{{ route('ecommerce.home') }}" class="text-2xl font-bold text-white mb-4 inline-block">
                    <span class="text-indigo-400">Shop</span>Name
                </a>
                <p class="mb-6">La mejor selección de productos con envío rápido a todo el país.</p>
                
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-pinterest-p text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Categorías -->
            <div>
                <h3 class="text-white font-medium text-lg mb-4">Categorías</h3>
                <ul class="space-y-2">
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('ecommerce.shop.category', $category->slug) }}" class="hover:text-white transition">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Empresa -->
            <div>
                <h3 class="text-white font-medium text-lg mb-4">Empresa</h3>
                <ul class="space-y-2">
                    @foreach($links['company'] as $link)
                    <li>
                        <a href="{{ $link['route'] }}" class="hover:text-white transition">
                            {{ $link['name'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="text-white font-medium text-lg mb-4">Legal</h3>
                <ul class="space-y-2">
                    @foreach($links['legal'] as $link)
                    <li>
                        <a href="{{ $link['route'] }}" class="hover:text-white transition">
                            {{ $link['name'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-400 mb-4 md:mb-0">
                &copy; {{ date('Y') }} ShopName. Todos los derechos reservados.
            </p>
            
            <div class="flex space-x-6">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/visa/visa-original.svg" class="h-8 opacity-70 hover:opacity-100 transition" alt="Visa">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mastercard/mastercard-original.svg" class="h-8 opacity-70 hover:opacity-100 transition" alt="Mastercard">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/paypal/paypal-original.svg" class="h-8 opacity-70 hover:opacity-100 transition" alt="PayPal">
            </div>
        </div>
    </div>
</footer>