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
        'top',
        'no_order'
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
