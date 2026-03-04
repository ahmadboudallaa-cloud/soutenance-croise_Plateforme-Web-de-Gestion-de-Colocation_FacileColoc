@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-primary text-white border border-line rounded-2xl p-6 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
        <h3 class="text-2xl font-semibold mb-2">Modifier la depense</h3>
        <p class="text-sm text-white mb-6">Mettez a jour les informations de la depense.</p>

        <form method="POST" action="{{ route('expenses.update', [$colocation->id, $expense->id]) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium mb-1">Titre</label>
                <input type="text" name="title" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                       value="{{ old('title', $expense->title) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Montant (DH)</label>
                <input type="number" step="0.01" name="amount" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                       value="{{ old('amount', $expense->amount) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Date</label>
                <input type="date" name="expense_date" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                       value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Payeur</label>
                <select name="paid_by" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" @selected(old('paid_by', $expense->paid_by) == $member->id)>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Categorie</label>
                <select name="category_id" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500">
                    <option value="">Aucune categorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $expense->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-white text-black font-bold border border-line">
                    Enregistrer
                </button>
                <a href="{{ route('colocations.show', $colocation->id) }}" class="px-4 py-2 rounded-xl border border-white/30 text-white">
                    Retour
                </a>
            </div>
        </form>
    </div>
</div>

@endsection


