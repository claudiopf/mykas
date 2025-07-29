<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retail extends Model
{
    protected $fillable = [
        'nama',
        'kode_bp',
        'kecamatan',
        'area_id',
    ];

    public function areas() {
        return $this->belongsToMany(Area::class)
            ->using(AreaRetail::class)
            ->withTimestamps();
    }

    public function salesVisits()
    {
        return $this->hasMany(SalesVisit::class);
    }
}
