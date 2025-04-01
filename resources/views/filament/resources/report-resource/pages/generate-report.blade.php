<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="generateReport">
        {{ $this->form }}
        
        <div class="flex justify-end gap-4 mt-4">
            <x-filament::button type="submit" color="primary">
                Generate Report
            </x-filament::button>
        </div>
    </x-filament-panels::form>

</x-filament-panels::page>