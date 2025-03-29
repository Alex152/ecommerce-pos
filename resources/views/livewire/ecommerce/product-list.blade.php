<div>
    <div class="mb-6 flex flex-col md:flex-row gap-4">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search"
            placeholder="Search products..."
            class="flex-1 px-4 py-2 border rounded-lg"
        >
        <select wire:model.live="categoryId" class="px-4 py-2 border rounded-lg">
            <option value="">All Categories</option>
            @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <livewire:ecommerce.product-detail :product="$product" :key="$product->id" />
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>