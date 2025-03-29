<div class="space-y-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4">Active Sessions</h3>
        
        @foreach($sessions as $session)
            <div class="flex items-center justify-between py-2 border-b">
                <div>
                    <p class="font-medium">{{ $session->device }} ({{ $session->platform }})</p>
                    <p class="text-sm text-gray-500">{{ $session->ip_address }} · {{ $session->last_active }}</p>
                </div>
                @if($session->is_current_device)
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Current</span>
                @endif
            </div>
        @endforeach

        <button 
            wire:click="confirmPassword"
            class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
        >
            Logout Other Devices
        </button>
    </div>
</div>