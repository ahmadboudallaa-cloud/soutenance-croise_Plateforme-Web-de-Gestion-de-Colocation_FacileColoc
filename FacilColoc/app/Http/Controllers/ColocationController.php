<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $colocations = Auth::user()->colocations;
        return view('colocations.index', compact('colocations'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('colocations.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE (création)
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // 🚫 Une seule colocation active
        $hasActive = Auth::user()
            ->colocations()
            ->where('status', 'active')
            ->exists();

        if ($hasActive) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez déjà une colocation active.');
        }

        $colocation = Colocation::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
        ]);

        // 👑 Attacher owner
        $colocation->users()->attach(Auth::id(), [
            'role' => 'owner',
            'left_at' => null,
        ]);

        return redirect()->route('colocations.show', $colocation);
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Colocation $colocation)
    {
        if ($colocation->status !== 'active') {
            return redirect()->route('dashboard')
                ->with('error', 'Colocation annulée.');
        }

        $balances = $this->calculateBalances($colocation);

        return view('colocations.show', compact('colocation', 'balances'));
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Colocation $colocation)
    {
        return view('colocations.edit', compact('colocation'));
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Colocation $colocation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $colocation->update($request->only(['name', 'description']));

        return redirect()->route('colocations.show', $colocation);
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY (suppression)
    |--------------------------------------------------------------------------
    */

    public function destroy(Colocation $colocation)
    {
        $colocation->delete();
        return redirect()->route('dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | JOIN via token
    |--------------------------------------------------------------------------
    */

    public function join($token)
    {
        $colocation = Colocation::where('invitation_token', $token)->firstOrFail();

        // 🚫 Une seule colocation active
        $hasActive = Auth::user()
            ->colocations()
            ->where('status', 'active')
            ->exists();

        if ($hasActive) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez déjà une colocation active.');
        }

        $colocation->users()->attach(Auth::id(), [
            'role' => 'member',
            'left_at' => null,
        ]);

        return redirect()->route('colocations.show', $colocation);
    }


    /*
    |--------------------------------------------------------------------------
    | LEAVE (Member quitte)
    |--------------------------------------------------------------------------
    */

    public function leave(Colocation $colocation)
    {
        $user = Auth::user();

        $membership = $colocation->users()
            ->where('user_id', $user->id)
            ->first();

        if (!$membership) {
            return redirect()->route('dashboard');
        }

        if ($membership->pivot->role === 'owner') {
            return redirect()->back()
                ->with('error', 'Le propriétaire ne peut pas quitter.');
        }

        $balance = $this->calculateUserBalance($colocation, $user);

        if ($balance < 0) {
            $user->decrement('reputation');
        } else {
            $user->increment('reputation');
        }

        $colocation->users()->updateExistingPivot($user->id, [
            'left_at' => now()
        ]);

        return redirect()->route('dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL (Owner annule)
    |--------------------------------------------------------------------------
    */

    public function cancel(Colocation $colocation)
    {
        $user = Auth::user();

        $membership = $colocation->users()
            ->where('user_id', $user->id)
            ->first();

        if (!$membership || $membership->pivot->role !== 'owner') {
            abort(403);
        }

        $colocation->update([
            'status' => 'cancelled'
        ]);

        foreach ($colocation->users as $member) {

            $balance = $this->calculateUserBalance($colocation, $member);

            if ($balance < 0) {
                $member->decrement('reputation');
            } else {
                $member->increment('reputation');
            }
        }

        return redirect()->route('dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | CALCUL BALANCES
    |--------------------------------------------------------------------------
    */

    private function calculateBalances(Colocation $colocation)
    {
        $balances = [];

        $members = $colocation->users()
            ->whereNull('left_at')
            ->get();

        $expenses = $colocation->expenses;

        $total = $expenses->sum('amount');
        $count = $members->count();

        if ($count === 0) {
            return [];
        }

        $share = $total / $count;

        foreach ($members as $member) {

            $paid = $expenses
                ->where('paid_by', $member->id)
                ->sum('amount');

            $balances[$member->id] = [
                'user' => $member,
                'balance' => $paid - $share
            ];
        }

        return $balances;
    }


    /*
    |--------------------------------------------------------------------------
    | CALCUL BALANCE INDIVIDUELLE
    |--------------------------------------------------------------------------
    */

    private function calculateUserBalance(Colocation $colocation, User $user)
    {
        $total = $colocation->expenses->sum('amount');

        $membersCount = $colocation->users()
            ->whereNull('left_at')
            ->count();

        if ($membersCount === 0) {
            return 0;
        }

        $share = $total / $membersCount;

        $paid = $colocation->expenses()
            ->where('paid_by', $user->id)
            ->sum('amount');

        return $paid - $share;
    }
}