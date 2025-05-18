<?php

namespace App\Models;

use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasTranslations, HasFile, InteractsWithMedia;

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

    public function canDeleteMedia(Media $media): bool
    {
        $mediaCount = $this->getMedia($media->collection_name)->count();

        return $mediaCount > 1;
    }
}
