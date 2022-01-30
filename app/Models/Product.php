<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'item_code',
        'name',
        'unit',
        'reorder_qty',
        'max_discount',
        'purchase_price',
        'markup',
        'sell_price',
        'supplier_id',
        'brand_id',
        'tax'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockDetails()
    {
        return $this->hasOne(StockDetail::class);
    }

    public function stockDetail()
    {
        return $this->hasMany(StockDetail::class);
    }
}
