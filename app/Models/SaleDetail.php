<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'sell_amount',
        'purchase_amount',
        'total'
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
