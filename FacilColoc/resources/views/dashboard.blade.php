@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0">Mes colocations</h2>
        <a href="{{ route('colocations.create') }}" class="btn btn-accent">
            + Créer une colocation
        </a>
    </div>

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

    <div class="row g-3">
        @forelse($colocations as $colocation)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('colocations.show', $colocation) }}" class="text-decoration-none">
                    <div class="card p-3 h-100">
                        <div class="d-flex align-items-center justify-content-between">
                            <strong>{{ $colocation->name }}</strong>
                            @if($colocation->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($colocation->status === 'inactive')
                                <span class="badge bg-secondary">Inactive</span>
                            @else
                                <span class="badge bg-danger">Annulée</span>
                            @endif
                        </div>
                        <div class="text-muted small mt-2">
                            Accéder à la colocation
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-4 text-center">
                    <div class="text-muted">Vous n'avez encore aucune colocation.</div>
                </div>
            </div>
        @endforelse
    </div>

</div>

@endsection
