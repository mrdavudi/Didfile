<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = "categories";
    public $timestamps = false;

    protected $fillable = ['categoryName'];


    public function product()
    {
        return $this->hasMany('App\product', 'categoryId');
    }
}
