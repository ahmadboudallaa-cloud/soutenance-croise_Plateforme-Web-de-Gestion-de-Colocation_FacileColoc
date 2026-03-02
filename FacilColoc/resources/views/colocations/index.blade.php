@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Mes colocations</h2>

    <a href="{{ route('colocations.create') }}"
       class="btn btn-primary mb-3">
        Nouvelle colocation
    </a>

    @if($colocations->count())
        <ul class="list-group">

            @foreach($colocations as $colocation)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('colocations.show',$colocation->id) }}">
                        {{ $colocation->name }}
                    </a>
                    @if($colocation->status === 'active')
                        <span class="badge bg-success">Active</span>
                    @elseif($colocation->status === 'inactive')
                        <span class="badge bg-secondary">Inactive</span>
                    @else
                        <span class="badge bg-danger">Annulée</span>
                    @endif
                </li>
            @endforeach

        </ul>
    @else
        <p>Aucune colocation.</p>
    @endif

</div>

@endsection
