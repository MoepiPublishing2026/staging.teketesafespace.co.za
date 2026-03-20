<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
     */    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'school_name',
        'phone',
        'is_subscribed',
        'profile_picture',
    ];

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
        ];
    }

    /**
     * Get the URL for the user's profile picture.
     * Tries storage (Laravel symlink) first, then public/profile_pictures/ for compatibility.
     */
    public function getProfilePictureUrlAttribute(): ?string
    {
        if (empty($this->profile_picture)) {
            return null;
        }

        $path = $this->profile_picture;
        $storagePath = public_path('storage/' . $path);
        $publicPath = public_path('profile_pictures/' . basename($path));

        if (file_exists($storagePath)) {
            return asset('storage/' . $path);
        }
        if (file_exists($publicPath)) {
            return asset('profile_pictures/' . basename($path));
        }
        // Default to storage URL (e.g. when symlink exists but file_exists fails)
        return asset('storage/' . $path);
    }
    
    
    /**
     * Get the subscription record for this user.
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Check if this user has active subscription.
     */
    public function hasActiveSubscription(): bool
    {
        $sub = $this->subscription;

        if (!$sub) {
            return false;
        }

        return $sub->isActive();
    }

    /**
     * Get active subscription or null.
     */
    public function activeSubscription(): ?Subscription
    {
        $sub = $this->subscription;
        return ($sub && $sub->isActive()) ? $sub : null;
    }
}