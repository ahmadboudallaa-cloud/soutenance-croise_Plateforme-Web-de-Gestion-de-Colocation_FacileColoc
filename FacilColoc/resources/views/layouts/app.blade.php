<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FacileColoc</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Syne:wght@500;600;700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --bg: #f5f7fb;
            --panel: #ffffff;
            --panel-2: #f3f6fb;
            --card: #ffffff;
            --border: #e5e9f2;
            --text: #0f172a;
            --muted: #5b6472;
            --accent: #1dd675;
            --accent-2: #4cc9ff;
            --danger: #ef4444;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Manrope", system-ui, -apple-system, sans-serif;
            color: var(--text);
            background:
                radial-gradient(1200px 600px at 15% -20%, #dfe7f3 0%, transparent 60%),
                radial-gradient(800px 500px at 85% -10%, #e8f3e8 0%, transparent 55%),
                var(--bg);
            min-height: 100vh;
        }

        .app-shell {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--panel), var(--panel-2));
            border-right: 1px solid var(--border);
            padding: 22px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .brand {
            font-family: "Syne", sans-serif;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 1.4rem;
            color: var(--text);
        }

        .nav-label {
            color: var(--muted);
            font-size: 0.72rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin: 18px 0 10px;
        }

        .nav-link {
            color: var(--text);
            border-radius: 12px;
            padding: 10px 12px;
            margin-bottom: 6px;
            background: transparent;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #eef2f7;
            color: var(--text);
        }

        .content {
            padding: 24px 28px 36px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 16px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            margin-bottom: 18px;
        }

        .pill {
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(29, 214, 117, 0.15);
            color: #0f172a;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            color: var(--text);
        }

        .btn-accent {
            background: var(--accent);
            border: none;
            color: #0f172a;
            font-weight: 700;
        }

        .btn-accent:hover {
            background: #17c26b;
            color: #0f172a;
        }

        .btn-outline-danger {
            border-color: var(--danger);
            color: var(--danger);
        }

        .table {
            color: var(--text);
        }

        .table > :not(caption) > * > * {
            background: transparent;
            border-bottom-color: var(--border);
        }

        /* Mobile */
        .mobile-bar {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            background: var(--panel);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .drawer {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(3, 6, 10, 0.6);
            z-index: 30;
        }

        .drawer.open { display: block; }

        .drawer-panel {
            width: 78%;
            max-width: 320px;
            height: 100%;
            background: linear-gradient(180deg, var(--panel), var(--panel-2));
            border-right: 1px solid var(--border);
            padding: 20px;
        }

        @media (max-width: 992px) {
            .app-shell {
                grid-template-columns: 1fr;
            }
            .sidebar {
                display: none;
            }
            .mobile-bar { display: flex; }
        }
    </style>
</head>

<body>

<div class="mobile-bar">
    <button class="btn btn-outline-light btn-sm" onclick="toggleDrawer()">Menu</button>
    <div class="brand">FacileColoc</div>
    <div></div>
</div>

<div class="drawer" id="drawer" onclick="toggleDrawer()">
    <div class="drawer-panel" onclick="event.stopPropagation()">
        <div class="brand mb-3">FacileColoc</div>
        <div class="nav-label">Navigation</div>
        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('colocations.index') }}">Mes colocations</a>
        <a class="nav-link" href="{{ route('colocations.create') }}">Créer une colocation</a>
        <a class="nav-link" href="{{ route('profile.edit') }}">Mon profil</a>

        @auth
            @if(auth()->user()->isGlobalAdmin())
                <div class="nav-label">Admin</div>
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard admin</a>
                <a class="nav-link" href="{{ route('admin.users.index') }}">Utilisateurs</a>
            @endif
        @endauth

        @auth
            <div class="nav-label">Compte</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 mt-2">
                    Se déconnecter
                </button>
            </form>
        @endauth
    </div>
</div>

<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">FacileColoc</div>

        <div class="nav-label">Navigation</div>
        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('colocations.index') }}">Mes colocations</a>
        <a class="nav-link" href="{{ route('colocations.create') }}">Créer une colocation</a>
        <a class="nav-link" href="{{ route('profile.edit') }}">Mon profil</a>

        @auth
            @if(auth()->user()->isGlobalAdmin())
                <div class="nav-label">Admin</div>
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard admin</a>
                <a class="nav-link" href="{{ route('admin.users.index') }}">Utilisateurs</a>
            @endif
        @endauth

        @auth
            <div class="nav-label">Compte</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 mt-2">
                    Se déconnecter
                </button>
            </form>
        @endauth
    </aside>

    <main class="content">
        <div class="topbar">
            <div>
                @auth
                    <span class="pill">Connecté : {{ auth()->user()->name }}</span>
                @endauth
            </div>
            <div class="text-muted">FacileColoc • Gestion de colocation</div>
        </div>

        @yield('content')
    </main>
</div>

<script>
    function toggleDrawer() {
        const drawer = document.getElementById('drawer');
        drawer.classList.toggle('open');
    }
</script>

</body>
</html>
