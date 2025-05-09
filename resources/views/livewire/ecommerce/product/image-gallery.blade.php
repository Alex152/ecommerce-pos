<div class="image-gallery">
    <div 
        class="main-image relative overflow-hidden cursor-zoom-in"
        wire:click="toggleZoom"
        @mousemove="window.livewire.emit('{{ $this->getId() }}.updateZoomPosition', {
            container: { width: $event.currentTarget.clientWidth, height: $event.currentTarget.clientHeight },
            image: { width: $event.target.naturalWidth, height: $event.target.naturalHeight },
            x: $event.offsetX, y: $event.offsetY
        })"
    >
        <img 
            src="{{ $this->galleryImages[$activeImageIndex]['url'] }}" 
            alt="{{ $this->galleryImages[$activeImageIndex]['alt'] }}"
            class="w-full h-auto transition-all duration-300"
            style="
                @if($zoomEnabled)
                    transform: scale({{ $zoomScale }});
                    transform-origin: {{ $zoomPosition['x'] }}% {{ $zoomPosition['y'] }}%;
                @endif
            "
        />
    </div>

    <div class="thumbnails flex gap-2 mt-4">
        @foreach ($this->galleryImages as $index => $image)
            <button 
                wire:click="setActiveImage({{ $index }})" 
                class="border {{ $activeImageIndex === $index ? 'border-blue-500' : 'border-gray-300' }} p-1 rounded"
            >
                <img 
                    src="{{ $image['thumb'] }}" 
                    alt="{{ $image['alt'] }}" 
                    class="w-16 h-16 object-cover"
                />
            </button>
        @endforeach
    </div>
</div>
