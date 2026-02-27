<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;

class AdminController extends Controller
{
    public function dashboard()
    {
        $usersCount = User::count();
        $colocationsCount = Colocation::count();
        $expensesCount = Expense::count();
        $bannedCount = User::whereNotNull('banned_at')->count();

        return view('admin.dashboard', compact(
            'usersCount',
            'colocationsCount',
            'expensesCount',
            'bannedCount'
        ));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function ban(User $user)
    {
        $user->update([
            'banned_at' => now()
        ]);

        return back()->with('success','Utilisateur banni');
    }

    public function unban(User $user)
    {
        $user->update([
            'banned_at' => null
        ]);

        return back()->with('success','Utilisateur débanni');
    }
}