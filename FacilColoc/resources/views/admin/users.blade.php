@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Gestion des utilisateurs</h2>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Statut</th>
                <th>Réputation</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        @foreach($users as $user)

            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>
                    @if($user->is_global_admin)
                        <span class="badge bg-primary">Admin</span>
                    @endif
                </td>

                <td>
                    @if($user->isBanned())
                        <span class="badge bg-danger">Banni</span>
                    @else
                        <span class="badge bg-success">Actif</span>
                    @endif
                </td>

                <td>{{ $user->reputation ?? 0 }}</td>

                <td>

                    @if(!$user->isBanned())

                        <form method="POST"
                              action="{{ route('admin.users.ban',$user) }}">
                            @csrf
                            <button class="btn btn-danger btn-sm">
                                Bannir
                            </button>
                        </form>

                    @else

                        <form method="POST"
                              action="{{ route('admin.users.unban',$user) }}">
                            @csrf
                            <button class="btn btn-success btn-sm">
                                Débannir
                            </button>
                        </form>

                    @endif

                </td>
            </tr>

        @endforeach

        </tbody>
    </table>

</div>

@endsection
