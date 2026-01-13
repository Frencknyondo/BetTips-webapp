<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\User;
use App\Models\Tip;
use App\Models\RoleChange;
use App\Models\TipRating;
use App\Models\UserFollow;
use App\Models\TipsterApplication;

class DashboardController extends Controller
{
    public function index()
    {
        $adsCount = Ad::count();
        $usersCount = User::count();
        $tipsCount = Tip::count();
        $roleChangesCount = RoleChange::count();
        $tipRatingsCount = TipRating::count();
        $userFollowsCount = UserFollow::count();
        $activeAdsCount = Ad::where('is_active', true)->count();
        $pendingApplicationsCount = TipsterApplication::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'adsCount',
            'usersCount',
            'tipsCount',
            'roleChangesCount',
            'tipRatingsCount',
            'userFollowsCount',
            'activeAdsCount',
            'pendingApplicationsCount'
        ));
    }
}
