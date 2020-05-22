<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{
    protected $table='orders_details';
    protected $fillable=[
        'id',
'order_id',
'product_id',
'qty',
'price',
    ];
}
