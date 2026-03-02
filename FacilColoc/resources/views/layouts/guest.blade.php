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
            font-size: 1.6rem;
            color: var(--text);
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
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
    </style>
</head>

<body>

<div class="container py-5">
    <div class="text-center mb-4 brand">FacileColoc</div>
    @yield('content')
</div>

</body>
</html>
