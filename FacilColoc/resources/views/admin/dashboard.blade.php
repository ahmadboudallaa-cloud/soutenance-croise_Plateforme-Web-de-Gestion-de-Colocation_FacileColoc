@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Dashboard Admin</h2>
            <p class="text-sm text-muted">Vue globale et contrôle des utilisateurs.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
            Gérer les utilisateurs
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white border border-line rounded-2xl p-4 shadow-soft">
            <div class="text-xs text-muted">Utilisateurs</div>
            <div class="text-2xl font-semibold">{{ $usersCount }}</div>
        </div>
        <div class="bg-white border border-line rounded-2xl p-4 shadow-soft">
            <div class="text-xs text-muted">Colocations</div>
            <div class="text-2xl font-semibold">{{ $colocationsCount }}</div>
        </div>
        <div class="bg-white border border-line rounded-2xl p-4 shadow-soft">
            <div class="text-xs text-muted">Dépenses</div>
            <div class="text-2xl font-semibold">{{ $expensesCount }}</div>
        </div>
        <div class="bg-white border border-line rounded-2xl p-4 shadow-soft">
            <div class="text-xs text-muted">Utilisateurs bannis</div>
            <div class="text-2xl font-semibold text-red-600">{{ $bannedCount }}</div>
        </div>
    </div>

    <div class="bg-white border border-line rounded-2xl p-5 shadow-soft">
        <h3 class="font-semibold mb-3">Actions rapides</h3>
        <div class="grid md:grid-cols-3 gap-3">
            <a href="{{ route('admin.users.create') }}" class="px-4 py-3 rounded-xl border border-line hover:bg-surface transition">
                Créer un compte
            </a>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-3 rounded-xl border border-line hover:bg-surface transition">
                Gérer les comptes
            </a>
            <a href="{{ route('dashboard') }}" class="px-4 py-3 rounded-xl border border-line hover:bg-surface transition">
                Revenir au dashboard
            </a>
        </div>
    </div>
</div>

@endsection
