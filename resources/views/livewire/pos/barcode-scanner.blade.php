<!--
<div class="mb-4">
    <label class="block mb-2">Scan Barcode</label>
    <div class="flex">
        <input 
            type="text" 
            wire:model="barcode" 
            wire:keydown.enter="scanBarcode"
            placeholder="Scan or enter barcode"
            class="flex-1 border rounded-l p-2"
            autofocus
        >
        <button 
            wire:click="scanBarcode"
            class="bg-blue-600 text-white px-4 rounded-r"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
        </button>
    </div>
</div>
-->

<div class="relative flex items-center">
<input 
        type="text" 
        wire:model.live="barcode"
        placeholder="Scan barcode..."
        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
        autofocus
    >
    <div class="absolute left-3 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
        </svg>
    </div>
</div>