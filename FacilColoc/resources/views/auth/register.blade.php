@extends('layouts.guest')

@section('content')

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold">Créeer un compte</h1>
        <p class="text-sm text-white mt-1">Rejoins FacileColoc en quelques secondes.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        @if (request('invitation_token'))
            <input type="hidden" name="invitation_token" value="{{ request('invitation_token') }}">
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Nom</label>
            <input id="name" type="text" name="name"
                   class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                   value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-white text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input id="email" type="email" name="email"
                   class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                   value="{{ old('email', request('email')) }}" required autocomplete="username">
            @error('email')
                <div class="text-white text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input id="password" type="password" name="password"
                   class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                   required autocomplete="new-password">
            @error('password')
                <div class="text-white text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                   required autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-white text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button class="w-full px-4 py-2 rounded-xl bg-black text-white font-bold border border-white/20 hover:bg-white hover:text-black transition">
            Créer le compte
        </button>

        <div class="text-center text-sm">
            <a href="{{ route('login', ['invitation_token' => request('invitation_token'), 'email' => request('email')]) }}" class="text-white hover:underline">
                Déja inscrit ? Se connecter
            </a>
        </div>
    </form>
</div>

@endsection




