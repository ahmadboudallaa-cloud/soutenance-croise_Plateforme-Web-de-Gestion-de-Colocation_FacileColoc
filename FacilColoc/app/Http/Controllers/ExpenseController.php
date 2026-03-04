<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    private function getCategories()
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        if ($categories->isNotEmpty()) {
            return $categories;
        }

        $defaults = [
            'Alimentation',
            'Loyer',
            'Internet',
            'Transport',
            'Factures',
            'Autre',
        ];

        foreach ($defaults as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        return Category::query()
            ->orderBy('name')
            ->get();
    }

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

    
    public function create(Colocation $colocation)
    {
        $this->ensureMember($colocation);

        $members = $colocation->users()
            ->whereNull('left_at')
            ->get();

        $categories = $this->getCategories();

        return view('expenses.create', compact('colocation', 'members', 'categories'));
    }

    
    public function store(Request $request, Colocation $colocation)
    {
        $this->ensureMember($colocation);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'paid_by' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Expense::create([
            'colocation_id' => $colocation->id,
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'paid_by' => $request->paid_by,
            'category_id' => $request->category_id,
        ]);

        return redirect()
            ->route('colocations.show', $colocation->id)
            ->with('success', 'Dépense ajoutée.');
    }

    
    public function edit(Colocation $colocation, Expense $expense)
    {
        $this->ensureMember($colocation);
        $this->ensureExpenseBelongsToColocation($colocation, $expense);

        $members = $colocation->users()
            ->whereNull('left_at')
            ->get();

        $categories = $this->getCategories();

        return view('expenses.edit', compact('colocation', 'expense', 'members', 'categories'));
    }

    
    public function update(Request $request, Colocation $colocation, Expense $expense)
    {
        $this->ensureMember($colocation);
        $this->ensureExpenseBelongsToColocation($colocation, $expense);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'paid_by' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'paid_by' => $request->paid_by,
            'category_id' => $request->category_id,
        ]);

        return redirect()
            ->route('colocations.show', $colocation->id)
            ->with('success', 'Dépense modifiée.');
    }

    
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



