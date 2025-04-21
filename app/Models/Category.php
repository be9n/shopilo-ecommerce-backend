<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->whereNull('parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    public function scopeParent(Builder $builder): void
    {
        $builder->whereNull('parent_id');
    }

    public function scopeChild(Builder $builder): void
    {
        $builder->whereHas('parent');
    }
}
