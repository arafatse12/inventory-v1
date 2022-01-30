<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'product_id',
        'quantity',
        'amount',
        'purchase_price',
        'sell_price',
        'markup'
    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
