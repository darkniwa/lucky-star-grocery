<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['product_name', 'variation', 'description', 'availability', 'price', 'discounted_price', 'barcode', 'image_folder'];

    public function order()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }

    public function getCategoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function variations()
    {
        return $this->hasMany(Product::class, 'product_name', 'product_name');
    }

    public function getUnitsSoldAttribute()
    {
        return $this->orders->sum('quantity');
    }
}
