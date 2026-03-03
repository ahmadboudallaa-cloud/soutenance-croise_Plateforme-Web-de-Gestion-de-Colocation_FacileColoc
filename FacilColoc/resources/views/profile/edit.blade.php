@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">
    <div>
        <h2 class="text-2xl font-semibold">Mon profil</h2>
        <p class="text-sm text-white">Gérez vos informations et votre sécurité.</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-primary border border-line rounded-2xl p-6 shadow-soft hover:shadow-lg transition">
            <h3 class="font-semibold mb-2">Informations du profil</h3>
            <p class="text-sm text-white mb-4">Modifiez votre nom et votre email.</p>

            @if (session('status') === 'profile-updated')
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    Profil mis à jour.
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium mb-1">Nom</label>
                    <input type="text" name="name" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="text-white text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="text-white text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:shadow-lg transition hover:bg-primary/90 transition">
                    Enregistrer
                </button>
            </form>
        </div>

        <div class="bg-primary border border-line rounded-2xl p-6 shadow-soft hover:shadow-lg transition">
            <h3 class="font-semibold mb-2">Mot de passe</h3>
            <p class="text-sm text-white mb-4">Mettez à jour votre mot de passe.</p>

            @if (session('status') === 'password-updated')
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    Mot de passe mis à jour.
                </div>
            @endif

            @php($pwErrors = $errors->getBag('updatePassword'))

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium mb-1">Mot de passe actuel</label>
                    <input type="password" name="current_password" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
                    @if ($pwErrors->has('current_password'))
                        <div class="text-white text-sm mt-1">{{ $pwErrors->first('current_password') }}</div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Nouveau mot de passe</label>
                    <input type="password" name="password" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
                    @if ($pwErrors->has('password'))
                        <div class="text-white text-sm mt-1">{{ $pwErrors->first('password') }}</div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
                    @if ($pwErrors->has('password_confirmation'))
                        <div class="text-white text-sm mt-1">{{ $pwErrors->first('password_confirmation') }}</div>
                    @endif
                </div>

                <button class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:shadow-lg transition hover:bg-primary/90 transition">
                    Mettre à jour
                </button>
            </form>
        </div>
    </div>

    <div class="bg-primary border border-red-200 rounded-2xl p-6 shadow-soft hover:shadow-lg transition">
        <h3 class="font-semibold text-white mb-2">Supprimer le compte</h3>
        <p class="text-sm text-white mb-4">Cette action est irréversible.</p>

        @php($delErrors = $errors->getBag('userDeletion'))

        <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
            @csrf
            @method('DELETE')

            <div>
                <label class="block text-sm font-medium mb-1">Confirmer avec votre mot de passe</label>
                <input type="password" name="password" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" required>
                @if ($delErrors->has('password'))
                    <div class="text-white text-sm mt-1">{{ $delErrors->first('password') }}</div>
                @endif
            </div>

            <button class="px-4 py-2 rounded-xl border border-red-200 text-white hover:bg-red-50">
                Supprimer mon compte
            </button>
        </form>
    </div>
</div>

@endsection



