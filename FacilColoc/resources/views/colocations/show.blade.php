@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    <div class="bg-primary border border-line rounded-2xl p-5 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="text-sm text-white">Colocation</div>
            <h2 class="text-2xl font-semibold">{{ $colocation->name }}</h2>
            <div class="text-xs text-white mt-1">
                Statut :
                @if($colocation->status === 'active')
                    <span class="text-xs px-2 py-1 rounded-full bg-secondary/10 text-secondary">Active</span>
                @elseif($colocation->status === 'inactive')
                    <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-black">Inactive</span>
                @else
                    <span class="text-xs px-2 py-1 rounded-full bg-red-50 text-white">Annulée</span>
                @endif
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            @if ($isOwner)
                <a href="{{ route('colocations.edit', $colocation->id) }}" class="px-3 py-2 rounded-xl border border-line hover:bg-primary">Modifier</a>
                <form method="POST" action="{{ route('colocations.cancel', $colocation->id) }}">
                    @csrf
                    @method('PATCH')
                    <button class="px-3 py-2 rounded-xl border border-red-200 text-white hover:bg-red-50">Supprimer</button>
                </form>
            @else
                @if (!$isInactive)
                    <form method="POST" action="{{ route('colocations.leave', $colocation->id) }}">
                        @csrf
                        <button class="px-3 py-2 rounded-xl border border-line hover:bg-primary">Quitter</button>
                    </form>
                @endif
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-xl border border-red-200 bg-white px-4 py-3 text-red-600">
            {{ session('error') }}
        </div>
    @endif

    @if ($isInactive)
        <div class="rounded-xl border border-line bg-primary px-4 py-3 text-white">
            Colocation inactive : consultation de l’historique uniquement.
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-primary border border-line rounded-2xl p-5 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold">Membres</h3>
                <span class="text-xs text-white">{{ $members->count() }} membres</span>
            </div>
            <div class="space-y-3">
                @foreach($members as $member)
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-medium">{{ $member->name }}</div>
                            <div class="text-xs text-white">Réputation : {{ $member->reputation ?? 0 }}</div>
                        </div>
                        <div class="text-xs">
                            @if(($member->pivot->role ?? 'member') === 'owner')
                                <span class="px-2 py-1 rounded-full bg-white text-black">Owner</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-gray-100 text-black">Member</span>
                            @endif
                        </div>
                    </div>
                    @if ($isOwner && !$isInactive && ($member->pivot->role ?? 'member') !== 'owner')
                        <div class="flex gap-2 text-xs">
                            <form method="POST" action="{{ route('colocations.members.transfer', [$colocation->id, $member->id]) }}">
                                @csrf
                                <button class="px-2 py-1 rounded-lg border border-line hover:bg-primary">Transférer owner</button>
                            </form>
                            <form method="POST" action="{{ route('colocations.members.remove', [$colocation->id, $member->id]) }}">
                                @csrf
                                <button class="px-2 py-1 rounded-lg border border-red-200 text-white hover:bg-red-50">Retirer</button>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            @if ($isOwner && !$isInactive)
                <div class="bg-primary border border-line rounded-2xl p-5 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
                    <h3 class="font-semibold mb-3">Invitations</h3>

                    <form method="POST" action="{{ route('colocations.invite', $colocation->id) }}" class="flex flex-wrap gap-2 mb-4">
                        @csrf
                        <input type="email" name="email" placeholder="Email du membre"
                               class="flex-1 min-w-[240px] px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
                        <button class="px-4 py-2 rounded-xl bg-primary text-white shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition hover:bg-primary/90 transition">
                            Envoyer l’invitation
                        </button>
                    </form>

                    @if (session('invite_link'))
                        <div class="text-sm text-white mb-3">
                            Lien d’invitation : <span class="font-medium text-ink">{{ session('invite_link') }}</span>
                        </div>
                    @endif

                    @if ($invitations->count())
                        <div class="space-y-2">
                            @foreach($invitations as $invitation)
                                <div class="flex items-center justify-between border border-line rounded-xl px-4 py-3">
                                    <div>
                                        <div class="font-medium">{{ $invitation->email }}</div>
                                        <div class="text-xs text-white">{{ $invitation->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs px-2 py-1 rounded-full bg-yellow-50 text-yellow-700">{{ $invitation->status }}</span>
                                        <form method="POST" action="{{ route('colocations.invitations.destroy', [$colocation->id, $invitation->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-2 py-1 rounded-lg border border-red-200 text-white hover:bg-red-50">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-sm text-white">Aucune invitation en attente.</div>
                    @endif
                </div>
            @endif
            <div class="bg-primary border border-line rounded-2xl p-5 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">Dépenses</h3>
                    <div class="text-sm text-white">Total : {{ number_format($expenses->sum('amount'), 2) }} DH</div>
                </div>

                <form method="GET" action="{{ route('colocations.show', $colocation->id) }}" class="flex flex-wrap gap-2 mb-4">
                    <input type="month" name="month" class="px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" value="{{ $selectedMonth }}">
                    <button class="px-3 py-2 rounded-xl border border-line hover:bg-primary">Filtrer</button>
                    <a href="{{ route('colocations.show', $colocation->id) }}" class="px-3 py-2 rounded-xl border border-line hover:bg-primary">Réinitialiser</a>
                    @if(!$isInactive)
                        <a href="{{ route('expenses.create',$colocation->id) }}" class="ml-auto px-3 py-2 rounded-xl bg-primary text-white shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition hover:bg-primary/90 transition">
                            Ajouter une dépense
                        </a>
                    @endif
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-xs uppercase text-white">
                            <tr class="border-b border-line">
                                <th class="py-2 text-left">Titre</th>
                                <th class="py-2 text-left">Montant</th>
                                <th class="py-2 text-left">Categorie</th>
                                <th class="py-2 text-left">Date</th>
                                <th class="py-2 text-left">Payé par</th>
                                <th class="py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line">
                            @foreach($expenses as $expense)
                                <tr>
                                    <td class="py-3">{{ $expense->title }}</td>
                                    <td class="py-3">{{ number_format($expense->amount,2) }} DH</td>
                                    <td class="py-3">{{ $expense->category?->name ?? '-' }}</td>
                                    <td class="py-3">{{ $expense->expense_date }}</td>
                                    <td class="py-3">{{ $expense->payer->name ?? '-' }}</td>
                                    <td class="py-3 text-right">
                                        @if(!$isInactive)
                                            <a href="{{ route('expenses.edit', [$colocation->id, $expense->id]) }}" class="px-2 py-1 rounded-lg border border-line hover:bg-primary">Modifier</a>
                                            <form method="POST" action="{{ route('expenses.destroy', [$colocation->id, $expense->id]) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-2 py-1 rounded-lg border border-red-200 text-white hover:bg-red-50">Supprimer</button>
                                            </form>
                                        @else
                                            <span class="text-white">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-primary border border-line rounded-2xl p-5 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
                <h3 class="font-semibold mb-3">Qui doit à qui</h3>
                @if ($isInactive)
                    <div class="text-white">Colocation inactive : paiements désactivés.</div>
                @else
                    @forelse($settlements as $s)
                        <div class="flex items-center justify-between border border-line rounded-xl px-4 py-3 mb-2">
                            <div class="text-sm">
                                <strong>{{ $s['from']->name }}</strong> doit payer <strong>{{ $s['to']->name }}</strong>
                                — {{ number_format($s['amount'],2) }} DH
                            </div>
                            <form method="POST" action="{{ route('payments.store') }}" onsubmit="this.querySelector('button').disabled = true;">
                                @csrf
                                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                                <input type="hidden" name="payer_id" value="{{ $s['from']->id }}">
                                <input type="hidden" name="receiver_id" value="{{ $s['to']->id }}">
                                <input type="hidden" name="amount" value="{{ $s['amount'] }}">
                                <button class="px-3 py-2 rounded-xl bg-secondary text-white hover:bg-secondary/90">Marquer payé</button>
                            </form>
                        </div>
                    @empty
                        <div class="text-white">Tout est équilibré.</div>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>

@endsection




