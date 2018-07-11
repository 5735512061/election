<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Header extends Authenticatable
{
    use Notifiable;

    protected $guard = 'header';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'header_name', 'master_id', 'tel', 'province', 'amphoe', 'district', 'image', 'email', 'password', 'status', 'comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function score_header()
    {
        return $this->hasMany('App\Score', 'header_id', 'id');
    }

}
