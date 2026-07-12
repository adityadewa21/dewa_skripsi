<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonthlyProductSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'month',
        'total_sold'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
