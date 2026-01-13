<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\TipsController;
use App\Http\Controllers\Admin\UsersController;

use App\Http\Middleware\AdminMiddleware;

Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->group(function(){

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Ads management
    Route::get('/ads', [AdsController::class, 'index'])->name('admin.ads.index');
    Route::get('/ads/create', [AdsController::class, 'create'])->name('admin.ads.create');
    Route::post('/ads', [AdsController::class, 'store'])->name('admin.ads.store');
    Route::get('/ads/{ad}/edit', [AdsController::class, 'edit'])->name('admin.ads.edit');
    Route::put('/ads/{ad}', [AdsController::class, 'update'])->name('admin.ads.update');
    Route::delete('/ads/{ad}', [AdsController::class, 'destroy'])->name('admin.ads.destroy');
    Route::post('/ads/{ad}/toggle', [AdsController::class, 'toggle'])->name('admin.ads.toggle');

    // Tips management
    Route::get('/tips', [TipsController::class, 'index'])->name('admin.tips.index');
    Route::get('/tips/create', [TipsController::class, 'create'])->name('admin.tips.create');
    Route::post('/tips', [TipsController::class, 'store'])->name('admin.tips.store');
    Route::get('/tips/{tip}/edit', [TipsController::class, 'edit'])->name('admin.tips.edit');
    Route::put('/tips/{tip}', [TipsController::class, 'update'])->name('admin.tips.update');
    Route::delete('/tips/{tip}', [TipsController::class, 'destroy'])->name('admin.tips.destroy');
    Route::post('/tips/{tip}/toggle', [TipsController::class, 'toggle'])->name('admin.tips.toggle');

    // User management
    Route::get('/users', [UsersController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{user}/promote', [UsersController::class, 'promote'])->name('admin.users.promote');
    Route::post('/users/{user}/demote', [UsersController::class, 'demote'])->name('admin.users.demote');

    // Tipster Applications
    Route::get('/tipster-applications', [\App\Http\Controllers\Admin\TipsterApplicationsController::class, 'index'])->name('admin.tipster_applications.index');
    Route::post('/tipster-applications/{application}/approve', [\App\Http\Controllers\Admin\TipsterApplicationsController::class, 'approve'])->name('admin.tipster_applications.approve');
    Route::post('/tipster-applications/{application}/reject', [\App\Http\Controllers\Admin\TipsterApplicationsController::class, 'reject'])->name('admin.tipster_applications.reject');

    // Role change audit
    Route::get('/role-changes', [\App\Http\Controllers\Admin\RoleChangesController::class, 'index'])->name('admin.role_changes.index');

    // Notifications management
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationsController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/create', [App\Http\Controllers\Admin\NotificationsController::class, 'create'])->name('admin.notifications.create');
    Route::post('/notifications', [App\Http\Controllers\Admin\NotificationsController::class, 'store'])->name('admin.notifications.store');
    Route::get('/notifications/{notification}', [App\Http\Controllers\Admin\NotificationsController::class, 'show'])->name('admin.notifications.show');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\Admin\NotificationsController::class, 'destroy'])->name('admin.notifications.destroy');
});
