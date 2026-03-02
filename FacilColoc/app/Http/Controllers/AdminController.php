<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private function requireAdmin(): void
    {
        if (!Auth::user() || !Auth::user()->isGlobalAdmin()) {
            abort(403);
        }
    }

    public function dashboard()
    {
        $this->requireAdmin();

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
        $this->requireAdmin();

        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function ban(User $user)
    {
        $this->requireAdmin();

        $user->update([
            'banned_at' => now()
        ]);

        return back()->with('success', 'Utilisateur banni');
    }

    public function unban(User $user)
    {
        $this->requireAdmin();

        $user->update([
            'banned_at' => null
        ]);

        return back()->with('success', 'Utilisateur débanni');
    }
}
