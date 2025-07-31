<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = [
        'user_id',
        'retail_id',
        'order_time',
        'note_sales',
        'top'
    ];

    public function salesOrderDetails()
    {
        return $this->HasMany(SalesOrderDetail::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function retail()
    {
        return $this->belongsTo(Retail::class);
    }
}
