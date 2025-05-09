<div x-data="cartComponent()" 

{{-- Toda esta logica se paso a un script para evitar conflicto 
Ya que se esta  usando Blade (@json) dentro de JavaScript, lo cual funciona, pero sólo si el contenido resultante es válido como JSON. En este caso, si alguna de estas variables:

@json($cartItems), @json($subtotal), @json($total)
no retorna un valor correctamente formateado, por ejemplo:

- $cartItems es null y se transforma en undefined (no válido en este contexto)

- Hay comillas no escapadas o propiedades que causan errores de sintaxis

Entonces el código JS completo dentro de x-data deja de interpretarse correctamente, y lo que ves en la pantalla es literalmente ese bloque de texto como si fuera contenido plano.

Alternativa más segura: pasa los datos desde Livewire como propiedades (usando @entangle o Alpine con x-init), o define Alpine fuera del HTML como una función para mantener el código más limpio y evitable de errores

    x-data="{
    loaded: false,
    cartItems: [],
    subtotal: 0,
    total: 0,
    couponCode: '',
    discount: 0,
    isLoading: false,
    showCouponForm: false,
    
    init() {
        this.fetchCartData();
        
        // Escuchar eventos de actualización
        this.$wire.on('cartUpdated', () => {
            this.fetchCartData();
        });
    },
    
    fetchCartData() {
        this.isLoading = true;
        // Simular carga de datos
        setTimeout(() => {
            this.cartItems = @json($cartItems);
            this.subtotal = @json($subtotal);
            this.total = @json($total);
            this.loaded = true;
            this.isLoading = false;
        }, 600);
    },
    
    applyCoupon() {
        if (this.couponCode.trim() === '') return;
        
        this.isLoading = true;
        // Simular validación de cupón
        setTimeout(() => {
            this.discount = 15; // 15% de descuento de ejemplo
            this.total = this.subtotal * (1 - this.discount/100);
            this.isLoading = false;
        }, 800);
    },
    
    removeDiscount() {
        this.discount = 0;
        this.total = this.subtotal;
        this.couponCode = '';
    }
}"--}}
class="min-h-screen bg-gray-50">
    <!-- Hero Section con animación -->
    <div x-show="loaded" 
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-gradient-to-r from-indigo-900 via-purple-800 to-pink-700 py-16 md:py-20 lg:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Tu Experiencia de Compra</h1>
                <p class="mt-4 text-xl text-indigo-100">Revisa y personaliza tu selección antes de finalizar</p>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <!-- Estado de carga -->
        <template x-if="!loaded && isLoading">
            <div class="space-y-6 animate-pulse">
                <div class="bg-white rounded-xl shadow-sm h-32"></div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-8 space-y-6">
                        <div class="bg-white rounded-xl shadow-sm h-48"></div>
                        <div class="bg-white rounded-xl shadow-sm h-48"></div>
                    </div>
                    <div class="lg:col-span-4">
                        <div class="bg-white rounded-xl shadow-sm h-64"></div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Carrito vacío -->
        <template x-if="loaded && cartItems.length === 0">
            <div x-show="loaded"
                 x-transition:enter="transition ease-out duration-500 delay-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="max-w-md mx-auto text-center bg-white rounded-xl shadow-lg p-12">
                <div class="mx-auto h-24 w-24 text-indigo-100 mb-6">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Tu carrito está esperando</h3>
                <p class="text-gray-600 mb-8">Descubre nuestros productos exclusivos y comienza a llenarlo</p>
                <a href="{{ route('ecommerce.shop') }}"
                   class="inline-flex items-center px-8 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 font-medium transition-all transform hover:-translate-y-0.5 hover:shadow-lg">
                    Explorar colección
                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </template>

        <!-- Carrito con productos -->
        <template x-if="loaded && cartItems.length > 0">
            <div x-show="loaded"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Lista de Productos -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Encabezado -->
                    <div class="hidden md:grid grid-cols-12 gap-6 bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 rounded-xl shadow-sm">
                        <div class="col-span-6 font-medium text-indigo-800">Producto</div>
                        <div class="col-span-2 font-medium text-indigo-800 text-center">Precio</div>
                        <div class="col-span-2 font-medium text-indigo-800 text-center">Cantidad</div>
                        <div class="col-span-2 font-medium text-indigo-800 text-right">Total</div>
                    </div>
                    
                    <!-- Items del Carrito -->
                    <div class="space-y-4">
                        <template x-for="(item, index) in cartItems" :key="item.id">
                            <div :style="`transition-delay: ${index * 50}ms`"
                                 :class="{
                                    'opacity-0 translate-x-5': !loaded,
                                    'opacity-100 translate-x-0': loaded
                                 }"
                                 class="transition-all duration-500 ease-out bg-white rounded-xl shadow-sm overflow-hidden group hover:shadow-md">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 p-6">
                                    <!-- Imagen y Nombre -->
                                    <div class="md:col-span-6 flex items-center space-x-4">
                                        <div class="flex-shrink-0 relative">
                                            <div class="w-20 h-20 md:w-24 md:h-24 rounded-lg overflow-hidden border border-gray-200 relative">
                                                <img :src="item.associatedModel.media[0].original_url" 
                                                     :alt="item.name"
                                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/10"></div>
                                            </div>
                                            <button @click="$wire.removeItem(item.id)"
                                                    class="absolute -top-2 -right-2 bg-white rounded-full p-1 shadow-md border border-gray-200 text-gray-400 hover:text-red-500 hover:border-red-200 transition-all opacity-0 group-hover:opacity-100">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900 hover:text-indigo-600 transition-colors">
                                                <a :href="`/producto/${item.associatedModel.slug}`" x-text="item.name"></a>
                                            </h3>
                                            <template x-if="item.attributes.variant">
                                                <p class="text-sm text-gray-500 mt-1" x-text="item.attributes.variant"></p>
                                            </template>
                                            <p class="md:hidden text-sm font-medium text-indigo-600 mt-1" x-text="`$${item.price.toFixed(2)}`"></p>
                                        </div>
                                    </div>
                                    
                                    <!-- Precio (Desktop) -->
                                    <div class="md:col-span-2 hidden md:flex items-center justify-center">
                                        <span class="font-medium" x-text="`$${item.price.toFixed(2)}`"></span>
                                    </div>
                                    
                                    <!-- Cantidad -->
                                    <div class="md:col-span-2 flex items-center justify-center">
                                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                            <button @click="$wire.updateQuantity(item.id, item.quantity - 1)"
                                                    :disabled="item.quantity <= 1"
                                                    class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-indigo-600 transition disabled:opacity-50">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <span class="px-4 py-2 text-center w-12" x-text="item.quantity"></span>
                                            <button @click="$wire.updateQuantity(item.id, item.quantity + 1)"
                                                    class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-indigo-600 transition">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Total y Eliminar -->
                                    <div class="md:col-span-2 flex items-center justify-end space-x-4">
                                        <span class="font-medium text-gray-900" x-text="`$${(item.price * item.quantity).toFixed(2)}`"></span>
                                        <button @click="$wire.removeItem(item.id)"
                                                class="md:hidden text-gray-400 hover:text-red-500 transition">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Cupón de Descuento -->
                    <div :class="{
                        'opacity-0 translate-y-5': !loaded,
                        'opacity-100 translate-y-0': loaded
                    }"
                    class="transition-all duration-500 delay-300 ease-out bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6 md:p-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center cursor-pointer"
                                @click="showCouponForm = !showCouponForm">
                                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                </svg>
                                ¿Tienes un código de descuento?
                                <svg class="ml-auto h-5 w-5 text-gray-400 transform transition-transform"
                                     :class="{ 'rotate-180': showCouponForm }">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </h3>
                            
                            <div x-show="showCouponForm" x-collapse class="mt-4">
                                <div class="flex">
                                    <input type="text" 
                                           x-model="couponCode"
                                           placeholder="Ingresa tu código"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <button @click="applyCoupon()"
                                            :disabled="isLoading || couponCode.trim() === ''"
                                            class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-r-lg transition-all transform hover:-translate-y-0.5 hover:shadow-lg disabled:opacity-75">
                                        <span x-show="!isLoading">Aplicar</span>
                                        <span x-show="isLoading">Aplicando...</span>
                                    </button>
                                </div>
                                
                                <template x-if="discount > 0">
                                    <div class="mt-4 p-3 bg-green-50 rounded-lg flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-green-800" x-text="`Descuento del ${discount}% aplicado`"></span>
                                        </div>
                                        <button @click="removeDiscount()" class="text-green-600 hover:text-green-800">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Continuar Comprando -->
                    <div :class="{
                        'opacity-0': !loaded,
                        'opacity-100': loaded
                    }"
                    class="transition-opacity duration-500 delay-500 pt-4">
                        <a href="{{ route('ecommerce.shop') }}"
                           class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                            </svg>
                            Continuar comprando
                        </a>
                    </div>
                </div>
                
                <!-- Resumen del Pedido -->
                <div class="lg:col-span-4"
                     :class="{
                        'opacity-0 scale-95': !loaded,
                        'opacity-100 scale-100': loaded
                     }"
                     x-transition:enter.delay.300ms>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-6">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900">Resumen del Pedido</h3>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium" x-text="`$${subtotal.toFixed(2)}`"></span>
                            </div>
                            
                            <template x-if="discount > 0">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Descuento</span>
                                    <span class="font-medium text-green-600" x-text="`-$${(subtotal * discount/100).toFixed(2)}`"></span>
                                </div>
                            </template>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Env&iacute;o</span>
                                <span class="text-indigo-600">Calculado al finalizar</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4"></div>
                            
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span x-text="`$${total.toFixed(2)}`"></span>
                            </div>
                            
                            <div class="pt-4">
                                <a href="{{ route('ecommerce.checkout') }}"
                                   class="block w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-center py-4 px-6 rounded-lg font-bold transition-all transform hover:-translate-y-0.5 hover:shadow-lg">
                                    Proceder al pago
                                </a>
                            </div>
                            
                            <div class="text-center pt-2">
                                <p class="text-sm text-gray-500">o paga con</p>
                                <div class="flex justify-center space-x-4 mt-3">
                                    <button class="p-2 rounded-lg border border-gray-200 hover:border-gray-300 transition">
                                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/paypal/paypal-original.svg" class="h-6" alt="PayPal">
                                    </button>
                                    <button class="p-2 rounded-lg border border-gray-200 hover:border-gray-300 transition">
                                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apple/apple-original.svg" class="h-6" alt="Apple Pay">
                                    </button>
                                    <button class="p-2 rounded-lg border border-gray-200 hover:border-gray-300 transition">
                                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" class="h-6" alt="Google Pay">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
@if(!empty($cartItems) && count($cartItems) > 0)
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        // Smooth scroll al cargar la página con items
        if (@json(count($cartItems) > 0)) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    });
</script>
@endpush
@endif
@push('scripts')
<script>
    function cartComponent() {
        return {
            loaded: false,
            cartItems: @json($cartItems),
            subtotal: @json($subtotal),
            total: @json($total),
            couponCode: '',
            discount: 0,
            isLoading: false,
            showCouponForm: false,

            init() {
                this.loaded = true;
                this.$wire.on('cartUpdated', () => this.fetchCartData());
            },

            fetchCartData() {
                this.isLoading = true;
                setTimeout(() => {
                    this.cartItems = @json($cartItems);
                    this.subtotal = @json($subtotal);
                    this.total = @json($total);
                    this.isLoading = false;
                }, 600);
            },

            applyCoupon() {
                if (this.couponCode.trim() === '') return;
                this.isLoading = true;
                setTimeout(() => {
                    this.discount = 15;
                    this.total = this.subtotal * (1 - this.discount / 100);
                    this.isLoading = false;
                }, 800);
            },

            removeDiscount() {
                this.discount = 0;
                this.total = this.subtotal;
                this.couponCode = '';
            }
        }
    }
</script>
@endpush