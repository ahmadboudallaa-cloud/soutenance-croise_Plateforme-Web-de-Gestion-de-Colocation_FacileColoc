<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FacileColoc - Gestion de colocation</title>
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
                        surface: "#69140e",
                        line: "#69140e",
                    },
                    boxShadow: {
                        soft: "0 10px 30px rgba(0, 0, 0, 0.25)",
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#0a0a0a] text-ink font-sans">

<header class="sticky top-0 z-50 bg-[#0a0a0a]/80 backdrop-blur border-b border-line">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-xl bg-white text-black font-bold flex items-center justify-center">FC</div>
            <div class="font-display text-xl">FacileColoc</div>
        </div>
        <nav class="hidden md:flex items-center gap-6 text-sm text-white">
            <a href="#features" class="hover:text-ink transition">Fonctionnalites</a>
            <a href="#advantages" class="hover:text-ink transition">Avantages</a>
            <a href="#testimonials" class="hover:text-ink transition">Temoignages</a>
        </nav>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm text-white hover:text-ink transition">Connexion</a>
            <a href="{{ route('register') }}" class="text-sm px-4 py-2 rounded-xl bg-primary text-white shadow-soft hover:shadow-lg transition hover:bg-primary/90">
                Creer un compte
            </a>
        </div>
    </div>
</header>

<section class="max-w-7xl mx-auto px-6 pt-16 pb-20 grid lg:grid-cols-2 gap-10 items-center">
    <div>
        <div class="inline-flex items-center gap-2 text-xs uppercase tracking-widest text-black bg-white px-3 py-1 rounded-full mb-4">
            Gestion moderne de colocation
        </div>
        <h1 class="font-display text-4xl md:text-5xl leading-tight mb-4">
            Des depenses partagees claires, des remboursements simples.
        </h1>
        <p class="text-white text-lg mb-6">
            FacileColoc vous aide a suivre les depenses, calculer les soldes et savoir rapidement
            qui doit quoi a qui.
        </p>
        <div class="flex gap-3">
            <a href="{{ route('register') }}" class="px-5 py-3 rounded-xl bg-primary text-white shadow-soft hover:shadow-lg transition hover:bg-primary/90">
                Commencer gratuitement
            </a>
            <a href="{{ route('login') }}" class="px-5 py-3 rounded-xl border border-line hover:bg-primary transition">
                Se connecter
            </a>
        </div>
    </div>
    <div class="bg-primary border border-line rounded-3xl p-6 shadow-soft hover:shadow-lg transition">
        <div class="space-y-4">
            <div class="p-4 rounded-2xl bg-primary border border-line">
                <div class="text-xs text-white">Vue rapide</div>
                <div class="text-lg font-semibold">Soldes, depenses, paiements.</div>
            </div>
            <div class="p-4 rounded-2xl bg-primary border border-line">
                <div class="text-xs text-white">Automatique</div>
                <div class="text-lg font-semibold">Calcul des soldes et simplification des dettes.</div>
            </div>
            <div class="p-4 rounded-2xl bg-primary border border-line">
                <div class="text-xs text-white">Equipe</div>
                <div class="text-lg font-semibold">Invitations, roles Owner et Member.</div>
            </div>
        </div>
    </div>
</section>

<section id="features" class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-10">
        <h2 class="font-display text-3xl mb-2">Fonctionnalites cles</h2>
        <p class="text-white">Tout ce qu il faut pour une colocation bien geree.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-primary rounded-2xl border border-line p-6 shadow-soft hover:shadow-lg transition">
            <div class="w-10 h-10 rounded-xl bg-white text-black flex items-center justify-center mb-4">1</div>
            <h3 class="font-semibold mb-2">Depenses partagees</h3>
            <p class="text-white text-sm">Ajoutez, modifiez et suivez les depenses communes.</p>
        </div>
        <div class="bg-primary rounded-2xl border border-line p-6 shadow-soft hover:shadow-lg transition">
            <div class="w-10 h-10 rounded-xl bg-white text-black flex items-center justify-center mb-4">2</div>
            <h3 class="font-semibold mb-2">Soldes automatiques</h3>
            <p class="text-white text-sm">Calcul instantane des soldes et des remboursements.</p>
        </div>
        <div class="bg-primary rounded-2xl border border-line p-6 shadow-soft hover:shadow-lg transition">
            <div class="w-10 h-10 rounded-xl bg-white text-black flex items-center justify-center mb-4">3</div>
            <h3 class="font-semibold mb-2">Paiements simples</h3>
            <p class="text-white text-sm">Marquez un paiement et mettez a jour les dettes.</p>
        </div>
    </div>
</section>

<section id="advantages" class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid md:grid-cols-2 gap-8 items-center">
        <div>
            <h2 class="font-display text-3xl mb-3">Pourquoi FacileColoc ?</h2>
            <p class="text-white mb-4">
                Une experience fluide, moderne et pensee pour des colocations actives.
            </p>
            <ul class="space-y-2 text-sm text-white">
                <li>Calcul automatique des soldes</li>
                <li>Interface claire et minimaliste</li>
                <li>Historique complet des depenses</li>
                <li>Paiements suivis en temps reel</li>
            </ul>
        </div>
        <div class="bg-primary rounded-2xl border border-line p-6 shadow-soft hover:shadow-lg transition">
            <div class="text-xs text-white mb-2">Exemple</div>
            <div class="text-lg font-semibold">"On a enfin arrete de se prendre la tete."</div>
            <div class="text-white text-sm mt-2">Sarah, Paris</div>
        </div>
    </div>
</section>

<section id="testimonials" class="max-w-7xl mx-auto px-6 py-16">
    <div class="text-center mb-10">
        <h2 class="font-display text-3xl mb-2">Ils utilisent FacileColoc</h2>
        <p class="text-white">Des colocations plus sereines, des comptes plus clairs.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-primary rounded-2xl border border-line p-6 shadow-soft hover:shadow-lg transition">
            <div class="text-sm">"Simple et efficace."</div>
            <div class="text-xs text-white mt-2">Yassin</div>
        </div>
        <div class="bg-primary rounded-2xl border border-line p-6 shadow-soft hover:shadow-lg transition">
            <div class="text-sm">"On voit tout en un coup d oeil."</div>
            <div class="text-xs text-white mt-2">Ines</div>
        </div>
        <div class="bg-primary rounded-2xl border border-line p-6 shadow-soft hover:shadow-lg transition">
            <div class="text-sm">"Plus de calculs manuels."</div>
            <div class="text-xs text-white mt-2">Mouad</div>
        </div>
    </div>
</section>

<footer class="border-t border-line">
    <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="font-display text-lg">FacileColoc</div>
        <div class="text-sm text-white">© 2026 FacileColoc. Tous droits reserves.</div>
        <div class="flex gap-4 text-sm text-white">
            <a href="#" class="hover:text-ink">Mentions</a>
            <a href="#" class="hover:text-ink">Confidentialite</a>
            <a href="#" class="hover:text-ink">Contact</a>
        </div>
    </div>
</footer>

</body>
</html>



