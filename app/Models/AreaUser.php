<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AreaUser extends Pivot
{
    protected $table = 'area_user';
    protected $fillable = [
        'area_id',
        'user_id',
    ];
}
