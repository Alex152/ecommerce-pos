@props(['category'])

<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" 
            class="flex items-center text-gray-700 hover:text-indigo-600 transition">
        {{ $category->name }}
        @if($category->children->count())
        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
        @endif
    </button>
    
    @if($category->children->count())
    <div x-show="open" @click.away="open = false" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
        <div class="py-1">
            @foreach($category->children as $child)
                <a href="{{ route('ecommerce.shop.category', $child->slug) }}" 
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                    {{ $child->name }}
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>