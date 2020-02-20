<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $table = "comments";
    public $timestamps = false;

    protected $fillable = ['text'];


    public function user(){
        return $this->belongsTo('App\User' , 'userId');
    }

    public function product(){
        return $this->belongsTo('App\product','productId');
    }
}
