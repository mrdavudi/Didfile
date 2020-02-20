<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    protected $table='banks';
    public $timestamps = false;

    public function order()
    {
        return $this->hasMany('orders', 'bankId');
    }
}
