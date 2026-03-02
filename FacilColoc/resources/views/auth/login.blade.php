@extends('layouts.guest')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card p-4">
                <div class="mb-3">
                    <h2 class="mb-1">Connexion</h2>
                    <div class="text-muted">Accède à ton espace FacileColoc</div>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @if (request('invitation_token'))
                        <input type="hidden" name="invitation_token" value="{{ request('invitation_token') }}">
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email" type="email" name="email" class="form-control"
                               value="{{ old('email', request('email')) }}" required autofocus autocomplete="username">
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input id="password" type="password" name="password" class="form-control"
                               required autocomplete="current-password">
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none" href="{{ route('password.request') }}">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <button class="btn btn-accent w-100">Se connecter</button>

                    <div class="text-center mt-3">
                        <a href="{{ route('register', ['invitation_token' => request('invitation_token'), 'email' => request('email')]) }}">
                            Créer un compte
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
