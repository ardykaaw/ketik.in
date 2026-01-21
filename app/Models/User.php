<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
        'premium_until',
        'plan_name',
        'activation_email_sent_at',
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
        return $this->role === 'admin';
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
        ];
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
