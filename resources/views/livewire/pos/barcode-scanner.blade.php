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