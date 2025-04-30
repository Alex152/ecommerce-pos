<div
    x-data="{ show: @entangle('show') }"
    x-show="show"
    x-transition
    x-init="$watch('show', value => { if (!value) $wire.resetNotification() })"
    @click.away="show = false"
    class="fixed top-4 right-4 z-50 max-w-xs w-full bg-white rounded-lg shadow-lg overflow-hidden border
        {{ $type === 'error' ? 'border-red-200' : ($type === 'success' ? 'border-green-200' : 'border-blue-200') }}"
    style="display: none;"
>
    <div class="p-4 flex items-start">
        <div class="flex-shrink-0">
            @if ($type === 'success')
                <x-heroicon-s-check-circle class="h-6 w-6 text-green-500" />
            @elseif ($type === 'error')
                <x-heroicon-s-x-circle class="h-6 w-6 text-red-500" />
            @elseif ($type === 'warning')
                <x-heroicon-s-exclamation-circle class="h-6 w-6 text-yellow-500" />
            @else
                <x-heroicon-s-information-circle class="h-6 w-6 text-blue-500" />
            @endif
        </div>
        <div class="ml-3 w-0 flex-1 pt-0.5">
            <p class="text-sm font-medium text-gray-900">{{ $message }}</p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
            <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none">
                <x-heroicon-s-x-mark class="h-5 w-5" />
            </button>
        </div>
    </div>
</div>

{{-- Auto-ocultar después de 5 segundos --}}
<script>
    window.addEventListener('start-notification-timer', () => {
        setTimeout(() => {
            Livewire.dispatch('resetNotification');
        }, 5000); // Tiempo en milisegundos
    });
</script>
