<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPushSubscriptions;

    protected $fillable = [
        'full_name', 'email', 'phone', 'kingschat', 'group',
        'church', 'password', 'prayer_time', 'is_admin', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'is_admin'          => 'boolean',
        'password'          => 'hashed',
    ];

    // ── Relationships ──────────────────────────────────────────────

    public function prayerLogs()
    {
        return $this->hasMany(PrayerLog::class);
    }

    public function souls()
    {
        return $this->hasMany(Soul::class);
    }

    public function givingLogs()
    {
        return $this->hasMany(GivingLog::class);
    }

    // ── Computed Attributes ────────────────────────────────────────

    public function getPrayerHoursAttribute(): float
    {
        return round($this->prayerLogs()->sum('duration_minutes') / 60, 2);
    }

    public function getSoulsCountAttribute(): int
    {
        return $this->souls()->count();
    }

    public function getGivingEspeesAttribute(): float
    {
        return round($this->givingLogs()->sum('amount_espees'), 2);
    }

    public function getOverallProgressAttribute(): int
    {
        $prayer = min($this->prayer_hours / 100, 1) * 100;
        $souls  = min($this->souls_count  / 100, 1) * 100;
        $giving = min($this->giving_espees / 100, 1) * 100;

        return (int) round(($prayer + $souls + $giving) / 3);
    }

    public function getPrayerStreakAttribute(): int
    {
        $streak = 0;
        $date   = now()->toDateString();

        while (true) {
            $logged = $this->prayerLogs()
                ->whereDate('prayer_date', $date)
                ->exists();

            if (! $logged) break;

            $streak++;
            $date = now()->subDays($streak)->toDateString();

            if ($streak > 365) break;
        }

        return $streak;
    }
}
