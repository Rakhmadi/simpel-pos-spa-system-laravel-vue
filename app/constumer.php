<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class constumer extends Model
{
    protected $table='costomers';
    protected $fillable=[
        'id',
        'email',
        'name',
        'address',
        'phone',
    ];


}
