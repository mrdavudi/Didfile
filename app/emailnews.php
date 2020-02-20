<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class emailnews extends Model
{
    protected $table = 'emailnews';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User','userId');
    }
}
