@extends('layouts.guest')

@section('content')

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold">Connexion</h1>
        <p class="text-sm text-white mt-1">AccÃ¨de Ã  ton espace FacileColoc.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        @if (request('invitation_token'))
            <input type="hidden" name="invitation_token" value="{{ request('invitation_token') }}">
        @endif

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input id="email" type="email" name="email"
                   class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                   value="{{ old('email', request('email')) }}" required autofocus autocomplete="username">
            @error('email')
                <div class="text-white text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Mot de passe</label>
            <input id="password" type="password" name="password"
                   class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                   required autocomplete="current-password">
            @error('password')
                <div class="text-white text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-line">
                Se souvenir de moi
            </label>
            @if (Route::has('password.request'))
                <a class="text-white hover:underline" href="{{ route('password.request') }}">Mot de passe oubliÃ© ?</a>
            @endif
        </div>

        <button class="w-full px-4 py-2 rounded-xl bg-black text-white font-bold border border-white/20 hover:bg-white hover:text-black transition">
            Se connecter
        </button>

        <div class="text-center text-sm">
            <a href="{{ route('register', ['invitation_token' => request('invitation_token'), 'email' => request('email')]) }}" class="text-white hover:underline">
                CrÃ©er un compte
            </a>
        </div>
    </form>
</div>

@endsection


