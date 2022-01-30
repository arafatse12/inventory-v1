<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'parent_id'
    ];

    public function offices()
    {
        return $this->belongsTo(Office::class, 'parent_id');
    }

    public function customers()
    {
        return $this->hasOne(Customer::class);
    }
}
