<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AreaRetail extends Pivot
{
    protected $table = 'area_retail';
    protected $fillable = [
        'area_id',
        'retail_id',
    ];
}
