@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white border border-line rounded-2xl p-6 shadow-soft">
        <h3 class="text-2xl font-semibold mb-2">Nouvelle dépense</h3>
        <p class="text-sm text-muted mb-6">Ajoutez une dépense liée à cette colocation.</p>

        <form method="POST" action="{{ route('expenses.store', $colocation->id) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Titre</label>
                <input type="text" name="title" class="w-full px-3 py-2 rounded-xl border border-line bg-white" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Montant (€)</label>
                <input type="number" step="0.01" name="amount" class="w-full px-3 py-2 rounded-xl border border-line bg-white" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Date</label>
                <input type="date" name="expense_date" class="w-full px-3 py-2 rounded-xl border border-line bg-white" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Payé par</label>
                <select name="paid_by" class="w-full px-3 py-2 rounded-xl border border-line bg-white" required>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
                    Ajouter
                </button>
                <a href="{{ route('colocations.show', $colocation->id) }}"
                   class="px-4 py-2 rounded-xl border border-line hover:bg-surface">
                    Retour
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
