<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesVisit extends Model
{
    protected $fillable = [
        'tgl_visit',
        'image',
        'catatan',
        'visit_by',
        'user_id',
        'retail_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function retail()
    {
        return $this->belongsTo(Retail::class);
    }
}
