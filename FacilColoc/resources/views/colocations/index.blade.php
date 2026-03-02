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
                <li class="list-group-item">

                    <a href="{{ route('colocations.show',$colocation->id) }}">
                        {{ $colocation->name }}
                    </a>

                </li>
            @endforeach

        </ul>
    @else
        <p>Aucune colocation.</p>
    @endif

</div>

@endsection