@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h2 class="mb-1">{{ $colocation->name }}</h2>
            <div class="text-muted small">
                Statut :
                <span class="badge bg-success">Active</span>
            </div>
        </div>
        @if ($isOwner)
            <span class="badge bg-primary">Owner</span>
        @else
            <span class="badge bg-secondary">Member</span>
        @endif
    </div>

    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($isOwner)
        <form method="POST" action="{{ route('colocations.cancel', $colocation->id) }}" class="mb-3">
            @csrf
            @method('PATCH')
            <button class="btn btn-outline-danger">
                Annuler la colocation
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('colocations.leave', $colocation->id) }}" class="mb-3">
            @csrf
            <button class="btn btn-outline-secondary">
                Quitter la colocation
            </button>
        </form>
    @endif

    <h4>Membres</h4>
    <ul class="list-group">
        @foreach($members as $member)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $member->name }}</strong>
                    @if(($member->pivot->role ?? 'member') === 'owner')
                        <span class="badge bg-primary ms-2">Owner</span>
                    @else
                        <span class="badge bg-secondary ms-2">Member</span>
                    @endif
                    <span class="text-muted ms-2">Réputation : {{ $member->reputation ?? 0 }}</span>
                </div>
                @if ($isOwner && ($member->pivot->role ?? 'member') !== 'owner')
                    <form method="POST" action="{{ route('colocations.members.remove', [$colocation->id, $member->id]) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger">Retirer</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>

    <hr>

    @if ($isOwner)
        <h4>Invitations</h4>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('colocations.invite', $colocation->id) }}" class="mb-3">
            @csrf
            <div class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Email du membre</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-primary w-100">Envoyer l’invitation</button>
                </div>
            </div>
        </form>

        @if (session('invite_link'))
            <div class="alert alert-info">
                Lien d’invitation :
                <span class="ms-2">{{ session('invite_link') }}</span>
            </div>
        @endif

        @if ($invitations->count())
            <ul class="list-group mb-4">
                @foreach($invitations as $invitation)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            {{ $invitation->email }}
                            <span class="text-muted ms-2">{{ $invitation->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <span class="badge bg-warning text-dark">{{ $invitation->status }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-light">Aucune invitation en attente.</div>
        @endif

        <hr>
    @endif

    <h4>Dépenses</h4>

    <form method="GET" action="{{ route('colocations.show', $colocation->id) }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <label class="form-label">Mois</label>
            <input type="month" name="month" class="form-control" value="{{ $selectedMonth }}">
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button class="btn btn-outline-primary">Filtrer</button>
            <a href="{{ route('colocations.show', $colocation->id) }}" class="btn btn-outline-secondary">Réinitialiser</a>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('expenses.create',$colocation->id) }}"
           class="btn btn-primary">
            Ajouter dépense
        </a>
        <span class="text-muted">
            Total : {{ number_format($expenses->sum('amount'), 2) }} €
        </span>
    </div>

    <table class="table table-striped">
        <tr>
            <th>Titre</th>
            <th>Montant</th>
            <th>Date</th>
            <th>Payé par</th>
        </tr>

        @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->title }}</td>
                <td>{{ number_format($expense->amount,2) }} €</td>
                <td>{{ $expense->expense_date }}</td>
                <td>{{ $expense->payer->name ?? '-' }}</td>
            </tr>
        @endforeach
    </table>

    <hr>

    <h4>Qui doit à qui</h4>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @forelse($settlements as $s)
        <div class="alert alert-warning d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $s['from']->name }}</strong>
                doit payer
                <strong>{{ $s['to']->name }}</strong>
                :
                {{ number_format($s['amount'],2) }} €
            </div>

            <form method="POST" action="{{ route('payments.store') }}">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                <input type="hidden" name="payer_id" value="{{ $s['from']->id }}">
                <input type="hidden" name="receiver_id" value="{{ $s['to']->id }}">
                <input type="hidden" name="amount" value="{{ $s['amount'] }}">
                <button class="btn btn-success btn-sm">Marquer payé</button>
            </form>
        </div>
    @empty
        <div class="alert alert-success">
            Tout est équilibré
        </div>
    @endforelse

    <hr>

    <h4>Historique des paiements</h4>

    @if ($payments->count())
        <table class="table">
            <tr>
                <th>Date</th>
                <th>Payeur</th>
                <th>Bénéficiaire</th>
                <th>Montant</th>
            </tr>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $payment->payer->name ?? '-' }}</td>
                    <td>{{ $payment->receiver->name ?? '-' }}</td>
                    <td>{{ number_format($payment->amount,2) }} €</td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="alert alert-light">Aucun paiement enregistré.</div>
    @endif

</div>

@endsection
