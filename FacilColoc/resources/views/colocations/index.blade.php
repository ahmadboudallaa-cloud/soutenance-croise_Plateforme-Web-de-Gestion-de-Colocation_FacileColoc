@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Mes colocations</h2>
            <p class="text-sm text-muted">Gérez et consultez vos colocations.</p>
        </div>
        <a href="{{ route('colocations.create') }}" class="px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
            + Nouvelle colocation
        </a>
    </div>

    @if($colocations->count())
        <div class="bg-white border border-line rounded-2xl shadow-soft overflow-hidden">
            <div class="divide-y divide-line">
                @foreach($colocations as $colocation)
                    <a href="{{ route('colocations.show',$colocation->id) }}" class="flex items-center justify-between px-4 py-4 hover:bg-surface transition">
                        <div>
                            <div class="font-medium">{{ $colocation->name }}</div>
                            <div class="text-xs text-muted">Accéder à la colocation</div>
                        </div>
                        <div>
                            @if($colocation->status === 'active')
                                <span class="text-xs px-2 py-1 rounded-full bg-secondary/10 text-secondary">Active</span>
                            @elseif($colocation->status === 'inactive')
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-muted">Inactive</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-red-50 text-red-600">Annulée</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white border border-line rounded-2xl p-6 text-center text-muted shadow-soft">
            Aucune colocation.
        </div>
    @endif
</div>

@endsection
