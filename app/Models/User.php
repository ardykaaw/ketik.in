<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'lynk_id',
        'is_active',
        'avatar',
        'password',
        'role',
        'package_type',
        'premium_until',
        'plan_name',
        'activation_email_sent_at',
        'device_token',
        'last_seen_at',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->premium_until = now()->addYear(); // 1 Year Subscription
            $user->plan_name = 'Premium Plan';
            
            // Only set is_active to false if not explicitly set (e.g., by admin)
            if (!isset($user->is_active)) {
                $user->is_active = false; // Must be verified by admin
            }
        });
    }

    public function isPremium(): bool
    {
        return $this->premium_until && $this->premium_until->isFuture();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->role === 'superadmin';
    }

    public function hasUtamaAccess(): bool
    {
        if ($this->isAdmin()) return true;
        return ($this->package_type ?? 'utama') === 'utama';
    }

    public function hasGuruAccess(): bool
    {
        if ($this->isAdmin()) return true;
        $pkg = $this->package_type ?? 'utama';
        return in_array($pkg, ['utama', 'guru', 'guru_academy']);
    }

    public function hasAcademyAccess(): bool
    {
        if ($this->isAdmin()) return true;
        $pkg = $this->package_type ?? 'utama';
        return in_array($pkg, ['utama', 'academy', 'guru_academy', 'worksheet_anak']);
    }

    public function hasWorksheetAnakAccess(): bool
    {
        if ($this->isAdmin()) return true;
        $pkg = $this->package_type ?? 'utama';
        return in_array($pkg, ['utama', 'academy', 'guru_academy', 'worksheet_anak']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'premium_until' => 'datetime',
            'last_seen_at' => 'datetime',
        ];
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function completedLessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')
            ->withPivot('completed_at');
    }
}
