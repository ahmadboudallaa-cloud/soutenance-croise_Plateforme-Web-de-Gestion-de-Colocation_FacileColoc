@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3>Modifier la dépense</h3>

    <form method="POST" action="{{ route('expenses.update', [$colocation->id, $expense->id]) }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $expense->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Montant (€)</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $expense->amount) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Payé par</label>
            <select name="paid_by" class="form-select" required>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" @selected(old('paid_by', $expense->paid_by) == $member->id)>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Enregistrer
        </button>

        <a href="{{ route('colocations.show', $colocation->id) }}"
           class="btn btn-secondary">
            Retour
        </a>

    </form>

</div>

@endsection
