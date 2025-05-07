<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
    ];

    public array $translatable = [
        'name',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
