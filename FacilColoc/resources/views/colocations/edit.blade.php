@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Modifier la colocation</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('colocations.update', $colocation->id) }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $colocation->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description"
                      class="form-control"
                      rows="3">{{ old('description', $colocation->description) }}</textarea>
        </div>

        <button class="btn btn-primary">
            Enregistrer
        </button>

        <a href="{{ route('colocations.show', $colocation->id) }}"
           class="btn btn-secondary">
            Retour
        </a>

    </form>

</div>

@endsection
