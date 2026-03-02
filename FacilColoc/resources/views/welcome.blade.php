<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyColoc</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Syne:wght@500;600;700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --bg: #f5f7fb;
            --card: #ffffff;
            --border: #e5e9f2;
            --text: #0f172a;
            --muted: #5b6472;
            --accent: #1dd675;
        }

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

        .brand {
            font-family: "Syne", sans-serif;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 1.8rem;
            color: var(--text);
        }

        .hero-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 28px;
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

        .feature {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 18px;
            height: 100%;
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="brand">EasyColoc</div>
        <div class="d-flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-outline-dark">Connexion</a>
            <a href="{{ route('register') }}" class="btn btn-accent">Créer un compte</a>
        </div>
    </div>

    <div class="hero-card mb-4">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="mb-3">Gérez votre colocation sans prise de tête.</h1>
                <p class="text-muted">
                    EasyColoc simplifie les dépenses communes, calcule automatiquement les soldes
                    et vous montre clairement « qui doit quoi à qui ».
                </p>
                <div class="d-flex gap-2">
                    <a href="{{ route('register') }}" class="btn btn-accent">Commencer</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-dark">Se connecter</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="feature">
                    <div class="fw-semibold mb-2">Fonctionnalités clés</div>
                    <ul class="mb-0">
                        <li>Suivi des dépenses partagées</li>
                        <li>Calcul automatique des soldes</li>
                        <li>Vue simplifiée des remboursements</li>
                        <li>Invitations par email</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="feature">
                <div class="fw-semibold mb-2">Transparence</div>
                <div class="text-muted">Chaque dépense est claire et partagée.</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature">
                <div class="fw-semibold mb-2">Simplicité</div>
                <div class="text-muted">Un clic pour marquer un paiement.</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature">
                <div class="fw-semibold mb-2">Équité</div>
                <div class="text-muted">Les soldes sont calculés automatiquement.</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
