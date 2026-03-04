@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-primary text-white border border-line rounded-2xl p-6 shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
        <h2 class="text-2xl font-semibold mb-2">Modifier la colocation</h2>
        <p class="text-sm text-white mb-6">Mettez a jour le nom et la description.</p>

        @if (session('error'))
            <div class="mb-4 rounded-xl border border-red-200 bg-white px-4 py-3 text-red-600">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-white px-4 py-3 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('colocations.update', $colocation->id) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium mb-1">Nom</label>
                <input type="text" name="name" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500"
                       value="{{ old('name', $colocation->name) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" class="w-full px-3 py-2 rounded-xl border border-line bg-white text-black placeholder-gray-500" rows="4">{{ old('description', $colocation->description) }}</textarea>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-xl bg-white text-black font-bold border border-line">
                    Enregistrer
                </button>
                <a href="{{ route('colocations.show', $colocation->id) }}" class="px-4 py-2 rounded-xl border border-white/30 text-white">
                    Retour
                </a>
            </div>
        </form>
    </div>
</div>

@endsection


