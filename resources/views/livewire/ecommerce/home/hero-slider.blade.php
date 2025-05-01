<div 
    x-data="{
        init() {
            // GSAP Animations
            gsap.from('.hero-title', { 
                duration: 1, 
                y: 50, 
                opacity: 0, 
                ease: 'power3.out',
                stagger: 0.2
            });
            
            // Auto slide
            setInterval(() => {
                @this.nextSlide();
            }, 5000);
        }
    }"
    class="relative h-[500px] md:h-[600px] overflow-hidden"
>
    @foreach($slides as $index => $slide)
        <div 
            class="absolute inset-0 transition-opacity duration-1000 ease-in-out bg-cover bg-center"
            :class="{ 
                'opacity-100 z-10': $wire.currentSlide === {{ $index }}, 
                'opacity-0 z-0': $wire.currentSlide !== {{ $index }} 
            }"
            style="background-image: url('{{ $slide['image'] }}')"
        >
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="container mx-auto h-full flex items-center px-4">
                <div class="max-w-lg text-white hero-content">
                    <h1 class="hero-title text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                        {{ $slide['title'] }}
                    </h1>
                    <p class="hero-title text-xl md:text-2xl mb-6">
                        {{ $slide['subtitle'] }}
                    </p>
                    <a 
                        href="{{ $slide['button_link'] }}" 
                        class="hero-title inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition duration-300 transform hover:scale-105"
                    >
                        {{ $slide['button_text'] }}
                    </a>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Controls -->
    <button 
        @click="$wire.prevSlide()"
        class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-white bg-opacity-80 hover:bg-opacity-100 p-2 rounded-full shadow-md transition"
    >
        <i class="fas fa-chevron-left text-gray-800"></i>
    </button>
    <button 
        @click="$wire.nextSlide()"
        class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-white bg-opacity-80 hover:bg-opacity-100 p-2 rounded-full shadow-md transition"
    >
        <i class="fas fa-chevron-right text-gray-800"></i>
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex space-x-2">
        @foreach($slides as $index => $slide)
            <button 
                @click="$wire.goToSlide({{ $index }})"
                class="w-3 h-3 rounded-full transition"
                :class="{ 
                    'bg-white scale-125': $wire.currentSlide === {{ $index }}, 
                    'bg-white bg-opacity-50': $wire.currentSlide !== {{ $index }} 
                }"
            ></button>
        @endforeach
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
@endpush