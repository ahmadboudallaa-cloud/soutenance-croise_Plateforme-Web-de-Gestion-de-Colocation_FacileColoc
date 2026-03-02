@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h2 class="mb-1">{{ $colocation->name }}</h2>
            <div class="text-muted small">
                Statut :
                @if($colocation->status === 'active')
                    <span class="badge bg-success">Active</span>
                @elseif($colocation->status === 'inactive')
                    <span class="badge bg-secondary">Inactive</span>
                @else
                    <span class="badge bg-danger">Annulée</span>
                @endif
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
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route('colocations.edit', $colocation->id) }}"
               class="btn btn-outline-primary">
                Modifier la colocation
            </a>
            @if (!$isInactive)
                <form method="POST" action="{{ route('colocations.deactivate', $colocation->id) }}">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-outline-secondary">
                        Désactiver la colocation
                    </button>
                </form>
            @endif
            <form method="POST" action="{{ route('colocations.cancel', $colocation->id) }}">
                @csrf
                @method('PATCH')
                <button class="btn btn-outline-danger">
                    Supprimer la colocation
                </button>
            </form>
        </div>
    @else
        @if (!$isInactive)
            <form method="POST" action="{{ route('colocations.leave', $colocation->id) }}" class="mb-3">
                @csrf
                <button class="btn btn-outline-secondary">
                    Quitter la colocation
                </button>
            </form>
        @endif
    @endif

    @if ($isInactive)
        <div class="alert alert-info">
            Colocation inactive : consultation de l’historique uniquement. L’owner peut supprimer la colocation.
        </div>
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
                @if ($isOwner && !$isInactive && ($member->pivot->role ?? 'member') !== 'owner')
                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('colocations.members.transfer', [$colocation->id, $member->id]) }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary">Transférer owner</button>
                        </form>
                        <form method="POST" action="{{ route('colocations.members.remove', [$colocation->id, $member->id]) }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">Retirer</button>
                        </form>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>

    <hr>

    @if ($isOwner && !$isInactive)
        <h4>Invitations</h4>

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
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning text-dark">{{ $invitation->status }}</span>
                            <form method="POST" action="{{ route('colocations.invitations.destroy', [$colocation->id, $invitation->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    Supprimer
                                </button>
                            </form>
                        </div>
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
        @if (!$isInactive)
            <a href="{{ route('expenses.create',$colocation->id) }}"
               class="btn btn-primary">
                Ajouter dépense
            </a>
        @else
            <span class="text-muted">Lecture seule</span>
        @endif
        <span class="text-muted">
            Total : {{ number_format($expenses->sum('amount'), 2) }} €
        </span>
    </div>

    <div class="card p-3">
    <table class="table table-striped mb-0">
        <tr>
            <th>Titre</th>
            <th>Montant</th>
            <th>Date</th>
            <th>Payé par</th>
            <th class="text-end">Actions</th>
        </tr>

        @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->title }}</td>
                <td>{{ number_format($expense->amount,2) }} €</td>
                <td>{{ $expense->expense_date }}</td>
                <td>{{ $expense->payer->name ?? '-' }}</td>
                <td class="text-end">
                    @if(!$isInactive)
                        <a href="{{ route('expenses.edit', [$colocation->id, $expense->id]) }}"
                           class="btn btn-sm btn-outline-primary">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('expenses.destroy', [$colocation->id, $expense->id]) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                Supprimer
                            </button>
                        </form>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    </div>

    <hr>

    <h4>Qui doit à qui</h4>

    @if ($isInactive)
        <div class="alert alert-light">Colocation inactive : paiements désactivés.</div>
    @else
        @forelse($settlements as $s)
            <div class="alert alert-warning d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $s['from']->name }}</strong>
                    doit payer
                    <strong>{{ $s['to']->name }}</strong>
                    :
                    {{ number_format($s['amount'],2) }} €
                </div>

                <form method="POST" action="{{ route('payments.store') }}" onsubmit="this.querySelector('button').disabled = true;">
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
    @endif

    <hr>

    <h4>Historique des paiements</h4>

    @if ($payments->count())
        <div class="card p-3">
        <table class="table mb-0">
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
        </div>
    @else
        <div class="alert alert-light">Aucun paiement enregistré.</div>
    @endif

</div>

@endsection
