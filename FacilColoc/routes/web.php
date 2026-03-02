<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/invitations/{token}',
    [InvitationController::class, 'show']
)->name('invitations.show');

Route::get(
    '/join/{token}',
    [InvitationController::class, 'show']
)->name('colocations.join');

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

    Route::patch(
        '/colocations/{colocation}/deactivate',
        [ColocationController::class, 'deactivate']
    )->name('colocations.deactivate');

    Route::post(
        '/colocations/{colocation}/leave',
        [ColocationController::class, 'leave']
    )->name('colocations.leave');

    Route::post(
        '/colocations/{colocation}/members/{user}/remove',
        [ColocationController::class, 'removeMember']
    )->name('colocations.members.remove');

    Route::post(
        '/colocations/{colocation}/members/{user}/transfer-owner',
        [ColocationController::class, 'transferOwner']
    )->name('colocations.members.transfer');

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

    Route::delete(
        '/colocations/{colocation}/invitations/{invitation}',
        [InvitationController::class, 'destroy']
    )->name('colocations.invitations.destroy');

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

    Route::get(
        '/colocations/{colocation}/expenses/{expense}/edit',
        [ExpenseController::class, 'edit']
    )->name('expenses.edit');

    Route::patch(
        '/colocations/{colocation}/expenses/{expense}',
        [ExpenseController::class, 'update']
    )->name('expenses.update');

    Route::delete(
        '/colocations/{colocation}/expenses/{expense}',
        [ExpenseController::class, 'destroy']
    )->name('expenses.destroy');

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
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

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

            Route::get('/users/create', [AdminController::class, 'create'])
                ->name('users.create');

            Route::post('/users', [AdminController::class, 'store'])
                ->name('users.store');

            Route::get('/users/{user}/edit', [AdminController::class, 'edit'])
                ->name('users.edit');

            Route::patch('/users/{user}', [AdminController::class, 'update'])
                ->name('users.update');

            Route::delete('/users/{user}', [AdminController::class, 'destroy'])
                ->name('users.destroy');

            Route::post('/users/{user}/ban', [AdminController::class, 'ban'])
                ->name('users.ban');

            Route::post('/users/{user}/unban', [AdminController::class, 'unban'])
                ->name('users.unban');

            Route::post('/users/{user}/promote', [AdminController::class, 'promote'])
                ->name('users.promote');

            Route::post('/users/{user}/demote', [AdminController::class, 'demote'])
                ->name('users.demote');
        });
});
