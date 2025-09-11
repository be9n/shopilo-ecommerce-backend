<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'rate',
        'is_default',
        'active'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'active' => 'boolean'
    ];
}
