<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\RelationActionBy;
use App\Traits\Uuid;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    use RelationActionBy, Uuid; 
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'role_id',
        'password',
        'remember_token'
    ];
    protected $keyType = 'string';

    public $incrementing = false;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function Columns() {
        return $this->fillable;
    }
    
    public function searchRelations() {
        return [
            'role' => (new Roles())->Columns(),
        ];
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role(){
        return $this->belongsTo(Roles::class,'role_id');   
    }
    
    public function merchant(){
        return $this->hasOne(Merchant::class,'user_id');   
    }

    public function sendEmailVerification(){
        $this->notify(new VerifyEmail);
    }
}
