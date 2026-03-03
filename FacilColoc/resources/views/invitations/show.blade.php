@extends('layouts.guest')

@section('content')

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold">Invitation</h1>
        <p class="text-sm text-white mt-1">Rejoindre une colocation en toute simplicite.</p>
    </div>

    <div class="rounded-2xl border border-line bg-primary p-4 text-sm">
        <div><span class="text-white">Colocation :</span> <strong>{{ $invitation->colocation->name }}</strong></div>
        <div><span class="text-white">Invite :</span> <strong>{{ $invitation->email }}</strong></div>
        <div><span class="text-white">Statut :</span> <strong>{{ $invitation->status }}</strong></div>
    </div>

    @if ($invitation->status !== 'pending')
        <div class="rounded-xl border border-line bg-primary px-4 py-3 text-white">
            Cette invitation n est plus active.
        </div>
        <a href="{{ route('login') }}" class="inline-block px-4 py-2 rounded-xl border border-line hover:bg-primary">Retour</a>
    @else
        @auth
            <div class="flex gap-3">
                <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}">
                    @csrf
                    <button class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:shadow-lg transition hover:bg-primary/90">Accepter</button>
                </form>

                <form method="POST" action="{{ route('invitations.decline', $invitation->token) }}">
                    @csrf
                    <button class="px-4 py-2 rounded-xl border border-red-200 text-white hover:bg-red-50">Refuser</button>
                </form>
            </div>
        @endauth

        @guest
            @if ($hasAccount)
                <div class="rounded-xl border border-line bg-primary px-4 py-3 text-white">
                    Un compte existe deja pour {{ $invitation->email }}. Connectez-vous pour accepter l invitation.
                </div>
                <a class="inline-block mt-3 px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:shadow-lg transition hover:bg-primary/90"
                   href="{{ route('login', ['email' => $invitation->email, 'invitation_token' => $invitation->token]) }}">
                    Se connecter
                </a>
            @else
                <div class="rounded-xl border border-line bg-primary px-4 py-3 text-white">
                    Aucun compte n existe pour {{ $invitation->email }}. Creez un compte pour accepter l invitation.
                </div>
                <form method="POST" action="{{ route('register') }}" class="space-y-4 mt-4">
                    @csrf
                    <input type="hidden" name="invitation_token" value="{{ $invitation->token }}">

                    <div>
                        <label class="block text-sm font-medium mb-1">Nom</label>
                        <input type="text" name="name"
                               class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                               value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email"
                               class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                               value="{{ old('email', $invitation->email) }}" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Mot de passe</label>
                        <input type="password" name="password"
                               class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
                    </div>

                    <button class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:shadow-lg transition hover:bg-primary/90">
                        Creer le compte
                    </button>
                </form>
            @endif
        @endguest
    @endif
</div>

@endsection


