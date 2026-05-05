<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexShop — Étape 3/3 · Votre boutique</title>
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
            content: '';
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
            max-width: 640px;
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

        .brand {
            font-family: "Space Grotesk", sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
        }

        .brand span { color: var(--orange); }
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }

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
            font-size: clamp(1.45rem, 3.5vw, 1.75rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            margin: 0 0 0.45rem;
            line-height: 1.2;
        }

        .lead {
            color: var(--muted);
            font-size: 0.95rem;
            margin: 0 0 1.5rem;
            max-width: 36em;
        }

        .steps {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.65rem;
        }

        .steps-track {
            flex: 1;
            display: flex;
            gap: 6px;
        }

        .steps-track .bar {
            flex: 1;
            height: 4px;
            border-radius: 999px;
            background: #262626;
            transition: background 0.25s ease;
        }
        html[data-theme="light"] .steps-track .bar { background: #e2e8f0; }

        .steps-track .bar.done {
            background: linear-gradient(90deg, var(--orange-dim), var(--orange));
            box-shadow: 0 0 12px rgba(255, 107, 53, 0.35);
        }

        .steps-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--muted);
            white-space: nowrap;
        }

        .err {
            background: var(--err-bg);
            border: 1px solid var(--err-border);
            color: var(--err-txt);
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.875rem;
            margin-bottom: 1.1rem;
        }

        .field {
            margin-bottom: 1.15rem;
        }

        .field label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.45rem;
            letter-spacing: 0.02em;
        }

        .field label .opt {
            font-weight: 400;
            opacity: 0.75;
        }

        input[type="text"],
        input[type="tel"],
        select,
        textarea {
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

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.12);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.55;
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23a1a1aa' viewBox='0 0 16 16'%3E%3Cpath d='M4 6l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.85rem center;
            padding-right: 2.25rem;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.85rem;
        }

        @media (max-width: 520px) {
            .row { grid-template-columns: 1fr; }
        }

        .file-shell {
            position: relative;
        }

        .file-shell input[type="file"] {
            position: absolute;
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            z-index: -1;
        }

        .file-drop {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            min-height: 112px;
            padding: 1rem 1.1rem;
            border: 1px dashed rgba(255, 255, 255, 0.18);
            border-radius: var(--radius);
            background: rgba(16, 16, 16, 0.65);
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease;
        }
        html[data-theme="light"] .file-drop {
            background: #f8fafc;
            border-color: rgba(15, 23, 42, 0.22);
        }

        .file-drop:hover,
        .file-shell:focus-within .file-drop {
            border-color: rgba(255, 107, 53, 0.45);
            background: rgba(255, 107, 53, 0.04);
        }

        .file-drop strong {
            font-size: 0.88rem;
            font-weight: 600;
        }

        .file-drop span.hint {
            font-size: 0.78rem;
            color: var(--muted);
        }

        #logo-filename {
            font-size: 0.8rem;
            color: var(--orange);
            margin-top: 0.5rem;
            text-align: center;
            word-break: break-all;
            min-height: 1.2em;
        }

        .submit-wrap {
            margin-top: 1.35rem;
            padding-top: 0.25rem;
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
            transition: transform 0.12s ease, filter 0.12s ease, box-shadow 0.12s ease;
        }

        .btn:hover {
            filter: brightness(1.05);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.15) inset,
                0 16px 40px -6px rgba(255, 107, 53, 0.5);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .footnote {
            text-align: center;
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 1.25rem;
            opacity: 0.85;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="top">
                <div class="brand">Nex<span>Shop</span></div>
                <button type="button" class="theme-toggle" data-theme-toggle>Mode clair</button>
            </div>
            <div class="step-pill">Étape 3 sur 3</div>
            <h1>Création de votre boutique</h1>
            <p class="lead">Dernière étape : présentez votre vitrine. Après envoi, notre équipe validera votre dossier avant l’ouverture de l’espace vendeur.</p>

            <div class="steps" aria-hidden="true">
                <div class="steps-track">
                    <div class="bar done" title="Compte"></div>
                    <div class="bar done" title="KYC"></div>
                    <div class="bar done" title="Boutique"></div>
                </div>
                <span class="steps-label">Presque terminé</span>
            </div>

            @if ($errors->any())
                <div class="err" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('vendeur.inscription.boutique.post') }}" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label for="nom">Nom de la boutique</label>
                    <input id="nom" name="nom" type="text" value="{{ old('nom') }}" required autocomplete="organization" placeholder="Ex. Bazar Shop">
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required placeholder="Décrivez votre univers, vos produits phares…">{{ old('description') }}</textarea>
                </div>

                <div class="field">
                    <label for="categorie">Catégorie</label>
                    <select id="categorie" name="categorie" required>
                        <option value="">Choisir une catégorie</option>
                        @foreach ($categories ?? [] as $cat)
                            <option value="{{ $cat->nom }}" @selected(old('categorie', $categoriePrefill ?? '') === $cat->nom)>{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="logo">Logo <span class="opt">(optionnel)</span></label>
                    <div class="file-shell">
                        <input id="logo" type="file" name="logo" accept="image/jpeg,image/png,.jpg,.jpeg,.png">
                        <label for="logo" class="file-drop">
                            <strong>Déposer une image ou cliquer pour parcourir</strong>
                            <span class="hint">JPG ou PNG — idéalement carré, max 2&nbsp;Mo</span>
                        </label>
                        <p id="logo-filename" aria-live="polite"></p>
                    </div>
                </div>

                <div class="row">
                    <div class="field">
                        <label for="ville">Ville</label>
                        <input id="ville" name="ville" type="text" value="{{ old('ville', 'Djibouti') }}" autocomplete="address-level2">
                    </div>
                    <div class="field">
                        <label for="telephone_boutique">Téléphone boutique <span class="opt">(optionnel)</span></label>
                        <input id="telephone_boutique" name="telephone_boutique" type="tel" value="{{ old('telephone_boutique') }}" placeholder="+253 …" autocomplete="tel">
                    </div>
                </div>

                <div class="submit-wrap">
                    <button class="btn" type="submit">Créer ma boutique et envoyer le dossier</button>
                </div>
            </form>

            <p class="footnote">Après envoi, vous serez informé par e-mail lorsque votre dossier aura été examiné par l’administration.</p>
        </div>
    </div>

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

            var input = document.getElementById('logo');
            var out = document.getElementById('logo-filename');
            if (!input || !out) return;
            input.addEventListener('change', function () {
                var f = input.files && input.files[0];
                out.textContent = f ? f.name : '';
            });
        })();
    </script>
</body>
</html>
