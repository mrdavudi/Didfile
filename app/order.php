<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = "orders";
    public $timestamps = false;

    protected $fillable = [
        'orderDate',
        'price',
        'productId',
        'userId',
        'sellerId',
        'bankId',
        'couponId'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'userId');
    }

    public function seller()
    {
        return $this->belongsTo('App\User', 'sellerId');
    }

    public function product()
    {
        return $this->belongsTo('App\product', 'productId');
    }

    public function bank()
    {
        return $this->belongsTo('App\bank', 'bankId');
    }

    public function coupon()
    {
        return $this->belongsTo('App\coupon', 'couponId');
    }
}
