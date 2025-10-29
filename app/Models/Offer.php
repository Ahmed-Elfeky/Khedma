<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
    ];

  
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
