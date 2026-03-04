@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <div class="text-xs uppercase tracking-widest text-white">Administration</div>
            <h2 class="text-2xl font-semibold">Dashboard Admin</h2>
            <p class="text-sm text-white">Supervision globale de la plateforme.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl bg-white text-black font-bold border border-line">
                Gerer les utilisateurs
            </a>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 rounded-xl bg-white text-black font-bold border border-line">
                Creer un compte
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-primary border border-line rounded-2xl p-4 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
            <div class="text-xs text-white">Utilisateurs</div>
            <div class="text-2xl font-semibold">{{ $usersCount }}</div>
        </div>
        <div class="bg-primary border border-line rounded-2xl p-4 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
            <div class="text-xs text-white">Colocations</div>
            <div class="text-2xl font-semibold">{{ $colocationsCount }}</div>
        </div>
        <div class="bg-primary border border-line rounded-2xl p-4 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
            <div class="text-xs text-white">Depenses</div>
            <div class="text-2xl font-semibold">{{ $expensesCount }}</div>
        </div>
        <div class="bg-primary border border-line rounded-2xl p-4 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
            <div class="text-xs text-white">Utilisateurs bannis</div>
            <div class="text-2xl font-semibold">{{ $bannedCount }}</div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-primary border border-line rounded-2xl p-6 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
            <h3 class="font-semibold mb-4">Actions rapides</h3>
            <div class="grid md:grid-cols-3 gap-3">
                <a href="{{ route('admin.users.create') }}" class="px-4 py-3 rounded-xl border border-line bg-white text-black font-bold">
                    Creer un compte
                </a>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-3 rounded-xl border border-line bg-white text-black font-bold">
                    Gerer les comptes
                </a>
                <a href="{{ route('dashboard') }}" class="px-4 py-3 rounded-xl border border-line bg-white text-black font-bold">
                    Retour dashboard
                </a>
            </div>
        </div>
        <div class="bg-primary border border-line rounded-2xl p-6 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
            <h3 class="font-semibold mb-4">Etat plateforme</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span>Comptes actifs</span>
                    <span class="font-semibold">{{ $usersCount - $bannedCount }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Colocations creees</span>
                    <span class="font-semibold">{{ $colocationsCount }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Colocations actives</span>
                    <span class="font-semibold">{{ $activeColocationsCount }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Colocations inactives</span>
                    <span class="font-semibold">{{ $inactiveColocationsCount }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Depenses totales</span>
                    <span class="font-semibold">{{ $expensesCount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


