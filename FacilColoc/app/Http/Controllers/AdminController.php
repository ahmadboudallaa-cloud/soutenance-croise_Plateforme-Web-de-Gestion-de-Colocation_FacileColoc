<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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

    public function create()
    {
        $this->requireAdmin();

        return view('admin.users-create');
    }

    public function store(Request $request)
    {
        $this->requireAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_global_admin' => ['nullable', 'boolean'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_global_admin' => (bool) $request->is_global_admin,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Compte créé.');
    }

    public function edit(User $user)
    {
        $this->requireAdmin();

        return view('admin.users-edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->requireAdmin();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_global_admin' => ['nullable', 'boolean'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_global_admin' => (bool) $request->is_global_admin,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Compte modifié.');
    }

    public function destroy(User $user)
    {
        $this->requireAdmin();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($user->is_global_admin) {
            $adminsCount = User::where('is_global_admin', true)->count();
            if ($adminsCount <= 1) {
                return back()->with('error', 'Impossible de supprimer le dernier admin.');
            }
        }

        $hasPayments = \App\Models\Payment::where('payer_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->exists();

        $hasExpenses = \App\Models\Expense::where('paid_by', $user->id)->exists();

        if ($hasPayments || $hasExpenses) {
            return back()->with('error', 'Impossible de supprimer ce compte : il possède des dépenses ou des paiements.');
        }

        $user->delete();

        return back()->with('success', 'Compte supprimé.');
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

    public function promote(User $user)
    {
        $this->requireAdmin();

        $user->update(['is_global_admin' => true]);

        return back()->with('success', 'Rôle admin attribué.');
    }

    public function demote(User $user)
    {
        $this->requireAdmin();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas vous retirer votre propre rôle admin.');
        }

        $adminsCount = User::where('is_global_admin', true)->count();
        if ($adminsCount <= 1) {
            return back()->with('error', 'Impossible de retirer le rôle du dernier admin.');
        }

        $user->update(['is_global_admin' => false]);

        return back()->with('success', 'Rôle admin retiré.');
    }
}
