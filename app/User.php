<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = false;
    protected $table = 'users';

    protected $fillable = [
        'name', 'family', 'email', 'password', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function comment()
    {
        return $this->hasMany('App\comment', 'userId');
    }

    public function product()
    {
        return $this->hasMany('App\product', 'userId');
    }

    public function order()
    {
        return $this->hasMany('App\order', 'userId');
    }

    public function sellerOrder()
    {
        return $this->hasMany('App\order','sellerId');
    }

    public function emailNews()
    {
        return $this->hasMany('App\emailnews', 'userId');
    }

    public function ticket()
    {
        return $this->hasMany('App\Ticket', 'userId');
    }
}
