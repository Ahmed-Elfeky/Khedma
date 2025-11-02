<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'desc'];


    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function hasActiveOffer()
    {
        $now = now();

        return $this->offer()
            ->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->exists();
    }


    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
