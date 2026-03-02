<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'not_banned'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {

        $colocations = auth()->user()
            ->colocations()
            ->where('colocations.status', 'active')
            ->wherePivotNull('left_at')
            ->orderBy('colocations.created_at', 'desc')
            ->get();

        return view('dashboard', compact('colocations'));

    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | COLOCATIONS
    |--------------------------------------------------------------------------
    */
    Route::resource('colocations', ColocationController::class);

    Route::patch(
        '/colocations/{colocation}/cancel',
        [ColocationController::class, 'cancel']
    )->name('colocations.cancel');

    Route::post(
        '/colocations/{colocation}/leave',
        [ColocationController::class, 'leave']
    )->name('colocations.leave');

    Route::post(
        '/colocations/{colocation}/members/{user}/remove',
        [ColocationController::class, 'removeMember']
    )->name('colocations.members.remove');

    Route::get(
        '/join/{token}',
        [InvitationController::class, 'show']
    )->name('colocations.join');

    Route::get(
        '/invitations/{token}',
        [InvitationController::class, 'show']
    )->name('invitations.show');

    Route::post(
        '/invitations/{token}/accept',
        [InvitationController::class, 'accept']
    )->name('invitations.accept');

    Route::post(
        '/invitations/{token}/decline',
        [InvitationController::class, 'decline']
    )->name('invitations.decline');

    Route::post(
        '/colocations/{colocation}/invite',
        [InvitationController::class, 'store']
    )->name('colocations.invite');

    /*
    |--------------------------------------------------------------------------
    | EXPENSES
    |--------------------------------------------------------------------------
    */
    Route::get(
        '/colocations/{colocation}/expenses/create',
        [ExpenseController::class, 'create']
    )->name('expenses.create');

    Route::post(
        '/colocations/{colocation}/expenses',
        [ExpenseController::class, 'store']
    )->name('expenses.store');

    /*
    |--------------------------------------------------------------------------
    | PAYMENTS
    |--------------------------------------------------------------------------
    */
    Route::post(
        '/payments',
        [PaymentController::class, 'store']
    )->name('payments.store');

    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/users', [AdminController::class, 'users'])
                ->name('users.index');

            Route::post('/users/{user}/ban', [AdminController::class, 'ban'])
                ->name('users.ban');

            Route::post('/users/{user}/unban', [AdminController::class, 'unban'])
                ->name('users.unban');
        });
});
