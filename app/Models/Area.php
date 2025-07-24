<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'nama',
        'kode_area'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(AreaUser::class)
            ->withTimestamps();
    }
}
