<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'base_price',
        'is_active',
        'total_view'
    ];

    /* ================= RELATIONS ================= */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)
                    ->where('is_primary', 1);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function views()
    {
        return $this->hasMany(ProductView::class);
    }
    public function monthlySales()
    {
        return $this->hasMany(MonthlyProductSale::class);
    }
}
