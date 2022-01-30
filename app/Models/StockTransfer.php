<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'office_id_from',
        'office_id_to',
        'status'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id_from', 'id');
    }
    public function officeTo()
    {
        return $this->belongsTo(Office::class, 'office_id_to', 'id');
    }
    public function stockDetails()
    {
        return $this->hasMany(StockDetail::class,'stock_id','stock_id');
    }
}
