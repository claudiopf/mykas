<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'no_idem',
        'nama',
        'harga',
        'brand_id',
        'deskripsi',
        'status_aktif'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function salesOrderDetails()
    {
        return $this->hasMany(SalesOrderDetail::class);
    }
}
