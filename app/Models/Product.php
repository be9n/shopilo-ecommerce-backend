<?php

namespace App\Models;

use App\Contracts\Sortable as SortableContract;
use App\Traits\HasFile;
use App\Traits\HasSearchable;
use App\Traits\HasSortable;
use App\Traits\ModelAbilities\ProductAbilities;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia, SortableContract
{
    use HasFactory, HasTranslations, HasFile;
    use HasSortable, HasSearchable, Filterable, ProductAbilities;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'active',
        'discount_id'
    ];

    protected $casts = [
        'price' => 'float',
        'active' => 'boolean',
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

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function hasActiveDiscount(): bool
    {
        return $this->discount()->active()->exists();
    }

    public function getDiscountPriceAttribute(): float|null
    {
        if (!$this->hasActiveDiscount()) {
            return null;
        }

        $discount = $this->discount;

        if ($discount->type === 'fixed') {
            return max(0, $this->price - $discount->value);
        }

        if ($discount->type === 'percentage') {
            $discountAmount = $this->price * ($discount->value / 100);
            return max(0, $this->price - $discountAmount);
        }

        return $this->price;
    }
}
