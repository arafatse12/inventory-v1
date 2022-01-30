<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'stock_id',
        'total_amount',
        'discount_percent',
        'discount_amount',
        'payment_amount',
        'change_amount',
        'due',
        'payment_mode',
        'bank_name',
        'checque_no',
        'status',
        'office_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function stockDetails()
    {
        return $this->hasMany(StockDetail::class);
    }

    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d-m-Y');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
