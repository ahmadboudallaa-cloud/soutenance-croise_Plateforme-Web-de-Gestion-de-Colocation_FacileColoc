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
                        ink: "#FFFFFF",
                        muted: "#FFFFFF",
                        primary: "#69140e",
                        secondary: "#69140e",
                        surface: "#69140e",
                        line: "#69140e",
                    },
                    boxShadow: {
                        soft: "0 10px 30px rgba(15, 23, 42, 0.08)",
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#0a0a0a] text-ink font-sans">

<div class="min-h-screen lg:flex">
    <aside class="hidden lg:flex lg:flex-col lg:w-64 bg-primary border-r border-line px-5 py-6 fixed inset-y-0 left-0">
        <div class="flex items-center gap-2 mb-8">
            <div class="w-9 h-9 rounded-xl bg-white text-black font-bold flex items-center justify-center">FC</div>
            <div class="font-display text-lg">FacileColoc</div>
        </div>
        <nav class="space-y-2 text-sm">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Dashboard</a>
            <a href="{{ route('colocations.index') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Mes colocations</a>
            <a href="{{ route('colocations.create') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Créer une colocation</a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Mon profil</a>
            @auth
            @if(auth()->user()->isGlobalAdmin())
                <div class="pt-4 text-xs uppercase tracking-widest text-white">Admin</div>
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Dashboard admin</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Utilisateurs</a>
            @endif
            @endauth
        </nav>
        @auth
        <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-6">
            @csrf
            <button class="w-full px-3 py-2 rounded-xl border border-white/30 text-white hover:bg-white/10">Se déconnecter</button>
        </form>
        @endauth
    </aside>

    <div class="flex-1 lg:ml-64">
        <div class="lg:hidden flex items-center justify-between px-4 py-3 bg-primary border-b border-line">
            <div class="font-display">FacileColoc</div>
            <button class="px-3 py-2 rounded-xl border border-line" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">Menu</button>
        </div>

        <div id="mobileMenu" class="hidden lg:hidden bg-primary border-b border-line px-4 py-3 space-y-2 text-sm">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Dashboard</a>
            <a href="{{ route('colocations.index') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Mes colocations</a>
            <a href="{{ route('colocations.create') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Créer une colocation</a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Mon profil</a>
            @auth
            @if(auth()->user()->isGlobalAdmin())
                <div class="pt-2 text-xs uppercase tracking-widest text-white">Admin</div>
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Dashboard admin</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-xl hover:bg-white/10">Utilisateurs</a>
            @endif
            @endauth
            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full px-3 py-2 rounded-xl border border-white/30 text-white hover:bg-white/10">Se déconnecter</button>
            </form>
            @endauth
        </div>

        <header class="px-6 pt-6">
            <div class="bg-primary border border-line rounded-2xl px-4 py-3 shadow-soft hover:shadow-lg transition flex items-center justify-between">
                <div class="text-sm text-white">Gestion de colocation</div>
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
