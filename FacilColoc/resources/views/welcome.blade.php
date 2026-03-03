<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FacileColoc — Gestion moderne de colocation</title>
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

<header class="sticky top-0 z-50 bg-white/80 backdrop-blur border-b border-line">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary font-bold flex items-center justify-center">FC</div>
            <div class="font-display text-xl">FacileColoc</div>
        </div>
        <nav class="hidden md:flex items-center gap-6 text-sm text-muted">
            <a href="#features" class="hover:text-ink transition">Fonctionnalités</a>
            <a href="#dashboard" class="hover:text-ink transition">Dashboard</a>
            <a href="#advantages" class="hover:text-ink transition">Avantages</a>
        </nav>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm text-muted hover:text-ink transition">Connexion</a>
            <a href="{{ route('register') }}" class="text-sm px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
                Créer un compte
            </a>
        </div>
    </div>
</header>

<section class="max-w-7xl mx-auto px-6 pt-16 pb-20 grid lg:grid-cols-2 gap-10 items-center">
    <div>
        <div class="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-primary bg-primary/10 px-3 py-1 rounded-full mb-4">
            Gestion moderne de colocation
        </div>
        <h1 class="font-display text-4xl md:text-5xl leading-tight mb-4">
            La gestion des dépenses entre colocataires, enfin simple et élégante.
        </h1>
        <p class="text-muted text-lg mb-6">
            FacilColoc calcule automatiquement les soldes, suit les paiements et vous montre
            clairement « qui doit quoi à qui ».
        </p>
        <div class="flex gap-3">
            <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-primary text-white shadow-soft hover:bg-primary/90 transition">
                Commencer gratuitement
            </a>
            <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl border border-line hover:bg-white transition">
                Se connecter
            </a>
        </div>
    </div>
    <div class="bg-white border border-line rounded-3xl p-6 shadow-soft">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 rounded-2xl bg-surface">
                <div class="text-xs text-muted">Solde</div>
                <div class="text-2xl font-semibold text-primary">+ 124 €</div>
            </div>
            <div class="p-4 rounded-2xl bg-surface">
                <div class="text-xs text-muted">Dépenses</div>
                <div class="text-2xl font-semibold">1 430 €</div>
            </div>
            <div class="col-span-2 p-4 rounded-2xl border border-line">
                <div class="text-xs text-muted mb-2">Qui doit à qui</div>
                <div class="flex items-center justify-between text-sm">
                    <span>Mouad → Ahmed</span>
                    <span class="font-semibold text-primary">48 €</span>
                </div>
                <div class="flex items-center justify-between text-sm mt-2">
                    <span>Inès → Yassin</span>
                    <span class="font-semibold text-primary">32 €</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="features" class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-10">
        <h2 class="font-display text-3xl mb-2">Fonctionnalités clés</h2>
        <p class="text-muted">Pensé pour une colocation claire, simple et transparente.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-line p-6 shadow-soft">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">€</div>
            <h3 class="font-semibold mb-2">Dépenses partagées</h3>
            <p class="text-muted text-sm">Ajoutez, modifiez et suivez toutes les dépenses communes.</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-6 shadow-soft">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">↔</div>
            <h3 class="font-semibold mb-2">Remboursements simplifiés</h3>
            <p class="text-muted text-sm">Un clic pour marquer un paiement et équilibrer les dettes.</p>
        </div>
        <div class="bg-white rounded-2xl border border-line p-6 shadow-soft">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-4">👥</div>
            <h3 class="font-semibold mb-2">Gestion des membres</h3>
            <p class="text-muted text-sm">Invitations, rôles et historique clair.</p>
        </div>
    </div>
</section>

<section id="dashboard" class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-10">
        <h2 class="font-display text-3xl mb-2">Dashboard élégant</h2>
        <p class="text-muted">Une vue claire de vos soldes et de vos statistiques.</p>
    </div>
    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-line p-6 shadow-soft">
            <div class="text-xs text-muted">Solde global</div>
            <div class="text-3xl font-semibold text-primary">+ 214 €</div>
        </div>
        <div class="bg-white rounded-2xl border border-line p-6 shadow-soft">
            <div class="text-xs text-muted">Dépenses mensuelles</div>
            <div class="text-3xl font-semibold">1 080 €</div>
        </div>
        <div class="bg-white rounded-2xl border border-line p-6 shadow-soft">
            <div class="text-xs text-muted">Paiements en attente</div>
            <div class="text-3xl font-semibold">3</div>
        </div>
    </div>
</section>

<section id="advantages" class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid md:grid-cols-2 gap-8 items-center">
        <div>
            <h2 class="font-display text-3xl mb-3">Pourquoi FacileColoc ?</h2>
            <p class="text-muted mb-4">
                Une expérience fluide, moderne et pensée pour des colocations actives.
            </p>
            <ul class="space-y-2 text-sm text-muted">
                <li>✔ Calcul automatique des soldes</li>
                <li>✔ Interface claire et minimaliste</li>
                <li>✔ Historique complet des dépenses</li>
                <li>✔ Paiements suivis en temps réel</li>
            </ul>
        </div>
        <div class="bg-white rounded-2xl border border-line p-6 shadow-soft">
            <div class="text-xs text-muted mb-2">Témoignage</div>
            <div class="text-lg font-semibold">“On a enfin arrêté de se prendre la tête.”</div>
            <div class="text-muted text-sm mt-2">— Sarah, Paris</div>
        </div>
    </div>
</section>

<footer class="border-t border-line">
    <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="font-display text-lg">FacileColoc</div>
        <div class="text-sm text-muted">© 2026 FacileColoc. Tous droits réservés.</div>
        <div class="flex gap-4 text-sm text-muted">
            <a href="#" class="hover:text-ink">Mentions</a>
            <a href="#" class="hover:text-ink">Confidentialité</a>
            <a href="#" class="hover:text-ink">Contact</a>
        </div>
    </div>
</footer>

</body>
</html>
