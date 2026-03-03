@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-primary text-white border border-line rounded-2xl p-6 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
        <h3 class="text-2xl font-semibold mb-2">Nouvelle dÃ©pense</h3>
        <p class="text-sm text-white mb-6">Ajoutez une dÃ©pense liÃ©e Ã  cette colocation.</p>

        <form method="POST" action="{{ route('expenses.store', $colocation->id) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Titre</label>
                <input type="text" name="title" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Montant (â‚¬)</label>
                <input type="number" step="0.01" name="amount" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Date</label>
                <input type="date" name="expense_date" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">PayÃ© par</label>
                <select name="paid_by"  >
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-white text-black font-bold border border-line">
                    Ajouter
                </button>
                <a href="{{ route('colocations.show', $colocation->id) }}"
                   class="px-4 py-2 rounded-xl border border-white/30 text-white">
                    Retour
                </a>
            </div>
        </form>
    </div>
</div>

@endsection


