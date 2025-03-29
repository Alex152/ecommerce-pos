<div class="relative">
    <input 
        type="text" 
        wire:model.live.debounce.300ms="query"
        placeholder="Search customer..."
        class="w-full px-4 py-2 border rounded-lg"
    >
    
    @if(!empty($customers))
        <ul class="absolute z-10 w-full mt-1 bg-white border rounded-lg shadow-lg">
            @foreach($customers as $customer)
                <li 
                    wire:click="selectCustomer({{ $customer['id'] }})"
                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                >
                    {{ $customer['name'] }} ({{ $customer['dni'] ?? 'No ID' }})
                </li>
            @endforeach
        </ul>
    @endif
</div>