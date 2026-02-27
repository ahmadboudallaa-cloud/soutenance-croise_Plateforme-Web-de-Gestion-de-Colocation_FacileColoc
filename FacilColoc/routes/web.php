<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Routes protégées (auth obligatoire)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        $colocations = auth()->user()->colocations;
        return view('dashboard', compact('colocations'));
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | COLOCATIONS (CRUD)
    |--------------------------------------------------------------------------
    */

    Route::resource('colocations', ColocationController::class);

    // Quitter une colocation
    Route::post('/colocations/{colocation}/leave',
        [ColocationController::class, 'leave'])
        ->name('colocations.leave');

    // Annuler une colocation (owner)
    Route::post('/colocations/{colocation}/cancel',
        [ColocationController::class, 'cancel'])
        ->name('colocations.cancel');

    // Rejoindre via token
    Route::get('/join/{token}',
        [ColocationController::class, 'join'])
        ->name('colocations.join');


    /*
    |--------------------------------------------------------------------------
    | EXPENSES (Dépenses)
    |--------------------------------------------------------------------------
    */

    Route::resource('colocations.expenses', ExpenseController::class)
        ->only(['create', 'store', 'destroy']);


    /*
    |--------------------------------------------------------------------------
    | ADMIN GLOBAL
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        Route::get('/admin/dashboard',
            [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::post('/admin/users/{user}/ban',
            [AdminController::class, 'ban'])
            ->name('admin.users.ban');

        Route::post('/admin/users/{user}/unban',
            [AdminController::class, 'unban'])
            ->name('admin.users.unban');
    });

});

/*
|--------------------------------------------------------------------------
| Auth Breeze
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';