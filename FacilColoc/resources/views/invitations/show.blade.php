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
    @endif

</div>

@endsection
