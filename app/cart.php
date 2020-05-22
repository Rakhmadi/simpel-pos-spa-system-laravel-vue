<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $table="cart";
    protected $fillable=[
        'qty',
        'price',
        'product_id'
    ];
    public function prod(){
        return $this->hasMany(product::class,'id','product_id')->with('category');
    }

}
