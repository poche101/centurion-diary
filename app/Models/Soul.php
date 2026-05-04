<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soul extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'soul_name', 'phone', 'location',
        'date_won', 'baptized', 'follow_up_notes',
    ];

    protected $casts = [
        'date_won' => 'date',
        'baptized' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // For activity feed
    public function getTitleAttribute(): string
    {
        return "Won {$this->soul_name} to Christ";
    }

    public function getTypeAttribute(): string
    {
        return 'soul';
    }

    public function getValueAttribute(): string
    {
        return '+1 Soul';
    }
}
