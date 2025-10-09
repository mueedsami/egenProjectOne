<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'discount_price',
        'sku',
        'brand_id',
        'category_id',
        'stock_qty',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',

    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'deciman:2'

    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function reviews(){
        return $this->hasMany(ProductReview::class);
    }

    public function getPrimaryImageUrlAttribute(){
        $img = $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
        return $img ? asset('storage/' . $primaryImage->image_path) : asset('images/no-image.png');
    }


}
