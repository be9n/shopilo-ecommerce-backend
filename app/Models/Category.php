<?php

namespace App\Models;

use App\Contracts\Sortable as SortableContract;
use App\ModelAttributes\CategoryAttributes;
use App\ModelFilters\CategoryFilter;
use App\Traits\HasFile;
use App\Traits\HasSearchable;
use App\Traits\HasSortable;
use App\Traits\ModelAbilities\CategoryAbilities;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia, SortableContract
{
    use HasFactory, HasFile, HasTranslations;
    use HasSortable, HasSearchable, Filterable, CategoryAbilities;

    protected $fillable = [
        'name',
        'parent_id',
        'active'
    ];

    protected $translatable = [
        'name',
    ];

    protected $searchable = [
        'columns' => [
            'categories.name' => 10,
        ],
    ];

    /**
     * Sortable columns for the model.
     *
     * @var array<string>
     */
    protected array $sortable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'active' => 'boolean',
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

    public function isParent(): bool
    {
        return $this->parent_id === null;
    }

    public function canDeleteMedia(Media $media): bool
    {
        $mediaCount = $this->getMedia($media->collection_name)->count();

        return $mediaCount > 1;
    }
}
