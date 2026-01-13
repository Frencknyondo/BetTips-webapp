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
        'password',
        'phone',
        'role',
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
     * Helper to check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Helper to check if user is tipster
     */
    public function isTipster()
    {
        return $this->role === 'tipster';
    }

    /**
     * Get the tips for this user
     */
    public function tips()
    {
        return $this->hasMany(Tip::class, 'created_by');
    }

    /**
     * Get users this user is following
     */
    public function following()
    {
        return $this->hasMany(UserFollow::class, 'follower_id');
    }

    /**
     * Get users following this user
     */
    public function followers()
    {
        return $this->hasMany(UserFollow::class, 'followed_id');
    }

    /**
     * Get tip ratings made by this user
     */
    public function tipRatings()
    {
        return $this->hasMany(TipRating::class);
    }

    /**
     * Get notifications for this user
     */
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')
                    ->withPivot('is_read')
                    ->withTimestamps()
                    ->orderBy('notifications.created_at', 'desc');
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadNotificationsCount()
    {
        return $this->notifications()->wherePivot('is_read', false)->count();
    }

    /**
     * Check if this user is following another user
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }

    /**
     * Get tipster statistics
     */
    public function getTipsterStats()
    {
        $tips = $this->tips()
            ->whereDate('created_at', '>=', now()->startOfYear())
            ->whereDate('created_at', '<=', now())
            ->get();

        // Calculate win rate based on ratings
        $ratedTips = TipRating::whereIn('tip_id', $tips->pluck('id'))
            ->where('rating', '!=', 'pending')
            ->get();

        $winRate = 50; // Default
        if ($ratedTips->count() > 0) {
            $wins = $ratedTips->where('rating', 'win')->count();
            $winRate = round(($wins / $ratedTips->count()) * 100);
        }

        return [
            'total_tips' => $tips->count(),
            'rated_tips' => $ratedTips->count(),
            'win_rate' => $winRate,
        ];
    }

    /**
     * Get tipster level based on win rate
     */
    public function getTipsterLevel()
    {
        $stats = $this->getTipsterStats();
        $winRate = $stats['win_rate'];

        if ($winRate >= 80) {
            return 'MASTER';
        } elseif ($winRate >= 60) {
            return 'PRO';
        } else {
            return 'BEGINNER';
        }
    }

    /**
     * Get level color for UI
     */
    public function getLevelColor()
    {
        $level = $this->getTipsterLevel();

        return match($level) {
            'MASTER' => 'amber',
            'PRO' => 'blue',
            'BEGINNER' => 'slate',
            default => 'slate'
        };
    }

    /**
     * Get followers count
     */
    public function getFollowersCount()
    {
        return $this->followers()->count();
    }

    /**
     * Get current winning streak (simplified - in real app would track consecutive wins)
     */
    public function getCurrentStreak()
    {
        // For now, return a random streak between 0-15 days
        // In a real implementation, you'd track this based on tip results
        return rand(0, 15);
    }

    /**
     * Get recent wins count (last 7 tips)
     */
    public function getRecentWins()
    {
        // For now, simulate recent wins - in real app would check last 7 rated tips
        $stats = $this->getTipsterStats();
        $winRate = $stats['win_rate'];

        // Simulate based on win rate - higher win rate = more recent wins
        if ($winRate >= 80) return rand(5, 7);
        if ($winRate >= 60) return rand(3, 6);
        return rand(1, 4);
    }

    /**
     * Get tipster rank (simplified)
     */
    public function getTipsterRank()
    {
        $stats = $this->getTipsterStats();
        $winRate = $stats['win_rate'];

        if ($winRate >= 85) return "Top 1%";
        if ($winRate >= 80) return "Top 5%";
        if ($winRate >= 70) return "Top 10%";
        if ($winRate >= 60) return "Top 25%";
        return "Top 50%";
    }

    /**
     * Get background gradient classes for the card
     */
    public function getBackgroundGradient()
    {
        $level = $this->getTipsterLevel();

        return match($level) {
            'MASTER' => 'bg-gradient-to-br from-amber-500 via-orange-500 to-red-500',
            'PRO' => 'bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-500',
            'BEGINNER' => 'bg-gradient-to-br from-slate-500 via-gray-500 to-zinc-500',
            default => 'bg-gradient-to-br from-slate-500 via-gray-500 to-zinc-500'
        };
    }

    /**
     * Get accent color classes
     */
    public function getAccentColor()
    {
        $level = $this->getTipsterLevel();

        return match($level) {
            'MASTER' => 'bg-gradient-to-r from-amber-500 to-orange-500',
            'PRO' => 'bg-gradient-to-r from-blue-500 to-indigo-500',
            'BEGINNER' => 'bg-gradient-to-r from-slate-500 to-gray-500',
            default => 'bg-gradient-to-r from-slate-500 to-gray-500'
        };
    }

    /**
     * Get badge text for the tipster
     */
    public function getBadgeText()
    {
        $level = $this->getTipsterLevel();

        return match($level) {
            'MASTER' => 'MASTER',
            'PRO' => 'PRO TIPSTER',
            'BEGINNER' => 'BEGINNER',
            default => 'TIPSTER'
        };
    }
}
