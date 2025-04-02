<div>
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Gestión de Stock</h2>
        
        <form wire:submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Producto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Producto</label>
                    <select wire:model="productId" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccionar Producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                        @endforeach
                    </select>
                    @error('productId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <!-- Almacén -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Almacén</label>
                    <select wire:model="warehouseId" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Seleccionar Almacén</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                    @error('warehouseId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <!-- Stock Actual -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock Actual</label>
                    <input type="text" value="{{ $currentStock }}" readonly class="w-full bg-gray-100 border-gray-300 rounded-md">
                </div>
                
                <!-- Tipo de Movimiento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Movimiento</label>
                    <select wire:model="movementType" class="w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($movementTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Cantidad -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                    <input type="number" wire:model="quantity" min="1" class="w-full border-gray-300 rounded-md shadow-sm">
                    @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <!-- Notas -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                <textarea wire:model="notes" rows="2" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Registrar Movimiento
            </button>
        </form>
    </div>
</div>