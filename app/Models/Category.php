<?php

namespace App\Models;

use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, InteractsWithMedia, HasFile, HasTranslations;

    protected $fillable = [
        'name',
        'parent_id',
    ];

    protected $translatable = [
        'name',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->whereNull('parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeParent(Builder $builder): void
    {
        $builder->whereNull('parent_id');
    }

    public function scopeChild(Builder $builder): void
    {
        $builder->whereHas('parent');
    }

    public function getCanBeDeletedAttribute(): bool
    {
        return !$this->children()->exists() && !$this->products()->exists();
    }
}
