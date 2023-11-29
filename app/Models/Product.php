<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'price',
        'compare_price',
        'sku',
        'category_id',
        'sub_category_id',
        'brand_id',
        'is_feature',
        'track_qty',
        'qty',
        'status'
    ];

    public function productImage(){
        return $this->hasMany(ProductImage::class);
    }

    public function ProductColor(){
        return $this->hasMany(ProductColor::class);
    }

    public function ProductSize(){
        return $this->hasMany(ProductSize::class);
    }
}
