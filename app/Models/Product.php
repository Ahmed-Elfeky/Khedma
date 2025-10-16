<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'subcategory_id',
        'name',
        'image',
        'price',
        'desc',
        'discount',
        'guarantee',
        'user_id'

    ];

public function user(){
    return $this->belongsTo(User::class);
}
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes');
    }

public function images(){
    return $this->hasMany(ProductImage::class);
}

}
