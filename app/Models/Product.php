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
}
