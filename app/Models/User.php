<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'phone',
        'password',
        'email',
        'otp_code',
        'otp_expires_at',
        'is_verified',
        'is_approved',
        'address',
        'city_id',
        'website',
        'commercial_registration',
        'tax_number',
        'logo',
        'longitude',
        'latitude',
        'role_id'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
    ];
    // public function hasRole($role)
    // {
    //     return $this->role === $role;
    // }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {
        return $this->role
            && $this->role->permissions->pluck('name')->contains($permission);
    }
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

    public function orders()
    {
        return $this->hasMany(Order::class);
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
}
