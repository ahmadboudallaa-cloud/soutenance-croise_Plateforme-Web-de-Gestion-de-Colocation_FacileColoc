@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Mes colocations</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('colocations.create') }}"
       class="btn btn-primary mb-3">
        + Créer une colocation
    </a>

    <div class="list-group">
        @forelse($colocations as $colocation)
            <a href="{{ route('colocations.show', $colocation) }}"
               class="list-group-item list-group-item-action">
                {{ $colocation->name }}
            </a>
        @empty
            <div class="alert alert-info mb-0">
                Vous n'avez encore aucune colocation.
            </div>
        @endforelse
    </div>

</div>

@endsection
