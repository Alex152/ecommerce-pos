<div class="pos-container">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Product List -->
        <div class="md:col-span-2 bg-white p-4 rounded shadow">
            <h2 class="text-xl font-bold mb-4">Products</h2>
            <livewire:pos.barcode-scanner />
            @if($errorMessage)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errorMessage }}
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($products as $product)
                <div class="product-card" wire:click="addToCart({{ $product->id }})">
                    <div class="product-barcode">{{ $product->barcode }}</div>
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Cart -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-bold mb-4">Current Sale</h2>
            <div class="mb-4 relative" x-data="{ open: false }">
                <label class="block mb-2">Customer</label>
                <input 
                    type="text" 
                    wire:model.live="customerSearch" 
                    @keyup="open = $event.target.value.length > 0"
                    @focus="$event.target.value.length > 0 ? open = true : open = false"
                    @click.away="open = false"
                    placeholder="Search customer..."
                    class="w-full border rounded p-2"
                >
                
                <div x-show="open" class="absolute z-10 w-full mt-1 bg-white border rounded shadow-lg max-h-60 overflow-auto">
                    <ul>
                        @if($customerSearch)
                            @foreach($filteredCustomers as $customer)
                                <li 
                                    wire:click="selectCustomer({{ $customer->id }})"
                                    @click="open = false"
                                    class="p-2 hover:bg-gray-100 cursor-pointer"
                                >
                                    {{ $customer->name }}
                                </li>
                            @endforeach
                            
                            @if($filteredCustomers->isEmpty())
                                <li class="p-2 text-gray-500">No customers found</li>
                            @endif
                        @endif
                    </ul>
                </div>
                
                <!-- Mostrar el cliente seleccionado -->
                @if($selectedCustomerName)
                    <div class="mt-2 p-2 bg-gray-100 rounded">
                        Selected: {{ $selectedCustomerName }}
                    </div>
                @endif
            </div>


            <div class="cart-items mb-4">
                @foreach($cart as $index => $item)
                <div class="cart-item flex justify-between items-center mb-2 pb-2 border-b">
                    <div>
                        <div>{{ $item['name'] }}</div>
                        <div class="text-sm text-gray-500">${{ number_format($item['price'], 2) }} x {{ $item['quantity'] }}</div>
                    </div>
                    <div class="flex items-center">
                        <span class="mr-2">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        <button wire:click="removeFromCart({{ $index }})" class="text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="totals mb-4">
                <div class="flex justify-between mb-2">
                    <span>Subtotal:</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Tax (10%):</span>
                    <span>${{ number_format($tax, 2) }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total:</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>

            <div class="payment-methods mb-4">
                <label class="block mb-2">Payment Method</label>
                <select wire:model="payment_method" class="w-full border rounded p-2">
                    <option value="cash">Cash</option>
                    <option value="card">Credit Card</option>
                    <option value="transfer">Bank Transfer</option>
                </select>
            </div>

            @if($payment_method === 'cash')
            <div class="cash-received mb-4">
                <label class="block mb-2">Cash Received</label>
                <input type="number" wire:model="cash_received" class="w-full border rounded p-2">
                <div class="mt-2">Change: ${{ number_format($change, 2) }}</div>
            </div>
            @endif

            <button 
                wire:click="completeSale" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700"
                {{ empty($cart) ? 'disabled' : '' }}
            >
                Complete Sale
            </button>
        </div>
    </div>
</div>
<!--Script para alerta del navegador Pero ya esta con alerta interna
<script>
document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('show-alert', data => {
        alert(data.message); // Puede ser reemplazarlo con una librería de notificaciones como SweetAlert
    });
});
</script>
-->

@push('styles')
<style>
    .product-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .product-card:hover {
        background-color: #f7fafc;
        transform: translateY(-2px);
    }
    .product-barcode {
        font-size: 0.75rem;
        color: #718096;
    }
    .product-name {
        font-weight: 600;
        margin: 0.5rem 0;
    }
    .product-price {
        color: #2d3748;
        font-weight: 700;
    }
</style>
@endpush