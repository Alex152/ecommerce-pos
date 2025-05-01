<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Checkout Steps -->
        <div class="max-w-4xl mx-auto mb-12">
            <nav class="flex items-center justify-center">
                <ol class="flex items-center space-x-8">
                    <!-- Step 1 -->
                    <li>
                        <div class="flex flex-col items-center">
                            <div 
                                class="flex items-center justify-center w-10 h-10 rounded-full transition"
                                :class="{ 
                                    'bg-indigo-600 text-white': currentStep >= 1, 
                                    'bg-gray-200 text-gray-600': currentStep < 1 
                                }"
                            >
                                <span>1</span>
                            </div>
                            <span 
                                class="mt-2 text-sm font-medium transition"
                                :class="{ 
                                    'text-indigo-600': currentStep >= 1, 
                                    'text-gray-500': currentStep < 1 
                                }"
                            >
                                Envío
                            </span>
                        </div>
                    </li>
                    
                    <!-- Step Connector -->
                    <li class="flex-1 h-0.5 bg-gray-200 mx-4" :class="{ 'bg-indigo-600': currentStep >= 2 }"></li>
                    
                    <!-- Step 2 -->
                    <li>
                        <div class="flex flex-col items-center">
                            <div 
                                class="flex items-center justify-center w-10 h-10 rounded-full transition"
                                :class="{ 
                                    'bg-indigo-600 text-white': currentStep >= 2, 
                                    'bg-gray-200 text-gray-600': currentStep < 2 
                                }"
                            >
                                <span>2</span>
                            </div>
                            <span 
                                class="mt-2 text-sm font-medium transition"
                                :class="{ 
                                    'text-indigo-600': currentStep >= 2, 
                                    'text-gray-500': currentStep < 2 
                                }"
                            >
                                Método
                            </span>
                        </div>
                    </li>
                    
                    <!-- Step Connector -->
                    <li class="flex-1 h-0.5 bg-gray-200 mx-4" :class="{ 'bg-indigo-600': currentStep >= 3 }"></li>
                    
                    <!-- Step 3 -->
                    <li>
                        <div class="flex flex-col items-center">
                            <div 
                                class="flex items-center justify-center w-10 h-10 rounded-full transition"
                                :class="{ 
                                    'bg-indigo-600 text-white': currentStep >= 3, 
                                    'bg-gray-200 text-gray-600': currentStep < 3 
                                }"
                            >
                                <span>3</span>
                            </div>
                            <span 
                                class="mt-2 text-sm font-medium transition"
                                :class="{ 
                                    'text-indigo-600': currentStep >= 3, 
                                    'text-gray-500': currentStep < 3 
                                }"
                            >
                                Pago
                            </span>
                        </div>
                    </li>
                    
                    <!-- Step Connector -->
                    <li class="flex-1 h-0.5 bg-gray-200 mx-4" :class="{ 'bg-indigo-600': currentStep >= 4 }"></li>
                    
                    <!-- Step 4 -->
                    <li>
                        <div class="flex flex-col items-center">
                            <div 
                                class="flex items-center justify-center w-10 h-10 rounded-full transition"
                                :class="{ 
                                    'bg-indigo-600 text-white': currentStep >= 4, 
                                    'bg-gray-200 text-gray-600': currentStep < 4 
                                }"
                            >
                                <span>4</span>
                            </div>
                            <span 
                                class="mt-2 text-sm font-medium transition"
                                :class="{ 
                                    'text-indigo-600': currentStep >= 4, 
                                    'text-gray-500': currentStep < 4 
                                }"
                            >
                                Revisión
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <!-- Step 1: Shipping Address -->
                <div x-show="currentStep === 1" x-transition>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Dirección de envío</h2>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <!-- Shipping Address Form -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="shipping_first_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                <input 
                                    type="text" 
                                    id="shipping_first_name" 
                                    wire:model="shippingAddress.first_name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shippingAddress.first_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                                <input 
                                    type="text" 
                                    id="shipping_last_name" 
                                    wire:model="shippingAddress.last_name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shippingAddress.last_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="shipping_address_1" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <input 
                                    type="text" 
                                    id="shipping_address_1" 
                                    wire:model="shippingAddress.address_1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shippingAddress.address_1') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                                <input 
                                    type="text" 
                                    id="shipping_city" 
                                    wire:model="shippingAddress.city"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shippingAddress.city') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">Estado/Provincia</label>
                                <input 
                                    type="text" 
                                    id="shipping_state" 
                                    wire:model="shippingAddress.state"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shippingAddress.state') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_zip_code" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                                <input 
                                    type="text" 
                                    id="shipping_zip_code" 
                                    wire:model="shippingAddress.zip_code"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shippingAddress.zip_code') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">País</label>
                                <select 
                                    id="shipping_country" 
                                    wire:model="shippingAddress.country"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                    <option value="">Seleccionar país</option>
                                    <option value="US">Estados Unidos</option>
                                    <option value="MX">México</option>
                                    <option value="ES">España</option>
                                    <!-- Más países -->
                                </select>
                                @error('shippingAddress.country') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                <input 
                                    type="text" 
                                    id="shipping_phone" 
                                    wire:model="shippingAddress.phone"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shippingAddress.phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Billing Address Toggle -->
                        <div class="mt-6">
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    id="billingSameAsShipping"
                                    wire:model="billingSameAsShipping"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                >
                                <label for="billingSameAsShipping" class="ml-2 block text-sm text-gray-900">
                                    Usar la misma dirección para facturación
                                </label>
                            </div>
                        </div>
                        
                        <!-- Billing Address Form -->
                        <div x-show="!billingSameAsShipping" x-transition class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Dirección de facturación</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="billing_first_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                    <input 
                                        type="text" 
                                        id="billing_first_name" 
                                        wire:model="billingAddress.first_name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                    @error('billingAddress.first_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                                    <input 
                                        type="text" 
                                        id="billing_last_name" 
                                        wire:model="billingAddress.last_name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                    @error('billingAddress.last_name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="billing_address_1" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                    <input 
                                        type="text" 
                                        id="billing_address_1" 
                                        wire:model="billingAddress.address_1"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                    @error('billingAddress.address_1') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                                    <input 
                                        type="text" 
                                        id="billing_city" 
                                        wire:model="billingAddress.city"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                    @error('billingAddress.city') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">Estado/Provincia</label>
                                    <input 
                                        type="text" 
                                        id="billing_state" 
                                        wire:model="billingAddress.state"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                    @error('billingAddress.state') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_zip_code" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                                    <input 
                                        type="text" 
                                        id="billing_zip_code" 
                                        wire:model="billingAddress.zip_code"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                    @error('billingAddress.zip_code') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1">País</label>
                                    <select 
                                        id="billing_country" 
                                        wire:model="billingAddress.country"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                    >
                                        <option value="">Seleccionar país</option>
                                        <option value="US">Estados Unidos</option>
                                        <option value="MX">México</option>
                                        <option value="ES">España</option>
                                    </select>
                                    @error('billingAddress.country') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button 
                            wire:click="nextStep"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition"
                        >
                            Continuar al método de envío
                        </button>
                    </div>
                </div>

                <!-- Step 2: Shipping Method -->
                <div x-show="currentStep === 2" x-transition>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Método de envío</h2>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="space-y-4">
                            <div 
                                class="border rounded-lg p-4 cursor-pointer transition"
                                :class="{ 
                                    'border-indigo-500 bg-indigo-50': shippingMethod === 'standard', 
                                    'border-gray-300 hover:border-gray-400': shippingMethod !== 'standard' 
                                }"
                                @click="shippingMethod = 'standard'"
                            >
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-5 w-5 text-indigo-600">
                                        <input 
                                            type="radio" 
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            checked="{{ shippingMethod === 'standard' }}"
                                        >
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">Envío estándar</h3>
                                        <p class="text-gray-600">Entrega en 3-5 días hábiles</p>
                                    </div>
                                    <div class="ml-auto text-lg font-medium text-gray-900">
                                        $5.00
                                    </div>
                                </div>
                            </div>
                            
                            <div 
                                class="border rounded-lg p-4 cursor-pointer transition"
                                :class="{ 
                                    'border-indigo-500 bg-indigo-50': shippingMethod === 'express', 
                                    'border-gray-300 hover:border-gray-400': shippingMethod !== 'express' 
                                }"
                                @click="shippingMethod = 'express'"
                            >
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-5 w-5 text-indigo-600">
                                        <input 
                                            type="radio" 
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            checked="{{ shippingMethod === 'express' }}"
                                        >
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">Envío exprés</h3>
                                        <p class="text-gray-600">Entrega en 1-2 días hábiles</p>
                                    </div>
                                    <div class="ml-auto text-lg font-medium text-gray-900">
                                        $15.00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-between">
                        <button 
                            wire:click="prevStep"
                            class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 font-medium hover:bg-gray-50 transition"
                        >
                            Regresar
                        </button>
                        <button 
                            wire:click="nextStep"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition"
                        >
                            Continuar al pago
                        </button>
                    </div>
                </div>

                <!-- Step 3: Payment Method -->
                <div x-show="currentStep === 3" x-transition>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Método de pago</h2>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="space-y-6">
                            <!-- Credit Card -->
                            <div 
                                class="border rounded-lg p-4 cursor-pointer transition"
                                :class="{ 
                                    'border-indigo-500 bg-indigo-50': paymentMethod === 'credit_card', 
                                    'border-gray-300 hover:border-gray-400': paymentMethod !== 'credit_card' 
                                }"
                                @click="paymentMethod = 'credit_card'"
                            >
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-5 w-5 text-indigo-600">
                                        <input 
                                            type="radio" 
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            checked="{{ paymentMethod === 'credit_card' }}"
                                        >
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">Tarjeta de crédito/débito</h3>
                                    </div>
                                    <div class="ml-auto flex space-x-2">
                                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/visa/visa-original.svg" class="h-8" alt="Visa">
                                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mastercard/mastercard-original.svg" class="h-8" alt="Mastercard">
                                    </div>
                                </div>
                                
                                <!-- Credit Card Form -->
                                <div x-show="paymentMethod === 'credit_card'" x-transition class="mt-4 space-y-4">
                                    <div>
                                        <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Número de tarjeta</label>
                                        <input 
                                            type="text" 
                                            id="card_number" 
                                            wire:model="cardDetails.number"
                                            placeholder="4242 4242 4242 4242"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                        >
                                        @error('cardDetails.number') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre en la tarjeta</label>
                                        <input 
                                            type="text" 
                                            id="card_name" 
                                            wire:model="cardDetails.name"
                                            placeholder="John Doe"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                        >
                                        @error('cardDetails.name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-1">Expiración (MM/AA)</label>
                                            <input 
                                                type="text" 
                                                id="card_expiry" 
                                                wire:model="cardDetails.expiry"
                                                placeholder="12/24"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            >
                                            @error('cardDetails.expiry') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="card_cvc" class="block text-sm font-medium text-gray-700 mb-1">Código CVC</label>
                                            <input 
                                                type="text" 
                                                id="card_cvc" 
                                                wire:model="cardDetails.cvc"
                                                placeholder="123"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                            >
                                            @error('cardDetails.cvc') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- PayPal -->
                            <div 
                                class="border rounded-lg p-4 cursor-pointer transition"
                                :class="{ 
                                    'border-indigo-500 bg-indigo-50': paymentMethod === 'paypal', 
                                    'border-gray-300 hover:border-gray-400': paymentMethod !== 'paypal' 
                                }"
                                @click="paymentMethod = 'paypal'"
                            >
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-5 w-5 text-indigo-600">
                                        <input 
                                            type="radio" 
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            checked="{{ paymentMethod === 'paypal' }}"
                                        >
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">PayPal</h3>
                                        <p class="text-gray-600">Paga con tu cuenta PayPal</p>
                                    </div>
                                    <div class="ml-auto">
                                        <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/paypal/paypal-original.svg" class="h-8" alt="PayPal">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bank Transfer -->
                            <div 
                                class="border rounded-lg p-4 cursor-pointer transition"
                                :class="{ 
                                    'border-indigo-500 bg-indigo-50': paymentMethod === 'bank_transfer', 
                                    'border-gray-300 hover:border-gray-400': paymentMethod !== 'bank_transfer' 
                                }"
                                @click="paymentMethod = 'bank_transfer'"
                            >
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-5 w-5 text-indigo-600">
                                        <input 
                                            type="radio" 
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                            checked="{{ paymentMethod === 'bank_transfer' }}"
                                        >
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">Transferencia bancaria</h3>
                                        <p class="text-gray-600">Realiza el pago directamente a nuestra cuenta bancaria</p>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fas fa-university text-2xl text-gray-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-between">
                        <button 
                            wire:click="prevStep"
                            class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 font-medium hover:bg-gray-50 transition"
                        >
                            Regresar
                        </button>
                        <button 
                            wire:click="nextStep"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition"
                        >
                            Revisar pedido
                        </button>
                    </div>
                </div>

                <!-- Step 4: Review Order -->
                <div x-show="currentStep === 4" x-transition>
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Revisar pedido</h2>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dirección de envío</h3>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <p class="text-gray-900">{{ shippingAddress['first_name'] }} {{ shippingAddress['last_name'] }}</p>
                            <p class="text-gray-600">{{ shippingAddress['address_1'] }}</p>
                            <p class="text-gray-600">{{ shippingAddress['city'] }}, {{ shippingAddress['state'] }} {{ shippingAddress['zip_code'] }}</p>
                            <p class="text-gray-600">{{ shippingAddress['country'] }}</p>
                            <p class="text-gray-600">Tel: {{ shippingAddress['phone'] }}</p>
                        </div>
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Método de envío</h3>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <p class="text-gray-900">
                                {{ shippingMethod === 'standard' ? 'Envío estándar (3-5 días hábiles)' : 'Envío exprés (1-2 días hábiles)' }}
                            </p>
                            <p class="text-gray-900 font-medium">
                                ${{ number_format(getShippingCost(), 2) }}
                            </p>
                        </div>
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Método de pago</h3>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            @if($paymentMethod === 'credit_card')
                                <p class="text-gray-900">Tarjeta de crédito/débito</p>
                                <p class="text-gray-600">Terminada en {{ substr($cardDetails['number'], -4) }}</p>
                            @elseif($paymentMethod === 'paypal')
                                <p class="text-gray-900">PayPal</p>
                            @else
                                <p class="text-gray-900">Transferencia bancaria</p>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Resumen del pedido</h3>
                        <div class="border-t border-gray-200 pt-4">
                            @foreach(\Cart::getContent() as $item)
                                <div class="flex items-center py-4">
                                    <div class="flex-shrink-0 w-16 h-16 border border-gray-200 rounded-md overflow-hidden">
                                        <img 
                                            src="{{ $item->associatedModel->getFirstMediaUrl('default', 'thumb') }}" 
                                            alt="{{ $item->name }}"
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3>{{ $item->name }}</h3>
                                            <p>${{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                        <div class="flex justify-between text-sm text-gray-500">
                                            <p>Cantidad: {{ $item->quantity }}</p>
                                            <p>${{ number_format($item->price, 2) }} c/u</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="border-t border-gray-200 pt-4 space-y-4">
                                <div class="flex justify-between text-base text-gray-600">
                                    <p>Subtotal</p>
                                    <p>${{ number_format(\Cart::getSubTotal(), 2) }}</p>
                                </div>
                                <div class="flex justify-between text-base text-gray-600">
                                    <p>Envío</p>
                                    <p>${{ number_format(getShippingCost(), 2) }}</p>
                                </div>
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Total</p>
                                    <p>${{ number_format(\Cart::getTotal() + getShippingCost(), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-between">
                        <button 
                            wire:click="prevStep"
                            class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 font-medium hover:bg-gray-50 transition"
                        >
                            Regresar
                        </button>
                        <button 
                            wire:click="placeOrder"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-medium transition flex items-center"
                        >
                            <span>Completar pedido</span>
                            <i class="fas fa-lock ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Resumen del pedido</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">${{ number_format(\Cart::getSubTotal(), 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Envìo</span>
                            <span class="text-gray-900">
                                @if($currentStep >= 2)
                                    ${{ number_format(getShippingCost(), 2) }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4 flex justify-between">
                            <span class="text-base font-medium text-gray-900">Total</span>
                            <span class="text-base font-medium text-gray-900">
                                @if($currentStep >= 2)
                                    ${{ number_format(\Cart::getTotal() + getShippingCost(), 2) }}
                                @else
                                    ${{ number_format(\Cart::getTotal(), 2) }}
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Cart Items -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Productos ({{ \Cart::getContent()->count() }})</h3>
                        
                        <ul class="divide-y divide-gray-200">
                            @foreach(\Cart::getContent() as $item)
                                <li class="py-4 flex">
                                    <div class="flex-shrink-0 w-16 h-16 border border-gray-200 rounded-md overflow-hidden">
                                        <img 
                                            src="{{ $item->associatedModel->getFirstMediaUrl('default', 'thumb') }}" 
                                            alt="{{ $item->name }}"
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3>{{ $item->name }}</h3>
                                            <p>${{ number_format($item->price, 2) }}</p>
                                        </div>
                                        <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>