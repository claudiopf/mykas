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
}
