@extends('layouts.guest')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card p-4">
                <div class="mb-3">
                    <h2 class="mb-1">Créer un compte</h2>
                    <div class="text-muted">Rejoins EasyColoc en quelques secondes</div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    @if (request('invitation_token'))
                        <input type="hidden" name="invitation_token" value="{{ request('invitation_token') }}">
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input id="name" type="text" name="name" class="form-control"
                               value="{{ old('name') }}" required autofocus autocomplete="name">
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email" type="email" name="email" class="form-control"
                               value="{{ old('email', request('email')) }}" required autocomplete="username">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input id="password" type="password" name="password" class="form-control"
                               required autocomplete="new-password">
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                               required autocomplete="new-password">
                        @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-accent w-100">Créer le compte</button>

                    <div class="text-center mt-3">
                        <a href="{{ route('login', ['invitation_token' => request('invitation_token'), 'email' => request('email')]) }}">
                            Déjà inscrit ? Se connecter
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
