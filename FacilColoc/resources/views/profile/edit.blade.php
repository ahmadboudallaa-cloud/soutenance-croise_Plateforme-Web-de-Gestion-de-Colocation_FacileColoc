@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card p-4">
                <h3 class="mb-1">Informations du profil</h3>
                <div class="text-muted mb-3">Modifiez votre nom et votre email.</div>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success">Profil mis à jour.</div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-accent">Enregistrer</button>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card p-4">
                <h3 class="mb-1">Mot de passe</h3>
                <div class="text-muted mb-3">Mettez à jour votre mot de passe.</div>

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success">Mot de passe mis à jour.</div>
                @endif

                @php($pwErrors = $errors->getBag('updatePassword'))

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-control" required>
                        @if ($pwErrors->has('current_password'))
                            <div class="text-danger small mt-1">{{ $pwErrors->first('current_password') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                        @if ($pwErrors->has('password'))
                            <div class="text-danger small mt-1">{{ $pwErrors->first('password') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                        @if ($pwErrors->has('password_confirmation'))
                            <div class="text-danger small mt-1">{{ $pwErrors->first('password_confirmation') }}</div>
                        @endif
                    </div>

                    <button class="btn btn-accent">Mettre à jour</button>
                </form>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card p-4 border border-danger">
                <h3 class="mb-1 text-danger">Supprimer le compte</h3>
                <div class="text-muted mb-3">Cette action est irréversible.</div>

                @php($delErrors = $errors->getBag('userDeletion'))

                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <label class="form-label">Confirmer avec votre mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                        @if ($delErrors->has('password'))
                            <div class="text-danger small mt-1">{{ $delErrors->first('password') }}</div>
                        @endif
                    </div>

                    <button class="btn btn-outline-danger">Supprimer mon compte</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
