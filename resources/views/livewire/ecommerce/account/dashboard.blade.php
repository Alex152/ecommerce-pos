<div>
    <div class="bg-white py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold">Bienvenido, {{ auth()->user()->name }}</h1>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Resumen de Pedidos -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium">Mis Pedidos</h3>
                    <a href="{{ route('ecommerce.account.orders') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Ver todos</a>
                </div>
                @if($recentOrders->count())
                    <ul class="space-y-4">
                        @foreach($recentOrders as $order)
                        <li class="border-b pb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">Pedido #{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No tienes pedidos recientes</p>
                @endif
            </div>

            <!-- Lista de Deseos -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium">Lista de Deseos</h3>
                    <a href="{{ route('ecommerce.account.wishlist') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Ver todos</a>
                </div>
                @if($wishlistCount > 0)
                    <p class="text-gray-900 font-medium">{{ $wishlistCount }} productos</p>
                    <p class="text-sm text-gray-500">En tu lista de deseos</p>
                @else
                    <p class="text-gray-500">No tienes productos en tu lista de deseos</p>
                @endif
            </div>

            <!-- Direcciones -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium">Mis Direcciones</h3>
                    <a href="{{ route('ecommerce.account.addresses') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Administrar</a>
                </div>
                <p class="text-gray-500">Administra tus direcciones de envío</p>
            </div>
        </div>

        <!-- Información de la cuenta -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium mb-4">Información de la Cuenta</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Nombre completo</p>
                    <p class="font-medium">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Correo electrónico</p>
                    <p class="font-medium">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Teléfono</p>
                    <p class="font-medium">{{ auth()->user()->phone ?? 'No especificado' }}</p>
                </div>
                <div class="flex items-end">
                    <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Editar información
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>