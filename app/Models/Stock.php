<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_type',
        'is_opening',
        'posting_date_time',
        'reorder_qty',
        'stock_date',
        'office_id',
        'purchase_order_id',
        "stock_transcation"
    ];

    public function stockDetails()
    {
        return $this->hasMany(StockDetail::class);
    }
}
