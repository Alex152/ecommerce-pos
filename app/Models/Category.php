<?php
/*
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
    */


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'position',
        'is_visible',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'meta_keywords' => 'array',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    //Para shop page
    // Category.php
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function allCategoryIds()
    {
        $ids = [$this->id];

        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->allCategoryIds());
        }

        return $ids;
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class)
            ->withPivot('discount_value');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category_image')  //Antes _images
            ->useDisk('public')
            ->singleFile();
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('category_images') ?: asset('images/default-category.png');
    }
}