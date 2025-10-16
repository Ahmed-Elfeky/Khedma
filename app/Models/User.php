<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = ['is_verified'];


    protected $fillable = [
        'name',
        'phone',
        'password',
        'otp_code',
        'otp_expires_at',
        'is_verified',
        'user_type',
        'address',
        'city_id',
        'website',
        'commercial_registration',
        'tax_number',
        'logo',
        'longitude',
        'latitude'
    ];



    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
