@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Créer une colocation</h2>

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

    <form method="POST" action="{{ route('colocations.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>

            <textarea name="description"
                      class="form-control"
                      rows="3">{{ old('description') }}</textarea>
        </div>

        <button class="btn btn-success">
            Créer
        </button>

    </form>

</div>

@endsection
