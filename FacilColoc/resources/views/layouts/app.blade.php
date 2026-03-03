<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FacileColoc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Syne:wght@500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ["Manrope", "system-ui", "sans-serif"],
                        display: ["Syne", "system-ui", "sans-serif"],
                    },
                    colors: {
                        ink: "#0F172A",
                        muted: "#5B6472",
                        primary: "#2F6BFF",
                        secondary: "#22C55E",
                        surface: "#F7F8FB",
                        line: "#E6E8F0",
                    },
                    boxShadow: {
                        soft: "0 10px 30px rgba(15, 23, 42, 0.08)",
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface text-ink font-sans">

<div class="min-h-screen lg:flex">
    <aside class="hidden lg:flex lg:flex-col lg:w-64 bg-white border-r border-line px-5 py-6">
        <div class="flex items-center gap-2 mb-8">
            <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary font-bold flex items-center justify-center">FC</div>
            <div class="font-display text-lg">FacileColoc</div>
        </div>
        <nav class="space-y-2 text-sm">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Dashboard</a>
            <a href="{{ route('colocations.index') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Mes colocations</a>
            <a href="{{ route('colocations.create') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Créer une colocation</a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Mon profil</a>
            @auth
            @if(auth()->user()->isGlobalAdmin())
                <div class="pt-4 text-xs uppercase tracking-widest text-muted">Admin</div>
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Dashboard admin</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Utilisateurs</a>
            @endif
            @endauth
        </nav>
        @auth
        <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-6">
            @csrf
            <button class="w-full px-3 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50">Se déconnecter</button>
        </form>
        @endauth
    </aside>

    <div class="flex-1">
        <div class="lg:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-line">
            <div class="font-display">FacileColoc</div>
            <button class="px-3 py-2 rounded-xl border border-line" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">Menu</button>
        </div>

        <div id="mobileMenu" class="hidden lg:hidden bg-white border-b border-line px-4 py-3 space-y-2 text-sm">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Dashboard</a>
            <a href="{{ route('colocations.index') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Mes colocations</a>
            <a href="{{ route('colocations.create') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Créer une colocation</a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Mon profil</a>
            @auth
            @if(auth()->user()->isGlobalAdmin())
                <div class="pt-2 text-xs uppercase tracking-widest text-muted">Admin</div>
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Dashboard admin</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-xl hover:bg-surface">Utilisateurs</a>
            @endif
            @endauth
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full px-3 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50">Se déconnecter</button>
            </form>
            @endauth
        </div>

        <header class="px-6 pt-6">
            <div class="bg-white border border-line rounded-2xl px-4 py-3 shadow-soft flex items-center justify-between">
                <div class="text-sm text-muted">Gestion de colocation</div>
                @auth
                    <div class="text-sm font-medium">Connecté : {{ auth()->user()->name }}</div>
                @endauth
            </div>
        </header>

        <main class="px-6 py-6">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
