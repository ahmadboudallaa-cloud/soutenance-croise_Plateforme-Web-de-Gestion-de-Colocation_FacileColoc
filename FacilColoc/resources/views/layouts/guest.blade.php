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

<div class="min-h-screen flex flex-col">
    <header class="py-6">
        <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl bg-white text-black font-bold flex items-center justify-center">FC</div>
                <div class="font-display text-lg">FacileColoc</div>
            </a>
            <div class="text-sm text-white">Gestion moderne de colocation</div>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center px-6 pb-10">
        <div class="w-full max-w-2xl">
            <div class="bg-primary border border-line rounded-2xl p-6 shadow-soft hover:shadow-lg transition">
                @yield('content')
            </div>
        </div>
    </main>
</div>

</body>
</html>
