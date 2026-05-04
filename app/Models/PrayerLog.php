<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'prayer_date', 'duration_minutes', 'prayer_type', 'notes',
    ];

    protected $casts = [
        'prayer_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getHoursAttribute(): float
    {
        return round($this->duration_minutes / 60, 2);
    }

    // Virtual fields for the activity feed
    public function getTitleAttribute(): string
    {
        $mins = $this->duration_minutes;
        $formatted = $mins >= 60
            ? floor($mins / 60) . 'h ' . ($mins % 60) . 'min'
            : $mins . ' min';
        return "Prayed for {$formatted}";
    }

    public function getTypeAttribute(): string
    {
        return 'prayer';
    }

    public function getValueAttribute(): string
    {
        return '+' . number_format($this->duration_minutes / 60, 2) . 'h';
    }
}
