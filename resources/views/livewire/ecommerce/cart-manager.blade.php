<div class="cart-container bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Your Cart</h2>
    
    @if(count($cart) > 0)
        <div class="space-y-4">
            @foreach($cart as $item)
            <div class="flex items-center border-b pb-4">
                <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80' }}" class="w-20 h-20 object-cover mr-4">
                <div class="flex-1">
                    <h3 class="font-medium">{{ $item['name'] }}</h3>
                    <p>${{ number_format($item['price'], 2) }} x {{ $item['quantity'] }}</p>
                </div>
                <span class="font-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
            </div>
            @endforeach
        </div>

        <div class="mt-6 space-y-2">
            <div class="flex justify-between">
                <span>Subtotal:</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Shipping:</span>
                <span>${{ number_format($shipping, 2) }}</span>
            </div>
            <div class="flex justify-between font-bold text-lg">
                <span>Total:</span>
                <span>${{ number_format($subtotal + $shipping, 2) }}</span>
            </div>
        </div>
    @else
        <p class="text-gray-500">Your cart is empty</p>
    @endif
</div>