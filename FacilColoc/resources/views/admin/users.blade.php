@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Utilisateurs</h2>
            <p class="text-sm text-white">Gérez les comptes et les rôles.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:shadow-lg transition hover:bg-primary/90 transition">
            + Ajouter un compte
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-xl border border-red-200 bg-white px-4 py-3 text-red-600">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-primary border border-line rounded-2xl shadow-soft hover:shadow-lg transition overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-xs uppercase text-white border-b border-line">
                    <tr>
                        <th class="py-3 px-4 text-left">Nom</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Admin</th>
                        <th class="py-3 px-4 text-left">Statut</th>
                        <th class="py-3 px-4 text-left">Réputation</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @foreach($users as $user)
                        <tr>
                            <td class="py-3 px-4 font-medium">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                @if($user->is_global_admin)
                                    <span class="text-xs px-2 py-1 rounded-full bg-white text-black">Admin</span>
                                @else
                                    <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-black">User</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->isBanned())
                                    <span class="text-xs px-2 py-1 rounded-full bg-red-50 text-white">Banni</span>
                                @else
                                    <span class="text-xs px-2 py-1 rounded-full bg-secondary/10 text-secondary">Actif</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $user->reputation ?? 0 }}</td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex flex-wrap gap-2 justify-end">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="px-2 py-1 rounded-lg border border-line hover:bg-primary">Modifier</a>

                                    @if(!$user->is_global_admin)
                                        <form method="POST" action="{{ route('admin.users.promote', $user) }}">
                                            @csrf
                                            <button class="px-2 py-1 rounded-lg border border-line hover:bg-primary">Donner admin</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.demote', $user) }}">
                                            @csrf
                                            <button class="px-2 py-1 rounded-lg border border-line hover:bg-primary">Retirer admin</button>
                                        </form>
                                    @endif

                                    @if(!$user->isBanned())
                                        <form method="POST" action="{{ route('admin.users.ban',$user) }}">
                                            @csrf
                                            <button class="px-2 py-1 rounded-lg border border-red-200 text-white hover:bg-red-50">Bannir</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.unban',$user) }}">
                                            @csrf
                                            <button class="px-2 py-1 rounded-lg border border-line hover:bg-primary">Débannir</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 rounded-lg border border-red-200 text-white hover:bg-red-50">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


