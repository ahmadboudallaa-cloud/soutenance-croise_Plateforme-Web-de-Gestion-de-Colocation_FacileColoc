@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold">Mes colocations</h2>
            <p class="text-sm text-white">Gérez et consultez vos colocations.</p>
        </div>
        <a href="{{ route('colocations.create') }}" class="px-4 py-2 rounded-xl bg-primary text-white shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition hover:bg-primary/90 transition">
            + Nouvelle colocation
        </a>
    </div>

    @if($colocations->count())
        <div class="bg-primary border border-line rounded-2xl shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition overflow-hidden">
            <div class="divide-y divide-line">
                @foreach($colocations as $colocation)
                    <a href="{{ route('colocations.show',$colocation->id) }}" class="flex items-center justify-between px-4 py-4 hover:bg-primary transition">
                        <div>
                            <div class="font-medium">{{ $colocation->name }}</div>
                            <div class="text-xs text-white">Accéder à la colocation</div>
                        </div>
                        <div>
                            @if($colocation->status === 'active')
                                <span class="text-xs px-2 py-1 rounded-full bg-secondary/10 text-secondary">Active</span>
                            @elseif($colocation->status === 'inactive')
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-white">Inactive</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-red-50 text-white">Annulée</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-primary border border-line rounded-2xl p-6 text-center text-white shadow-none hover:shadow-[0_0_40px_rgba(255,255,255,0.35)] transition">
            Aucune colocation.
        </div>
    @endif
</div>

@endsection
