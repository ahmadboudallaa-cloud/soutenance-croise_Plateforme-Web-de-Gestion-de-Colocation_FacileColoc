@extends('layouts.guest')

@section('content')

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold">Connexion</h1>
        <p class="text-sm text-muted mt-1">Accède à ton espace FacileColoc.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        @if (request('invitation_token'))
            <input type="hidden" name="invitation_token" value="{{ request('invitation_token') }}">
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input id="email" type="email" name="email"
                   class="w-full px-3 py-2 rounded-xl border border-line bg-white"
                   value="{{ old('email', request('email')) }}" required autofocus autocomplete="username">
            @error('email')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input id="password" type="password" name="password"
                   class="w-full px-3 py-2 rounded-xl border border-line bg-white"
                   required autocomplete="current-password">
            @error('password')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-line">
                Se souvenir de moi
            </label>
            @if (Route::has('password.request'))
                <a class="text-primary hover:underline" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            @endif
        </div>

        <button class="w-full px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
            Se connecter
        </button>

        <div class="text-center text-sm">
            <a href="{{ route('register', ['invitation_token' => request('invitation_token'), 'email' => request('email')]) }}" class="text-primary hover:underline">
                Créer un compte
            </a>
        </div>
    </form>
</div>

@endsection
