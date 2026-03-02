<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create(Colocation $colocation)
    {
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
}