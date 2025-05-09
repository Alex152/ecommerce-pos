<div x-data="{
        currentSlide: {{ $currentSlide }},
        slides: {{ json_encode($slides) }},
        autoPlay: {{ $autoPlay ? 'true' : 'false' }},
        autoPlayInterval: {{ $autoPlayInterval }},
        transitionDuration: {{ $transitionDuration }},
        isHovered: false,
        timer: null,
        progress: 0,
        scaleValue: 1, // Valor inicial de escala
        hoveringContent: false,

        
        init() {
            this.startAutoPlay();
            
            // Escuchar eventos de reinicio del timer
            this.$on('resetSliderTimer', () => {
                this.resetAutoPlay();
            });
            
            // Preload images para mejor performance
            this.preloadImages();
            
            // Inicializar la barra de progreso
            this.$watch('currentSlide', () => {
                this.progress = 0;
                this.scaleValue = 1; // Resetear escala al cambiar de slide
            });
        },
        
        preloadImages() {
            this.slides.forEach(slide => {
                const img = new Image();
                img.src = slide.image_url;
            });
        },
        
        startAutoPlay() {
            if (this.autoPlay && !this.isHovered) {
                this.timer = setInterval(() => {
                    this.updateProgress();
                    // Actualizar el efecto de alejamiento basado en el progreso
                    this.scaleValue = 1 + (this.progress / 100) * 0.05; // Aumenta 5% la escala
                }, 50); // Actualizamos más frecuentemente para animación suave
            }
        },
        
        updateProgress() {
            this.progress += (50 / this.autoPlayInterval) * 100;
            if (this.progress >= 100) {
                this.progress = 0;
                this.nextSlide();
            }
        },
        
        stopAutoPlay() {
            clearInterval(this.timer);
        },
        
        resetAutoPlay() {
            this.stopAutoPlay();
            this.progress = 0;
            this.scaleValue = 1;
            this.startAutoPlay();
        },
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
            this.$dispatch('slide-changed');
        },
        
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.$dispatch('slide-changed');
        },
        
        goToSlide(index) {
            this.currentSlide = index;
            this.$dispatch('slide-changed');
        }
    }"
    class="relative w-full h-screen max-h-[800px] overflow-hidden bg-gray-100 group"
    x-cloak>
    
    <!-- Slides -->
    <div class="relative w-full h-full">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 w-full h-full flex items-center">
                
                <!-- Imagen de fondo con efecto de alejamiento progresivo -->
                <div class="absolute inset-0 w-full h-full overflow-hidden">
                    <img :src="slide.image_url" 
                         :alt="slide.title" 
                         class="w-full h-full object-cover object-center transition-transform duration-700 ease-in-out"
                         :style="`transform: scale(${scaleValue})`"
                         loading="eager">
                    <div :class="slide.overlay_color" class="absolute inset-0 transition-all duration-500 opacity-80"></div>
                </div>
                
                <!-- Contenido del slide - Área que activa el hover -->
                <div @mouseenter="isHovered = true; hoveringContent = true; stopAutoPlay(); scaleValue = 1.08"
                     @mouseleave="isHovered = false; hoveringContent = false;scaleValue = 1; if(autoPlay) { progress = 0;  startAutoPlay() }"
                     class="relative container mx-auto px-6 sm:px-8 lg:px-12 h-full flex items-center"
                     {{--Añadido para alineacion de contenido--}}
                     :class="{
                        'justify-start': slide.text_position === 'left',
                        'justify-center': slide.text_position === 'center',
                        'justify-end': slide.text_position === 'right'
                    }"
                     >
                     {{--##--}}
                    <div :class="{
                        'text-left items-start': slide.text_position === 'left',
                        'text-center items-center': slide.text_position === 'center',
                        'text-right items-end': slide.text_position === 'right'
                    }" 
                    class="flex flex-col max-w-2xl space-y-6 z-20">
                        <!-- Subtítulo -->
                        <span x-show="slide.subtitle" 
                              :class="slide.text_color"
                              class="inline-block px-3 py-1 text-sm font-semibold tracking-wider uppercase bg-white bg-opacity-20 backdrop-blur-sm rounded-full animate-fade-in-up hover:bg-opacity-30 transition-all duration-300"
                              style="animation-delay: 0.2s">
                            <span x-text="slide.subtitle"></span>
                        </span>
                        
                        <!-- Título -->
                        <h2 :class="slide.text_color"
                            class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight animate-fade-in-up hover:text-opacity-90 transition-all duration-300"
                            style="animation-delay: 0.4s">
                            <span x-text="slide.title"></span>
                        </h2>
                        
                        <!-- Descripción -->
                        <p x-show="slide.description"
                           :class="slide.text_color"
                           class="text-lg md:text-xl opacity-90 max-w-lg animate-fade-in-up hover:opacity-100 transition-all duration-300"
                           style="animation-delay: 0.6s"
                           x-text="slide.description"></p>
                        
                        <!-- Botón -->
                        <div class="animate-fade-in-up" style="animation-delay: 0.8s">
                            <a :href="slide.button_url"
                               class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:scale-105">
                                <span x-text="slide.button_text"></span>
                                <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
    
    <!-- Barra de progreso -->
    <div class="absolute top-0 left-0 right-0 h-1 z-30 bg-white bg-opacity-20">
        <div class="h-full bg-white transition-all duration-50 ease-linear" 
             :style="`width: ${progress}%`"></div>
    </div>
    
    <!-- Controles de navegación -->
    <div class="absolute inset-0 flex items-center justify-between px-4">
        <!-- Botón anterior -->
        <button @click="prevSlide(); $dispatch('resetSliderTimer')" 
                class="z-20 p-3 rounded-full bg-white bg-opacity-20 hover:bg-opacity-40 text-white shadow-lg backdrop-blur-sm transition-all transform hover:scale-110 focus:outline-none group/prev"
                aria-label="Slide anterior">
            <svg class="h-6 w-6 md:h-8 md:w-8 transition-transform group-hover/prev:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        
        <!-- Botón siguiente -->
        <button @click="nextSlide(); $dispatch('resetSliderTimer')" 
                class="z-20 p-3 rounded-full bg-white bg-opacity-20 hover:bg-opacity-40 text-white shadow-lg backdrop-blur-sm transition-all transform hover:scale-110 focus:outline-none group/next"
                aria-label="Slide siguiente">
            <svg class="h-6 w-6 md:h-8 md:w-8 transition-transform group-hover/next:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    
    <!-- Indicadores de paginación mejorados -->
    <div class="absolute bottom-8 left-0 right-0 z-20">
        <div class="flex items-center justify-center space-x-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="goToSlide(index); $dispatch('resetSliderTimer')"
                        class="relative w-12 h-1.5 rounded-full transition-all duration-300 focus:outline-none overflow-hidden bg-white bg-opacity-30"
                        :aria-label="'Ir al slide ' + (index + 1)">
                    <div class="absolute inset-0 bg-white transition-all duration-300"
                         :class="{'opacity-100': currentSlide === index, 'opacity-0': currentSlide !== index}"
                         :style="currentSlide === index ? `width: ${progress}%` : 'width: 0%'"></div>
                </button>
            </template>
        </div>
    </div>
    
    <!-- Controles adicionales mejorados -->
    <div class="absolute top-4 right-4 z-20 flex space-x-2">
        <button @click="autoPlay = !autoPlay; autoPlay ? (progress = 0, scaleValue = 1, startAutoPlay()) : stopAutoPlay()"
                class="p-2.5 rounded-full bg-white bg-opacity-20 hover:bg-opacity-40 text-white shadow-lg backdrop-blur-sm transition-all transform hover:scale-110 focus:outline-none"
                :aria-label="autoPlay ? 'Pausar slider automático' : 'Iniciar slider automático'">
            <svg x-show="!autoPlay" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg x-show="autoPlay" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
        
        <!-- Contador de slides -->
        <div class="px-3 py-1.5 rounded-full bg-white bg-opacity-20 backdrop-blur-sm text-white text-sm font-medium flex items-center">
            <span x-text="currentSlide + 1"></span>
            <span class="mx-1">/</span>
            <span x-text="slides.length"></span>
        </div>
    </div>
    
    <!-- Efecto de degradado mejorado -->
    <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-gray-900 to-transparent opacity-40 z-10"></div>
</div>

@push('styles')
<style>
    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        opacity: 0;
        animation: fade-in-up 0.8s ease-out forwards;
    }
</style>
@endpush
