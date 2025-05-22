<?php

namespace App\Models;

use App\Contracts\Sortable as SortableContract;
use App\Traits\HasFile;
use App\Traits\HasSearchable;
use App\Traits\HasSortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia, SortableContract
{
    use HasFactory, HasTranslations, HasFile;
    use HasSortable, HasSearchable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'stock',
        'status',
    ];

    public array $translatable = [
        'name',
        'description'
    ];

    protected array $searchable = [
        'columns' => [
            'products.name' => 10,
            'categories.name' => 10,
        ],
        'joins' => [
            'categories' => ['products.category_id', 'categories.id'],
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
        'price',
        'created_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function canDeleteMedia(Media $media): bool
    {
        $mediaCount = $this->getMedia($media->collection_name)->count();

        return $mediaCount > 1;
    }
}
