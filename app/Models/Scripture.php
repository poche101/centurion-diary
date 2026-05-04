<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scripture extends Model
{
    protected $fillable = ['date', 'reference', 'text'];

    protected $casts = [
        'date' => 'date', // ✅ converts to Carbon — isToday() will now work
    ];

    public static function today(): ?self
    {
        return static::where('date', now()->toDateString())->first();
    }
}