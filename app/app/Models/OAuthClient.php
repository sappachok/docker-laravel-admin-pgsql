<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
#use Laravel\Passport\HasApiTokens;
use Laravel\Sanctum\HasApiTokens;

class OAuthClient extends Authenticatable
{
    use HasApiTokens,Notifiable;

    protected $table = 'oauth_clients';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'provider', 'redirect', 'personal_access_client',
        'password_client', 'revoked'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];
}
