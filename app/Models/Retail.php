<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retail extends Model
{
    protected $fillable = [
        'nama',
        'kode_bp',
        'kecamatan',
        'user_id',
        'area_id',
        'brand_id'
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }
}
