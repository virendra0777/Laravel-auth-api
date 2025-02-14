<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'users';

    protected $primaryKey = '_id';

    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'dob',
        'mobile',
        'email',
        'password',
        'referal_code',
        'referal_user',
        'profilepic',
        'appId',
        'gender',
        'login_with',
        'email_otp',
        'mobile_otp'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopegetById($query,$id){
        return $query->where('_id', $id);
    }

    public function scopeUserRole($query){
        return $query->where('role', 'user');
    }

    public function scopeAdminRole($query){
        return $query->where('role', 'admin');
    }
}
