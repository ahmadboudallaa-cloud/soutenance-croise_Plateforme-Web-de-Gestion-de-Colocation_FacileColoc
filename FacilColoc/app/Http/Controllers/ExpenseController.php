<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    private function ensureMember(Colocation $colocation): void
    {
        $isMember = $colocation->users()
            ->where('users.id', Auth::id())
            ->wherePivotNull('left_at')
            ->exists();

        if (!$isMember) {
            abort(403);
        }
    }

    private function ensureExpenseBelongsToColocation(Colocation $colocation, Expense $expense): void
    {
        if ($expense->colocation_id !== $colocation->id) {
            abort(404);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create(Colocation $colocation)
    {
        $this->ensureMember($colocation);

        $members = $colocation->users()
            ->whereNull('left_at')
            ->get();

        return view('expenses.create', compact('colocation', 'members'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Colocation $colocation)
    {
        $this->ensureMember($colocation);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'paid_by' => 'required|exists:users,id',
        ]);

        Expense::create([
            'colocation_id' => $colocation->id,
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'paid_by' => $request->paid_by,
        ]);

        return redirect()
            ->route('colocations.show', $colocation->id)
            ->with('success', 'Dépense ajoutée.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Colocation $colocation, Expense $expense)
    {
        $this->ensureMember($colocation);
        $this->ensureExpenseBelongsToColocation($colocation, $expense);

        $members = $colocation->users()
            ->whereNull('left_at')
            ->get();

        return view('expenses.edit', compact('colocation', 'expense', 'members'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Colocation $colocation, Expense $expense)
    {
        $this->ensureMember($colocation);
        $this->ensureExpenseBelongsToColocation($colocation, $expense);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'paid_by' => 'required|exists:users,id',
        ]);

        $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'paid_by' => $request->paid_by,
        ]);

        return redirect()
            ->route('colocations.show', $colocation->id)
            ->with('success', 'Dépense modifiée.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(Colocation $colocation, Expense $expense)
    {
        $this->ensureMember($colocation);
        $this->ensureExpenseBelongsToColocation($colocation, $expense);

        $expense->delete();

        return redirect()
            ->route('colocations.show', $colocation->id)
            ->with('success', 'Dépense supprimée.');
    }
}
