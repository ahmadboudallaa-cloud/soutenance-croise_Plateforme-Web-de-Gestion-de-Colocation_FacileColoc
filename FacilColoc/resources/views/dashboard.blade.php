@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold">Dashboard</h2>
            <p class="text-sm text-muted">Vue d’ensemble de vos colocations.</p>
        </div>
        <a href="{{ route('colocations.create') }}" class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
            + Créer une colocation
        </a>
    </div>

    @if (session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-line rounded-2xl p-4 shadow-soft">
            <div class="text-xs text-muted">Colocations actives</div>
            <div class="text-2xl font-semibold">{{ $colocations->where('status','active')->count() }}</div>
        </div>
        <div class="bg-white border border-line rounded-2xl p-4 shadow-soft">
            <div class="text-xs text-muted">Colocations inactives</div>
            <div class="text-2xl font-semibold">{{ $colocations->where('status','inactive')->count() }}</div>
        </div>
        <div class="bg-white border border-line rounded-2xl p-4 shadow-soft">
            <div class="text-xs text-muted">Total</div>
            <div class="text-2xl font-semibold">{{ $colocations->count() }}</div>
        </div>
    </div>

    <div class="bg-white border border-line rounded-2xl shadow-soft overflow-hidden">
        <div class="px-4 py-3 border-b border-line flex items-center justify-between">
            <div class="font-semibold">Mes colocations</div>
            <div class="text-xs text-muted">Dernière mise à jour</div>
        </div>
        <div class="divide-y divide-line">
            @forelse($colocations as $colocation)
                <a href="{{ route('colocations.show', $colocation) }}" class="flex items-center justify-between px-4 py-4 hover:bg-surface transition">
                    <div>
                        <div class="font-medium">{{ $colocation->name }}</div>
                        <div class="text-xs text-muted">Accéder à la colocation</div>
                    </div>
                    <div>
                        @if($colocation->status === 'active')
                            <span class="text-xs px-2 py-1 rounded-full bg-secondary/10 text-secondary">Active</span>
                        @elseif($colocation->status === 'inactive')
                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-muted">Inactive</span>
                        @else
                            <span class="text-xs px-2 py-1 rounded-full bg-red-50 text-red-600">Annulée</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="px-4 py-10 text-center text-muted">Vous n'avez encore aucune colocation.</div>
            @endforelse
        </div>
    </div>
</div>

@endsection
