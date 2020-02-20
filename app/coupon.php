<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coupon extends Model
{
    protected $table = "coupons";
    public $timestamps = false;

    protected $fillable = ['description','code'];

    public function coupon(){
        return $this->belongsTo('App\product');
    }

    public function order()
    {
        return $this->hasMany('App\order','couponId');
    }

}
