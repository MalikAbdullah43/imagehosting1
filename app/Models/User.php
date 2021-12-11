<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $connection = 'mongodb';
    protected $collection = 'users'; 
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'updated_at',
        'created_at',
        'email_verified_at',
        'link_expiry',
        'status',
        "Auth_key",
        "Auth_key_P",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
