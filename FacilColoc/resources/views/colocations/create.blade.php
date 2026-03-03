@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white border border-line rounded-2xl p-6 shadow-soft">
        <h2 class="text-2xl font-semibold mb-2">Créer une colocation</h2>
        <p class="text-sm text-muted mb-6">Donnez un nom et une description à votre colocation.</p>

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('colocations.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nom</label>
                <input type="text" name="name" class="w-full px-3 py-2 rounded-xl border border-line bg-white"
                       value="{{ old('name') }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" class="w-full px-3 py-2 rounded-xl border border-line bg-white" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
                    Créer
                </button>
                <a href="{{ route('colocations.index') }}" class="px-4 py-2 rounded-xl border border-line hover:bg-surface">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
