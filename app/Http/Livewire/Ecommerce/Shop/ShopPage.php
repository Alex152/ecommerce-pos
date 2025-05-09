<?php

namespace App\Http\Livewire\Ecommerce\Shop;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;

class ShopPage extends Component
{
    use WithPagination;

    public $search = '';
    public $category = null;
    public $sort = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'sort' => ['except' => 'latest']
    ];

    //
    public function mount($category = null)
    {
        $this->category = $category;
    }
/*
    public function render()
    {
        $products = Product::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->category, fn($q) => $q->whereHas('category', fn($q) => $q->where('slug', $this->category)))
            ->with('media')
            ->orderBy($this->getSortField(), $this->getSortDirection())
            ->paginate(12);

        return view('livewire.ecommerce.shop.shop-page', [
            'products' => $products,
            'categories' => Category::whereNull('parent_id')->with('children')->get()
        ])->layout('layouts.ecommerce', [
            'title' => 'Tienda',
            'description' => 'Explora nuestros productos'
        ]);
    }
*/
    public function render()
    {
        $categoryIds = [];

        if ($this->category) {
            $category = Category::with('children')->where('slug', $this->category)->first();

            if ($category) {
                $categoryIds = $category->allCategoryIds();
            }
        }

        $products = Product::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($categoryIds, fn($q) => $q->whereIn('category_id', $categoryIds))
            ->with('media')
            ->orderBy($this->getSortField(), $this->getSortDirection())
            ->paginate(12);

        return view('livewire.ecommerce.shop.shop-page', [
            'products' => $products,
            'categories' => Category::whereNull('parent_id')->with('children')->get()
        ])->layout('layouts.ecommerce', [
            'title' => 'Tienda',
            'description' => 'Explora nuestros productos'
        ]);
    }

    protected function getSortField()
    {
        return match($this->sort) {
            'price_asc', 'price_desc' => 'price',
            default => 'created_at'
        };
    }

    protected function getSortDirection()
    {
        return match($this->sort) {
            'price_asc' => 'asc',
            'price_desc' => 'desc',
            default => 'desc'
        };
    }
}