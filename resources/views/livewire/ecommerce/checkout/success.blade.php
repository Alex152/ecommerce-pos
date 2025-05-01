<div class="bg-gray-50 py-16">
    <div class="max-w-3xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm p-8">
            <div class="flex justify-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
            </div>
            
            <h1 class="mt-6 text-3xl font-bold text-gray-900">¡Pedido completado con éxito!</h1>
            <p class="mt-4 text-lg text-gray-600">
                Gracias por tu compra. Hemos enviado un correo electrónico con los detalles de tu pedido.
            </p>
            
            <div class="mt-8 bg-gray-50 rounded-lg p-6 text-left">
                <div class="flex flex-col sm:flex-row justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h3 class="text-sm font-medium text-gray-500">Número de pedido</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $order->number }}</p>
                    </div>
                    <div class="mb-4 sm:mb-0">
                        <h3 class="text-sm font-medium text-gray-500">Fecha</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Total</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">${{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 border-t border-gray-200 pt-10">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Resumen del pedido</h2>
                
                <div class="space-y-8">
                    @foreach($order->items as $item)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-20 h-20 border border-gray-200 rounded-md overflow-hidden">
                                <img 
                                    src="{{ $item->product->getFirstMediaUrl('default', 'thumb') }}" 
                                    alt="{{ $item->product->name }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <h3>{{ $item->product->name }}</h3>
                                    <p>${{ number_format($item->unit_price, 2) }}</p>
                                </div>
                                <div class="flex justify-between text-sm text-gray-500">
                                    <p>Cantidad: {{ $item->quantity }}</p>
                                    <p>Total: ${{ number_format($item->total, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 border-t border-gray-200 pt-8">
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>Subtotal</p>
                        <p>${{ number_format($order->subtotal, 2) }}</p>
                    </div>
                    <div class="flex justify-between text-base font-medium text-gray-900 mt-2">
                        <p>Envío</p>
                        <p>${{ number_format($order->shipping, 2) }}</p>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-gray-900 mt-4 pt-4 border-t border-gray-200">
                        <p>Total</p>
                        <p>${{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                <a 
                    href="{{ route('ecommerce.shop') }}" 
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Continuar comprando
                </a>
                <a 
                    href="{{ route('ecommerce.account.orders') }}" 
                    class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Ver mis pedidos
                </a>
            </div>
        </div>
    </div>
</div>