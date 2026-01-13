<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $topTipsters = \App\Models\User::where('role', 'tipster')
        ->with('tips')
        ->get()
        ->sortByDesc(function($user) {
            return $user->getFollowersCount();
        })
        ->take(5);

    $tips = \App\Models\Tip::with('creator')
        ->where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->take(12)
        ->get();

    return view('index', compact('topTipsters', 'tips'));
});

// Search and filter API
Route::get('/api/search', function (Illuminate\Http\Request $request) {
    $query = $request->get('q', '');
    $filter = $request->get('filter', '');

    if ($query) {
        // Search logic
        $searchTerm = strtolower(trim($query));

        // Check if it's a tipster name
        $tipster = \App\Models\User::where('role', 'tipster')
            ->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
            ->first();

        if ($tipster) {
            // Return tipster profile and their tips
            $tips = $tipster->tips()
                ->where('is_active', true)
                ->with('creator')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return response()->json([
                'type' => 'tipster',
                'tipster' => [
                    'id' => $tipster->id,
                    'name' => $tipster->name,
                    'profile_picture' => $tipster->profile_picture,
                    'followers_count' => $tipster->getFollowersCount(),
                    'win_rate' => $tipster->getTipsterStats()['win_rate'],
                ],
                'tips' => $tips
            ]);
        }

        // Check if it's a company
        $companyTips = \App\Models\Tip::where('is_active', true)
            ->whereRaw('LOWER(company) LIKE ?', ['%' . $searchTerm . '%'])
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        if ($companyTips->count() > 0) {
            return response()->json([
                'type' => 'company',
                'company' => $query,
                'tips' => $companyTips
            ]);
        }

        // Otherwise, search in tips (title, body, bet_code)
        $tips = \App\Models\Tip::where('is_active', true)
            ->where(function($q) use ($searchTerm) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(body) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(bet_code) LIKE ?', ['%' . $searchTerm . '%']);
            })
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'type' => 'tips',
            'tips' => $tips
        ]);
    }

    if ($filter) {
        // Filter logic
        $tips = \App\Models\Tip::with('creator')->where('is_active', true);

        switch ($filter) {
            case 'top-tipsters':
                // Return top tipsters data
                $topTipsters = \App\Models\User::where('role', 'tipster')
                    ->with('tips')
                    ->get()
                    ->sortByDesc(function($user) {
                        return $user->getFollowersCount();
                    })
                    ->take(5)
                    ->map(function($tipster) {
                        return [
                            'id' => $tipster->id,
                            'name' => $tipster->name,
                            'profile_picture' => $tipster->profile_picture,
                            'followers_count' => $tipster->getFollowersCount(),
                            'win_rate' => $tipster->getTipsterStats()['win_rate'],
                            'badge' => $tipster->getBadgeText(),
                        ];
                    });

                return response()->json([
                    'type' => 'top-tipsters',
                    'tipsters' => $topTipsters
                ]);
            case 'today-tips':
                $tips->whereDate('created_at', today());
                break;
            case '2.5-odds':
                $tips->whereBetween('odds', [2.4, 2.6]);
                break;
            case 'big-odds':
                $tips->where('odds', '>=', 3.0);
                break;
            case 'free-tips':
                $tips->where('tip_type', 'free');
                break;
            case 'premium-tips':
                $tips->where('tip_type', 'premium');
                break;
            case 'senti16-og':
                // For Senti16 OG, maybe tips from a specific user or category
                // For now, just return some recent tips
                $tips->orderBy('created_at', 'desc');
                break;
            case 'hot':
                // For hot, maybe sort by some popularity metric, for now just recent
                $tips->orderBy('created_at', 'desc');
                break;
            case 'today':
                $tips->whereDate('created_at', today());
                break;
            default:
                // No filter or unknown filter
                break;
        }

        $tips = $tips->orderBy('created_at', 'desc')->take(12)->get();

        return response()->json([
            'type' => 'filter',
            'filter' => $filter,
            'tips' => $tips
        ]);
    }

    // No query or filter, return default
    return response()->json(['type' => 'default']);
});

// User routes
Route::middleware('auth')->group(function () {
    Route::post('/users/{user}/follow', [UserController::class, 'toggleFollow'])->name('users.follow');
    Route::get('/favorites', [UserController::class, 'favorites'])->name('favorites');
    Route::get('/favorites/{user}', [UserController::class, 'userTips'])->name('favorites.user');
    Route::get('/notifications', [UserController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notificationId}/read', [UserController::class, 'markNotificationRead'])->name('notifications.read');
});

Route::get('/users/{user}/profile', [UserController::class, 'profile'])->name('users.profile');

// include simple auth routes
require __DIR__.'/web_auth.php';

// admin routes (protected)
require __DIR__.'/admin.php';
