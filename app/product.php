<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table='products';
    protected $fillable=[

'name',
'discription',
'stock',
'price',
'category_id',
'photo',
'code',
    ];
    public function category()
{
    return $this->belongsTo(category::class);
}
public function cart(){
    return $this->belongsTo('App\cart','product_id');
}

}
