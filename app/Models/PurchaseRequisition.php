<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'remark',
        'status',
        'date',
        'office_id'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function purchaseRequisitions()
    {
        return $this->hasMany(PurchaseRequisitionProduct::class);
    }

}
