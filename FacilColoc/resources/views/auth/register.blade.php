@extends('layouts.guest')

@section('content')

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold">Créer un compte</h1>
        <p class="text-sm text-muted mt-1">Rejoins FacileColoc en quelques secondes.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        @if (request('invitation_token'))
            <input type="hidden" name="invitation_token" value="{{ request('invitation_token') }}">
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Nom</label>
            <input id="name" type="text" name="name" class="w-full px-3 py-2 rounded-xl border border-line bg-white"
                   value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input id="email" type="email" name="email" class="w-full px-3 py-2 rounded-xl border border-line bg-white"
                   value="{{ old('email', request('email')) }}" required autocomplete="username">
            @error('email')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input id="password" type="password" name="password" class="w-full px-3 py-2 rounded-xl border border-line bg-white"
                   required autocomplete="new-password">
            @error('password')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="w-full px-3 py-2 rounded-xl border border-line bg-white"
                   required autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button class="w-full px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
            Créer le compte
        </button>

        <div class="text-center text-sm">
            <a href="{{ route('login', ['invitation_token' => request('invitation_token'), 'email' => request('email')]) }}" class="text-primary hover:underline">
                Déjà inscrit ? Se connecter
            </a>
        </div>
    </form>
</div>

@endsection
