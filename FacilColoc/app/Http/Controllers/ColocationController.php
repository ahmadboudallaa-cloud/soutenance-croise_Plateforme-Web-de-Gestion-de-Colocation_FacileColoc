<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    private function ensureOwner(Colocation $colocation): void
    {
        $isOwner = $colocation->users()
            ->where('users.id', Auth::id())
            ->wherePivot('role', 'owner')
            ->wherePivotNull('left_at')
            ->exists();

        if (!$isOwner) {
            abort(403);
        }
    }
    public function index()
    {
        $colocations = Auth::user()
            ->colocations()
            ->wherePivotNull('left_at')
            ->orderBy('colocations.created_at', 'desc')
            ->get();

        return view('colocations.index', compact('colocations'));
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function edit(Colocation $colocation)
    {
        $this->ensureOwner($colocation);

        return view('colocations.edit', compact('colocation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if (
            Auth::user()
                ->colocations()
                ->where('colocations.status', 'active')
                ->wherePivotNull('left_at')
                ->exists()
        ) {
            return redirect()
                ->route('colocations.create')
                ->withInput()
                ->with(
                    'error',
                    'Déjà une colocation active. Annulez ou quittez votre colocation avant d’en créer une nouvelle.'
                );
        }

        $colocation = Colocation::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
        ]);

        $colocation->users()->attach(Auth::id(), [
            'role' => 'owner',
            'left_at' => null,
        ]);

        return redirect()->route('colocations.show', $colocation);
    }

    public function update(Request $request, Colocation $colocation)
    {
        $this->ensureOwner($colocation);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $colocation->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('colocations.show', $colocation)
            ->with('success', 'Colocation modifiée.');
    }

    public function show(Colocation $colocation)
    {
        $isOwner = $colocation->users()
            ->where('users.id', Auth::id())
            ->wherePivot('role', 'owner')
            ->wherePivotNull('left_at')
            ->exists();

        if ($colocation->status !== 'active' && !$isOwner) {
            return redirect()->route('dashboard');
        }

        $members = $colocation->users()->whereNull('left_at')->get();
        $selectedMonth = request()->query('month');
        $expensesQuery = $colocation->expenses()->with('payer');
        if ($selectedMonth) {
            $expensesQuery->whereYear('expense_date', substr($selectedMonth, 0, 4))
                ->whereMonth('expense_date', substr($selectedMonth, 5, 2));
        }

        $expenses = $expensesQuery->orderBy('expense_date', 'desc')->get();
        $payments = $colocation->payments()
            ->with(['payer', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();
        $invitations = $colocation->invitations()
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $balances = $this->calculateBalances($members, $expenses, $payments);
        $isInactive = $colocation->status === 'inactive';

        $debtors = collect($balances)->filter(fn ($b) => $b['balance'] < 0);
        $creditors = collect($balances)->filter(fn ($b) => $b['balance'] > 0);

        $settlements = [];

        foreach ($debtors as $debtor) {
            $debt = abs($debtor['balance']);

            foreach ($creditors as &$creditor) {
                if ($debt <= 0) {
                    break;
                }
                if ($creditor['balance'] <= 0) {
                    continue;
                }

                $amount = min($debt, $creditor['balance']);

                $settlements[] = [
                    'from' => $debtor['user'],
                    'to' => $creditor['user'],
                    'amount' => $amount,
                ];

                $creditor['balance'] -= $amount;
                $debt -= $amount;
            }
        }

        return view('colocations.show', compact(
            'colocation',
            'members',
            'expenses',
            'payments',
            'balances',
            'settlements',
            'invitations',
            'isOwner',
            'selectedMonth',
            'isInactive'
        ));
    }

    public function cancel(Colocation $colocation)
    {
        $this->ensureOwner($colocation);

        if ($colocation->status === 'cancelled') {
            return redirect()->route('dashboard')
                ->with('error', 'Cette colocation est déjà annulée.');
        }

        $members = $colocation->users()->whereNull('left_at')->get();
        $expenses = $colocation->expenses()->with('payer')->get();
        $payments = $colocation->payments()->get();
        $balances = $this->calculateBalances($members, $expenses, $payments);

        foreach ($balances as $balance) {
            $delta = $balance['balance'] < 0 ? -1 : 1;
            $balance['user']->increment('reputation', $delta);
        }

        $colocation->delete();
        return redirect()->route('dashboard')
            ->with('success', 'Colocation supprimée.');
    }

    public function deactivate(Colocation $colocation)
    {
        $this->ensureOwner($colocation);

        if ($colocation->status !== 'active') {
            return redirect()->route('dashboard')
                ->with('error', 'Cette colocation n’est pas active.');
        }

        $colocation->update(['status' => 'inactive']);

        return redirect()->route('dashboard')
            ->with('success', 'Colocation désactivée.');
    }

    public function leave(Colocation $colocation)
    {
        $membership = $colocation->users()
            ->where('users.id', Auth::id())
            ->wherePivotNull('left_at')
            ->first();

        if (!$membership) {
            abort(403);
        }

        $role = $membership->pivot->role ?? 'member';
        if ($role === 'owner') {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Le propriétaire ne peut pas quitter la colocation.');
        }

        $members = $colocation->users()->whereNull('left_at')->get();
        $expenses = $colocation->expenses()->with('payer')->get();
        $payments = $colocation->payments()->get();
        $balances = $this->calculateBalances($members, $expenses, $payments);

        $currentBalance = $balances[Auth::id()]['balance'] ?? 0;
        $delta = $currentBalance < 0 ? -1 : 1;
        Auth::user()->increment('reputation', $delta);

        $colocation->users()->updateExistingPivot(Auth::id(), [
            'left_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Vous avez quitté la colocation.');
    }

    public function removeMember(Colocation $colocation, \App\Models\User $user)
    {
        $this->ensureOwner($colocation);

        $member = $colocation->users()
            ->where('users.id', $user->id)
            ->wherePivotNull('left_at')
            ->first();

        if (!$member) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Membre introuvable.');
        }

        if (($member->pivot->role ?? 'member') === 'owner') {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Impossible de retirer le propriétaire.');
        }

        $members = $colocation->users()->whereNull('left_at')->get();
        $expenses = $colocation->expenses()->with('payer')->get();
        $payments = $colocation->payments()->get();
        $balances = $this->calculateBalances($members, $expenses, $payments);

        $memberBalance = $balances[$user->id]['balance'] ?? 0;
        $delta = $memberBalance < 0 ? -1 : 1;
        $user->increment('reputation', $delta);

        if ($memberBalance < 0) {
            $ownerId = Auth::id();
            $colocation->payments()->create([
                'payer_id' => $ownerId,
                'receiver_id' => $user->id,
                'amount' => abs($memberBalance),
            ]);
        }

        $colocation->users()->updateExistingPivot($user->id, [
            'left_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Membre retiré.');
    }

    public function transferOwner(Colocation $colocation, \App\Models\User $user)
    {
        $this->ensureOwner($colocation);

        $member = $colocation->users()
            ->where('users.id', $user->id)
            ->wherePivotNull('left_at')
            ->first();

        if (!$member) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Membre introuvable.');
        }

        if (($member->pivot->role ?? 'member') === 'owner') {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Ce membre est déjà owner.');
        }

        $colocation->users()->updateExistingPivot(Auth::id(), [
            'role' => 'member',
        ]);

        $colocation->users()->updateExistingPivot($user->id, [
            'role' => 'owner',
        ]);

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Rôle owner transféré.');
    }

    private function calculateBalances($members, $expenses, $payments): array
    {
        $totalExpenses = $expenses->sum('amount');
        $memberCount = $members->count();
        $share = $memberCount > 0 ? $totalExpenses / $memberCount : 0;

        $balances = [];

        foreach ($members as $member) {
            $paidExpenses = $expenses
                ->where('paid_by', $member->id)
                ->sum('amount');

            $received = $payments
                ->where('receiver_id', $member->id)
                ->sum('amount');

            $sent = $payments
                ->where('payer_id', $member->id)
                ->sum('amount');

            $paid = $paidExpenses + $sent - $received;

            $balances[$member->id] = [
                'user' => $member,
                'paid' => $paid,
                'share' => $share,
                'balance' => $paid - $share,
            ];
        }

        return $balances;
    }
}
