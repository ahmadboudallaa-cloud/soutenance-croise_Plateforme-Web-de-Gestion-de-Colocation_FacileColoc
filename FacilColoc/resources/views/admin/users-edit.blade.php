@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Modifier un compte</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe (optionnel)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_global_admin" value="1" id="is_global_admin"
                   @checked(old('is_global_admin', $user->is_global_admin))>
            <label class="form-check-label" for="is_global_admin">
                Admin global
            </label>
        </div>

        <button class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Retour</a>
    </form>

</div>

@endsection
