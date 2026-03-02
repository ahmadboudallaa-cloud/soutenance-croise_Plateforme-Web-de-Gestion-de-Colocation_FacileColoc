<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FacileColoc</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            EasyColoc
        </a>

        <div class="ms-auto">

            @auth

                <span class="text-white me-3">
                    {{ auth()->user()->name }}
                </span>

                <a href="{{ route('dashboard') }}"
                   class="btn btn-outline-light btn-sm me-2">
                    Dashboard
                </a>

              @if(auth()->user()->isGlobalAdmin())
    <a href="{{ route('admin.dashboard') }}"
       class="btn btn-warning btn-sm me-2">
        Admin
    </a>
@endif

                <form method="POST"
                      action="{{ route('logout') }}"
                      class="d-inline">
                    @csrf
                    <button type="submit"
                            class="btn btn-danger btn-sm">
                        Logout
                    </button>
                </form>

            @endauth

            @guest
                <a href="{{ route('login') }}"
                   class="btn btn-outline-light btn-sm me-2">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="btn btn-success btn-sm">
                    Register
                </a>
            @endguest

        </div>

    </div>
</nav>>

<div class="py-4">
    @yield('content')
</div>

</body>
</html>