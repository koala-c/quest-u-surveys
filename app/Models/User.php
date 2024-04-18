<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    public $timestamps = false;

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "enquestador";

    protected $primaryKey = 'codienquestador';

    protected $fillable = [
        'nom',
        'contrasenya',
        'codilocalitzacio',
    ];

    protected $hidden = [
        'contrasenya',
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        // 'contrasenya' => 'hashed', // Example: to automatically hash passwords
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
