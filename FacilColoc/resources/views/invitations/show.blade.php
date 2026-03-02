@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h2>Invitation</h2>

    <div class="mb-3">
        <div><strong>Colocation :</strong> {{ $invitation->colocation->name }}</div>
        <div><strong>Invité :</strong> {{ $invitation->email }}</div>
        <div><strong>Statut :</strong> {{ $invitation->status }}</div>
    </div>

    @if ($invitation->status !== 'pending')
        <div class="alert alert-info">
            Cette invitation n’est plus active.
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Retour</a>
    @else
        @auth
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}">
                    @csrf
                    <button class="btn btn-success">Accepter</button>
                </form>

                <form method="POST" action="{{ route('invitations.decline', $invitation->token) }}">
                    @csrf
                    <button class="btn btn-outline-danger">Refuser</button>
                </form>
            </div>
        @endauth

        @guest
            @if ($hasAccount)
                <div class="alert alert-info">
                    Un compte existe déjà pour {{ $invitation->email }}. Connectez-vous pour accepter l’invitation.
                </div>
                <a class="btn btn-primary" href="{{ route('login', ['email' => $invitation->email, 'invitation_token' => $invitation->token]) }}">
                    Se connecter
                </a>
            @else
                <div class="alert alert-info">
                    Aucun compte n’existe pour {{ $invitation->email }}. Créez un compte pour accepter l’invitation.
                </div>
                <form method="POST" action="{{ route('register') }}" class="mt-3">
                    @csrf
                    <input type="hidden" name="invitation_token" value="{{ $invitation->token }}">

                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $invitation->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button class="btn btn-success">Créer le compte</button>
                </form>
            @endif
        @endguest
    @endif

</div>

@endsection
