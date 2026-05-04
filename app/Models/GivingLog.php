<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GivingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount_espees', 'category', 'description', 'date_given',
    ];

    protected $casts = [
        'date_given'    => 'date',
        'amount_espees' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // For activity feed
    public function getTitleAttribute(): string
    {
        return ucfirst($this->category) . ' Contribution';
    }

    public function getTypeAttribute(): string
    {
        return 'giving';
    }

    public function getValueAttribute(): string
    {
        return '+' . number_format($this->amount_espees, 2) . ' esp.';
    }
}
