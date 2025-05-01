<div>
    <div class="bg-white py-6 border-b">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Mis Direcciones</h1>
                <button @click="$wire.set('editingAddress', null)"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    <i class="fas fa-plus mr-2"></i> Nueva Dirección
                </button>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if($editingAddress !== null)
        <!-- Formulario de Dirección -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-medium mb-4">{{ $editingAddress ? 'Editar' : 'Agregar' }} Dirección</h3>
            
            <form wire:submit.prevent="saveAddress">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input type="text" id="first_name" wire:model="form.first_name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('form.first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                        <input type="text" id="last_name" wire:model="form.last_name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('form.last_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="address_1" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" id="address_1" wire:model="form.address_1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('form.address_1') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="address_2" class="block text-sm font-medium text-gray-700 mb-1">Dirección 2 (Opcional)</label>
                        <input type="text" id="address_2" wire:model="form.address_2"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                        <input type="text" id="city" wire:model="form.city"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('form.city') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Estado/Provincia</label>
                        <input type="text" id="state" wire:model="form.state"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('form.state') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                        <input type="text" id="zip_code" wire:model="form.zip_code"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('form.zip_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">País</label>
                        <select id="country" wire:model="form.country"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="US">Estados Unidos</option>
                            <option value="MX">México</option>
                            <option value="ES">España</option>
                            <!-- Agrega más países según necesites -->
                        </select>
                        @error('form.country') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" id="phone" wire:model="form.phone"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        @error('form.phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex items-center md:col-span-2">
                        <input type="checkbox" id="is_default" wire:model="form.is_default"
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_default" class="ml-2 block text-sm text-gray-900">
                            Establecer como dirección principal
                        </label>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" @click="$wire.set('editingAddress', null)"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Guardar Dirección
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Lista de Direcciones -->
        @if($addresses->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($addresses as $address)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border {{ $address->is_default ? 'border-indigo-500' : 'border-gray-200' }}">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <h3 class="font-medium text-gray-900">
                            {{ $address->first_name }} {{ $address->last_name }}
                            @if($address->is_default)
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                Principal
                            </span>
                            @endif
                        </h3>
                        <div class="flex space-x-2">
                            <button wire:click="editAddress({{ $address->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="deleteAddress({{ $address->id }})"
                                    class="text-red-600 hover:text-red-900 transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-sm text-gray-600 space-y-1">
                        <p>{{ $address->address_1 }}</p>
                        @if($address->address_2)
                        <p>{{ $address->address_2 }}</p>
                        @endif
                        <p>{{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}</p>
                        <p>{{ $address->country }}</p>
                        <p class="mt-2">Tel: {{ $address->phone }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-lg shadow-sm">
            <i class="fas fa-map-marker-alt text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes direcciones guardadas</h3>
            <p class="text-gray-600 mb-6">Agrega una dirección para facilitar tus compras</p>
            <button @click="$wire.set('editingAddress', 'new')"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                <i class="fas fa-plus mr-2"></i> Agregar Dirección
            </button>
        </div>
        @endif
    </div>
</div>