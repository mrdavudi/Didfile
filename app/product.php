<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = "products";
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'headings',
        'detail_description',
        'price',
        'size',
        'time',
        'level',
        'category',
        'picFile',
        'attachFile',
    ];


    public function comment()
    {
        $this->hasMany('App\comment', 'productId');
    }

    public function coupon()
    {
        $this->hasMany('App\coupon', 'productId');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'userId');
    }

    public function order()
    {
        return $this->hasMany('App\order', 'productId');
    }

    public function category()
    {
        return $this->belongsTo('App\category', 'categoryId');
    }
}
