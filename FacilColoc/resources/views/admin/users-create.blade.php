@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white border border-line rounded-2xl p-6 shadow-soft">
        <h2 class="text-2xl font-semibold mb-2">Créer un compte</h2>
        <p class="text-sm text-muted mb-6">Ajoutez un nouvel utilisateur.</p>

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nom</label>
                <input type="text" name="name" class="w-full px-3 py-2 rounded-xl border border-line bg-white" value="{{ old('name') }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 rounded-xl border border-line bg-white" value="{{ old('email') }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Mot de passe</label>
                <input type="password" name="password" class="w-full px-3 py-2 rounded-xl border border-line bg-white" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="w-full px-3 py-2 rounded-xl border border-line bg-white" required>
            </div>

            <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_global_admin" value="1" class="rounded border-line">
                Admin global
            </label>

            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">Créer</button>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-xl border border-line hover:bg-surface">Retour</a>
            </div>
        </form>
    </div>
</div>

@endsection
