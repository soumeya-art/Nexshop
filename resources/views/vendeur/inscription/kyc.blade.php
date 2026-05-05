<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexShop — Etape 2/3 · Verification KYC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #080808;
            --bg-elevated: #111111;
            --surface: #141414;
            --border: rgba(255, 255, 255, 0.08);
            --border-focus: rgba(255, 107, 53, 0.45);
            --txt: #f4f4f5;
            --muted: #a1a1aa;
            --orange: #ff6b35;
            --orange-dim: #e85a2a;
            --glow: rgba(255, 107, 53, 0.12);
            --err-bg: rgba(239, 68, 68, 0.1);
            --err-border: rgba(239, 68, 68, 0.35);
            --err-txt: #fecaca;
            --radius: 14px;
            --radius-lg: 22px;
        }

        html[data-theme="light"] {
            --bg: #f4f7fb;
            --bg-elevated: #ffffff;
            --surface: #ffffff;
            --border: rgba(15, 23, 42, 0.14);
            --border-focus: rgba(255, 107, 53, 0.45);
            --txt: #0f172a;
            --muted: #5b6473;
            --orange: #ff6b35;
            --orange-dim: #e85a2a;
            --glow: rgba(255, 107, 53, 0.12);
            --err-bg: rgba(239, 68, 68, 0.08);
            --err-border: rgba(239, 68, 68, 0.26);
            --err-txt: #b91c1c;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, sans-serif;
            background: var(--bg);
            color: var(--txt);
            line-height: 1.5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 28px 18px 40px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: -40% -20%;
            background:
                radial-gradient(ellipse 55% 45% at 18% 12%, var(--glow), transparent 55%),
                radial-gradient(ellipse 50% 40% at 88% 8%, rgba(255, 107, 53, 0.06), transparent 50%),
                radial-gradient(ellipse 60% 50% at 50% 100%, rgba(255, 255, 255, 0.03), transparent 45%);
            pointer-events: none;
            z-index: 0;
        }

        .wrap {
            width: 100%;
            max-width: 700px;
            position: relative;
            z-index: 1;
        }

        .card {
            background: linear-gradient(165deg, rgba(24, 24, 24, 0.95) 0%, var(--surface) 48%, #101010 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: clamp(22px, 4vw, 34px);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.03) inset,
                0 32px 64px -24px rgba(0, 0, 0, 0.75);
        }

        html[data-theme="light"] .card {
            background: linear-gradient(165deg, #ffffff 0%, #ffffff 60%, #f8fafc 100%);
            box-shadow:
                0 0 0 1px rgba(15, 23, 42, 0.03) inset,
                0 32px 64px -24px rgba(15, 23, 42, 0.18);
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 0.75rem;
        }
        .brand {
            font-family: "Space Grotesk", sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .brand span { color: var(--orange); }

        .theme-toggle {
            border: 1px solid var(--border);
            border-radius: 999px;
            background: transparent;
            color: var(--muted);
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.4rem 0.7rem;
            cursor: pointer;
        }

        .step-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--orange);
            background: rgba(255, 107, 53, 0.1);
            border: 1px solid rgba(255, 107, 53, 0.22);
            padding: 0.35rem 0.65rem;
            border-radius: 999px;
            margin-bottom: 0.65rem;
        }

        h1 {
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(1.4rem, 3.4vw, 1.7rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            margin: 0 0 0.45rem;
            line-height: 1.2;
        }
        .lead {
            color: var(--muted);
            font-size: 0.95rem;
            margin: 0 0 1.5rem;
            max-width: 40em;
        }

        .steps { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.65rem; }
        .steps-track { flex: 1; display: flex; gap: 6px; }
        .bar {
            flex: 1;
            height: 4px;
            border-radius: 999px;
            background: #262626;
        }
        html[data-theme="light"] .bar { background: #e2e8f0; }
        .bar.done {
            background: linear-gradient(90deg, var(--orange-dim), var(--orange));
            box-shadow: 0 0 12px rgba(255, 107, 53, 0.35);
        }
        .steps-label { font-size: 0.7rem; font-weight: 600; color: var(--muted); white-space: nowrap; }

        .err {
            background: var(--err-bg);
            border: 1px solid var(--err-border);
            color: var(--err-txt);
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            margin-bottom: 1.1rem;
        }

        .field { margin-bottom: 1.1rem; }
        .field label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.45rem;
            letter-spacing: 0.02em;
        }

        input, select {
            width: 100%;
            font: inherit;
            color: var(--txt);
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.72rem 0.95rem;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        input:focus, select:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.12);
        }

        .upload {
            padding: 0.75rem 0.95rem;
            border: 1px dashed var(--border);
            border-radius: var(--radius);
            background: var(--bg-elevated);
        }

        .upload input[type="file"] {
            width: 100%;
            font-size: 0.9rem;
        }

        .btn {
            width: 100%;
            border: none;
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            color: #fff;
            cursor: pointer;
            padding: 0.95rem 1.25rem;
            border-radius: var(--radius);
            background: linear-gradient(180deg, #ff7a4a 0%, var(--orange) 45%, var(--orange-dim) 100%);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.12) inset,
                0 12px 32px -8px rgba(255, 107, 53, 0.45);
            transition: transform 0.12s ease, filter 0.12s ease;
        }
        .btn:hover { filter: brightness(1.05); }
        .btn:active { transform: translateY(1px); }
    </style>
</head>
<body>
<div class="wrap"><div class="card">
    <div class="top">
        <div class="brand">Nex<span>Shop</span></div>
        <button type="button" class="theme-toggle" data-theme-toggle>Mode clair</button>
    </div>
    <div class="step-pill">Etape 2 sur 3</div>
    <h1>Verification KYC</h1>
    <p class="lead">Confirmez votre identite avec des documents valides afin de securiser la marketplace et finaliser l'activation de votre espace vendeur.</p>
    <div class="steps" aria-hidden="true">
        <div class="steps-track">
            <div class="bar done"></div>
            <div class="bar done"></div>
            <div class="bar"></div>
        </div>
        <span class="steps-label">Verification en cours</span>
    </div>

    @if($errors->any())
        <div class="err">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('vendeur.inscription.kyc.post') }}" enctype="multipart/form-data">
        @csrf
        <div class="field"><label for="type_piece">Type de piece</label>
        <select id="type_piece" name="type_piece" required>
            <option value="">Choisir</option>
            <option value="cni">CNI</option>
            <option value="passeport">Passeport</option>
        </select></div>

        <div class="field"><label>Photo piece identite</label>
        <div class="upload"><input type="file" name="piece_identite" accept="image/*" required></div></div>

        <div class="field"><label>Selfie avec piece</label>
        <div class="upload"><input type="file" name="selfie_piece" accept="image/*" required></div></div>

        <div class="field"><label for="adresse">Adresse (optionnel)</label>
        <input id="adresse" name="adresse" value="{{ old('adresse') }}"></div>

        <button class="btn" type="submit">Soumettre mes documents</button>
    </form>
</div></div>
<script>
    (function () {
        var root = document.documentElement;
        var key = "nexshop-theme";
        var saved = localStorage.getItem(key);
        var initial = saved === "light" || saved === "dark" ? saved : "dark";
        root.setAttribute("data-theme", initial);

        var toggle = document.querySelector("[data-theme-toggle]");
        function refreshLabel(theme) {
            if (!toggle) return;
            toggle.textContent = theme === "dark" ? "Mode clair" : "Mode sombre";
        }

        refreshLabel(initial);
        if (toggle) {
            toggle.addEventListener("click", function () {
                var active = root.getAttribute("data-theme") || "dark";
                var next = active === "dark" ? "light" : "dark";
                root.setAttribute("data-theme", next);
                localStorage.setItem(key, next);
                refreshLabel(next);
            });
        }
    })();
</script>
</body>
</html>
