<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Follow or unfollow a user
     */
    public function toggleFollow(Request $request, User $user)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $currentUser = Auth::user();

        // Cannot follow yourself
        if ($currentUser->id === $user->id) {
            return response()->json(['error' => 'Cannot follow yourself'], 400);
        }

        $existingFollow = UserFollow::where('follower_id', $currentUser->id)
            ->where('followed_id', $user->id)
            ->first();

        if ($existingFollow) {
            // Unfollow
            $existingFollow->delete();
            $following = false;
        } else {
            // Follow
            UserFollow::create([
                'follower_id' => $currentUser->id,
                'followed_id' => $user->id,
            ]);
            $following = true;
        }

        return response()->json([
            'success' => true,
            'following' => $following,
            'followers_count' => $user->followers()->count(),
        ]);
    }

    /**
     * Get user profile data
     */
    public function profile(Request $request, User $user)
    {
        $stats = $user->getTipsterStats();

        // If request expects JSON (AJAX), return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'user' => $user,
                'stats' => $stats,
                'level' => $user->getTipsterLevel(),
                'level_color' => $user->getLevelColor(),
                'is_following' => Auth::check() ? Auth::user()->isFollowing($user) : false,
                'followers_count' => $user->followers()->count(),
            ]);
        }

        // Otherwise, return the profile view
        return view('profile', [
            'user' => $user,
            'stats' => $stats,
            'level' => $user->getTipsterLevel(),
            'level_color' => $user->getLevelColor(),
            'is_following' => Auth::check() ? Auth::user()->isFollowing($user) : false,
            'followers_count' => $user->followers()->count(),
        ]);
    }

    /**
     * Show favorites page with followed users
     */
    public function favorites()
    {
        $followedUsers = Auth::user()->following()
            ->with('followed')
            ->get()
            ->map(function($follow) {
                return $follow->followed;
            });

        return view('favorites', compact('followedUsers'));
    }

    /**
     * Show tips from a specific followed user
     */
    public function userTips(User $user)
    {
        // Check if current user is following this user
        if (!Auth::user()->isFollowing($user)) {
            abort(403, 'You are not following this user');
        }

        $tips = $user->tips()
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('favorites_user', compact('user', 'tips'));
    }

    /**
     * Show user notifications
     */
    public function notifications()
    {
        $notifications = Auth::user()->notifications()
            ->with('creator')
            ->orderBy('notifications.created_at', 'desc')
            ->paginate(20);

        return view('notifications', compact('notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markNotificationRead(Request $request, $notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('notifications.id', $notificationId)->first();

        if ($notification) {
            $user->notifications()->updateExistingPivot($notificationId, ['is_read' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Notification not found'], 404);
    }
}
