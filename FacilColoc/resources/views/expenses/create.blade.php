@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3>Nouvelle dépense</h3>

    <form method="POST" action="{{ route('expenses.store', $colocation->id) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Montant (€)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="expense_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Payé par</label>
            <select name="paid_by" class="form-select" required>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Ajouter
        </button>

        <a href="{{ route('colocations.show', $colocation->id) }}"
           class="btn btn-secondary">
            Retour
        </a>

    </form>

</div>

@endsection