@extends('admin.layout')

@section('title','Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-blue-500 text-white rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Total Ads</h3>
                    <div class="text-3xl font-bold">{{ $adsCount }}</div>
                </div>
                <i class="fas fa-ad text-4xl opacity-75"></i>
            </div>
            <a href="{{ route('admin.ads.index') }}" class="text-blue-100 hover:text-white text-sm mt-4 inline-block">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <div class="bg-orange-500 text-black rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Total Tips</h3>
                    <div class="text-3xl font-bold">{{ $tipsCount }}</div>
                </div>
                <i class="fas fa-lightbulb text-4xl opacity-75"></i>
            </div>
            <a href="{{ route('admin.tips.index') }}" class="text-orange-100 hover:text-white text-sm mt-4 inline-block">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <div class="bg-red-500 text-white rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Total Users</h3>
                    <div class="text-3xl font-bold">{{ $usersCount }}</div>
                </div>
                <i class="fas fa-users text-4xl opacity-75"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-red-100 hover:text-white text-sm mt-4 inline-block">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <div class="bg-green-500 text-white rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Total Role Changes</h3>
                    <div class="text-3xl font-bold">{{ $roleChangesCount }}</div>
                </div>
                <i class="fas fa-exchange-alt text-4xl opacity-75"></i>
            </div>
            <a href="{{ route('admin.role_changes.index') }}" class="text-green-100 hover:text-white text-sm mt-4 inline-block">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <div class="bg-purple-500 text-white rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Pending Applications</h3>
                    <div class="text-3xl font-bold">{{ $pendingApplicationsCount }}</div>
                </div>
                <i class="fas fa-user-plus text-4xl opacity-75"></i>
            </div>
            <a href="{{ route('admin.tipster_applications.index') }}" class="text-purple-100 hover:text-white text-sm mt-4 inline-block">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-500 text-white rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Total Tip Ratings</h3>
                    <div class="text-3xl font-bold">{{ $tipRatingsCount }}</div>
                </div>
                <i class="fas fa-star text-4xl opacity-75"></i>
            </div>
            <a href="#" class="text-blue-100 hover:text-white text-sm mt-4 inline-block">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <div class="bg-pink-500 text-white rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Total User Follows</h3>
                    <div class="text-3xl font-bold">{{ $userFollowsCount }}</div>
                </div>
                <i class="fas fa-heart text-4xl opacity-75"></i>
            </div>
            <a href="#" class="text-pink-100 hover:text-white text-sm mt-4 inline-block">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        <div class="bg-green-500 text-white rounded-lg p-6 shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Active Ads</h3>
                    <div class="text-3xl font-bold">{{ $activeAdsCount }}</div>
                </div>
                <i class="fas fa-check-circle text-4xl opacity-75"></i>
            </div>
            <a href="{{ route('admin.ads.index') }}" class="text-green-100 hover:text-white text-sm mt-4 inline-block">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endsection
