<?php

namespace App\Models;

use App\Traits\HasSortable;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Discount extends Model
{
    use HasTranslations, Filterable, HasSortable, LogsActivity;

    public array $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'description',
        'code',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
        'max_uses',
        'used_count',
        'max_uses_per_user'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];
    protected array $sortable = [
        'id',
        'name',
        'type',
        'value',
    ];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'type', 'value', 'start_date', 'end_date', 'is_active', 'max_uses', 'max_uses_per_user'])
            ->dontLogIfAttributesChangedOnly(['description', 'used_count'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'discount_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where(function ($query) {
                $query->where('max_uses', 0)
                    ->orWhereRaw('used_count < max_uses');
            });
    }
}
