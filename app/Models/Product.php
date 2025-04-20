<?php

namespace App\Models;

/*
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'barcode',
        'price', // USD
        'cost_price',
        'stock_quantity',
        'min_stock',
        'category_id',
        'is_active',
        'has_variants',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_active' => 'boolean',
        'has_variants' => 'boolean',
    ];

    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->where('stock_quantity', '<=', 'min_stock');
    }
}
    */




    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Builder;
    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\InteractsWithMedia;

    
    use Spatie\Image\Image;
    use Spatie\Image\Enums\Fit;
    use Spatie\Image\Enums\AlignPosition;
    use Spatie\MediaLibrary\MediaCollections\Models\Media;
    
    class Product extends Model implements HasMedia
    {
        use InteractsWithMedia;
    
        protected $fillable = [
            'name', 'slug', 'description', 'short_description', 'sku', 'barcode',
            'price', 'cost_price', 'special_price', 'special_price_from', 'special_price_to',
            'stock_quantity', 'min_stock', 'max_stock', 'manage_stock', 'backorders',
            'category_id', 'is_active', 'pos_visible', 'ecommerce_visible', 'is_featured',
            'has_variants', 'meta_title', 'meta_description', 'meta_keywords',
            'weight', 'height', 'width', 'length'
        ];
    
        protected $casts = [
            'is_active' => 'boolean',
            'pos_visible' => 'boolean',
            'ecommerce_visible' => 'boolean',
            'is_featured' => 'boolean',
            'has_variants' => 'boolean',
            'manage_stock' => 'boolean',
            'backorders' => 'boolean',
            'special_price_from' => 'datetime',
            'special_price_to' => 'datetime',
            'price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'special_price' => 'decimal:2'
        ];
    
        // Relaciones
        public function category()
        {
            return $this->belongsTo(Category::class);
        }
    
        public function inventory()
        {
            return $this->hasOne(Inventory::class);
        }
    
        public function variants()
        {
            return $this->hasMany(ProductVariant::class);
        }
    
        public function orderItems()
        {
            return $this->hasMany(OrderItem::class);
        }
    
        // Scopes
        /*
        public function scopeActive(Builder $query): Builder
        {
            return $query->where('is_active', true);
        }
            */
        
        public function scopeActive($query)
        {
            return $query->where('is_active', true);
            }
    
        public function scopeLowStock(Builder $query): Builder
        {
            return $query->whereColumn('stock_quantity', '<=', 'min_stock');
        }
    
        public function scopeFeatured(Builder $query): Builder
        {
            return $query->where('is_featured', true);
        }
    /*
        // Media
        public function registerMediaCollections(): void
        {
            $this->addMediaCollection('main_image')
                ->useDisk('public')
                ->singleFile();
                
            $this->addMediaCollection('gallery')
                ->useDisk('public');
        }
|    */

public function registerMediaCollections(): void
{
    /*
    $this
        ->addMediaCollection('main_image')
        ->singleFile()
        ->useDisk('media')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']) // Método actualizado
        ->registerMediaConversions(function (Media $media) {
            $this->addMediaConversion('thumb')
                ->width(300)
                ->height(300)
                ->quality(80);
        });

    $this
        ->addMediaCollection('gallery')
        ->useDisk('media')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']); // Método actualizado*/
    
    $this->addMediaCollection('gallery')
        ->useDisk('media')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
        //->withResponsiveImages();   //Para que genere varios tamaños y resoluciones
        //->maxNumberOfFiles(5);

    $this
        ->addMediaCollection('main_image')
        ->singleFile()
        ->useDisk('media')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
        ->registerMediaConversions(function (Media $media) {
            $this->addMediaConversion('thumb')
                ->width(300)
                ->height(300)
                ->quality(80);
                
            /*$this->addMediaConversion('preview')
                ->width(800)
                ->height(800)
                ->quality(85);*/
        });
}

public function getMainImageUrlAttribute()
{
    return $this->getFirstMediaUrl('main_image', 'thumb') ?: 
           asset('images/default-product.jpg'); // Fallback opcional
}

public function getGalleryUrlsAttribute()
{
    return $this->getMedia('gallery')->map(function ($media) {
        return [
            'url' => $media->getUrl(),
            'thumb' => $media->getUrl('thumb'), // Si tienes conversión thumb
            'alt' => $this->name
        ];
    });
}
        //Para DiscountResource/ProductRelationManager

        public function discounts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
        {
            return $this->belongsToMany(Discount::class)
                ->withPivot('discount_value');
        }

        /*
        en caso que se quiera que se puestre las etiquetas de los selects 
        globalmente con el name del producto

        public function getFilamentRecordTitle(): string
        {
            return $this->name;
        }
        */
    }