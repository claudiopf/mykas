<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderDetail extends Model
{
    protected $fillable = [
        'sales_order_id',
        'product_id',
        'qty',
        'discount',
        'subtotal',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
