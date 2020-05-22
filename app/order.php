<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class order extends Model
{
    protected $table='order';
    protected $fillable=[
'id',
'invoice',
'costomer_id',
'user_id',
'total',
'cart_id'
    ];
  public function cart(){
      return $this->hasOne(cart::class)->with('product');
  }
  public function usr(){
      return $this->hasOne(User::class,'id','user_id');
  }
  public function cos(){
    return $this->hasOne(constumer::class,'id','costomer_id');
}
}
