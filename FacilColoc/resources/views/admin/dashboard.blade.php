@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">Admin Dashboard</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Utilisateurs</h5>
                    <h2>{{ $usersCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Colocations</h5>
                    <h2>{{ $colocationsCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Dépenses</h5>
                    <h2>{{ $expensesCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <h5>Utilisateurs bannis</h5>
                    <h2>{{ $bannedCount }}</h2>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark btn-sm">
                        Gérer les utilisateurs
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
