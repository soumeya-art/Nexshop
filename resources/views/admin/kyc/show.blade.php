<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.theme-init')
    <title>NexShop — Approuver l’inscription · {{ $user->nom }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --nx-orange: #ff6b35;
            --nx-success: #22c55e;
            --nx-success-dark: #16a34a;
            --nx-danger: #ef4444;
            --nx-danger-dark: #dc2626;
            --nx-radius: 18px;
            --nx-radius-sm: 12px;
            --nx-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
            --nx-shadow-dark: 0 24px 48px -16px rgba(0, 0, 0, 0.55);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body.admin-kyc-page {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, sans-serif;
            background: var(--bg, #e8ecf3);
            color: var(--text, #0f172a);
            line-height: 1.55;
        }

        html[data-theme='dark'] body.admin-kyc-page {
            background: var(--bg, #0d0d0d);
        }

        body.admin-kyc-page::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(255, 107, 53, 0.08), transparent 55%);
            pointer-events: none;
            z-index: 0;
        }

        html[data-theme='dark'] body.admin-kyc-page::before {
            background: radial-gradient(ellipse 70% 45% at 100% 0%, rgba(255, 107, 53, 0.07), transparent 50%);
        }

        .nx-topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 14px 22px;
            background: color-mix(in srgb, var(--bg2, #fff) 92%, transparent);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border, rgba(15, 23, 42, 0.08));
        }

        html[data-theme='dark'] .nx-topbar {
            background: color-mix(in srgb, var(--bg2, #141414) 92%, transparent);
            border-bottom-color: var(--border, rgba(255, 255, 255, 0.08));
        }

        .nx-topbar__left {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .nx-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--nx-orange);
            text-decoration: none;
        }

        .nx-back--muted {
            color: var(--muted, #64748b);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .nx-wrap {
            position: relative;
            z-index: 1;
            max-width: 880px;
            margin: 0 auto;
            padding: 28px 18px 48px;
        }

        .nx-shell {
            border-radius: var(--nx-radius);
            background: var(--surface, #ffffff);
            border: 1px solid var(--border, rgba(15, 23, 42, 0.08));
            box-shadow: var(--nx-shadow);
            overflow: hidden;
        }

        html[data-theme='dark'] .nx-shell {
            background: var(--bg2, #141414);
            border-color: var(--border, rgba(255, 255, 255, 0.1));
            box-shadow: var(--nx-shadow-dark);
        }

        .nx-shell__head {
            padding: 26px 28px 22px;
            border-bottom: 1px solid var(--border, rgba(15, 23, 42, 0.07));
        }

        html[data-theme='dark'] .nx-shell__head {
            border-bottom-color: var(--border, rgba(255, 255, 255, 0.08));
        }

        .nx-shell__title {
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(1.35rem, 2.8vw, 1.6rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            margin: 0 0 10px;
            color: var(--text, #0f172a);
        }

        .nx-shell__meta {
            margin: 0;
            font-size: 0.9rem;
            color: var(--muted, #64748b);
        }

        .nx-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            min-height: 0;
        }

        @media (max-width: 720px) {
            .nx-cols { grid-template-columns: 1fr; }
        }

        .nx-col {
            padding: 22px 28px 26px;
            border-right: 1px solid var(--border, rgba(15, 23, 42, 0.07));
        }

        html[data-theme='dark'] .nx-col {
            border-right-color: var(--border, rgba(255, 255, 255, 0.08));
        }

        .nx-col:last-child {
            border-right: none;
        }

        @media (max-width: 720px) {
            .nx-col { border-right: none; border-bottom: 1px solid var(--border, rgba(15, 23, 42, 0.07)); }
            html[data-theme='dark'] .nx-col { border-bottom-color: var(--border, rgba(255, 255, 255, 0.08)); }
            .nx-col:last-child { border-bottom: none; }
        }

        .nx-col__label {
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted, #64748b);
            margin-bottom: 14px;
        }

        .nx-shop-name {
            font-family: "Space Grotesk", sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0 12px;
            color: var(--text, #0f172a);
        }

        .nx-desc {
            margin: 0;
            font-size: 0.9rem;
            color: var(--muted, #64748b);
            line-height: 1.65;
        }

        .nx-kv {
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--border, rgba(15, 23, 42, 0.06));
            font-size: 0.82rem;
            display: grid;
            gap: 8px;
        }

        html[data-theme='dark'] .nx-kv {
            border-top-color: var(--border, rgba(255, 255, 255, 0.08));
        }

        .nx-kv div {
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .nx-kv span:first-child { color: var(--muted, #64748b); }
        .nx-kv span:last-child { font-weight: 600; color: var(--text, #0f172a); text-align: right; }

        .nx-doc-link {
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--nx-orange);
            text-decoration: none;
        }

        .nx-doc-link:hover { text-decoration: underline; }

        .nx-doc-link:last-child { margin-bottom: 0; }

        .nx-muted {
            margin: 0;
            font-size: 0.875rem;
            color: var(--muted, #64748b);
        }

        .nx-action-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            gap: 12px;
            padding: 18px 22px 20px;
            border-top: 1px solid var(--border, rgba(15, 23, 42, 0.08));
            background: color-mix(in srgb, var(--bg3, #f1f5f9) 65%, transparent);
        }

        html[data-theme='dark'] .nx-action-bar {
            border-top-color: var(--border, rgba(255, 255, 255, 0.08));
            background: color-mix(in srgb, var(--bg3, #1c1c1c) 80%, transparent);
        }

        .nx-btn-approve {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 22px;
            border: none;
            border-radius: var(--nx-radius-sm);
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            color: #fff;
            background: linear-gradient(180deg, #4ade80 0%, var(--nx-success) 45%, var(--nx-success-dark) 100%);
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.35);
            white-space: nowrap;
            transition: filter 0.15s ease, transform 0.1s ease;
        }

        .nx-btn-approve:hover { filter: brightness(1.05); }
        .nx-btn-approve:active { transform: translateY(1px); }

        .nx-reject-form {
            display: flex;
            flex: 1;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            min-width: min(100%, 280px);
        }

        .nx-motif {
            flex: 1;
            min-width: 160px;
            padding: 11px 14px;
            border-radius: var(--nx-radius-sm);
            border: 1px solid var(--border, rgba(15, 23, 42, 0.12));
            background: var(--surface, #fff);
            color: var(--text, #0f172a);
            font: inherit;
            font-size: 0.875rem;
        }

        html[data-theme='dark'] .nx-motif {
            background: var(--bg3, #1c1c1c);
            border-color: var(--border, rgba(255, 255, 255, 0.12));
            color: var(--text, #f0f0f0);
        }

        .nx-motif:focus {
            outline: none;
            border-color: rgba(239, 68, 68, 0.45);
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
        }

        .nx-motif::placeholder {
            color: var(--muted2, #94a3b8);
        }

        .nx-btn-reject {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 18px;
            border-radius: var(--nx-radius-sm);
            border: none;
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            color: #fff;
            background: linear-gradient(180deg, #f87171 0%, var(--nx-danger) 40%, var(--nx-danger-dark) 100%);
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
            white-space: nowrap;
            transition: filter 0.15s ease;
        }

        .nx-btn-reject:hover { filter: brightness(1.05); }

        @media (max-width: 640px) {
            .nx-action-bar { flex-direction: column; align-items: stretch; }
            .nx-btn-approve { width: 100%; justify-content: center; }
            .nx-reject-form { flex-direction: column; align-items: stretch; }
            .nx-motif { min-width: 0; width: 100%; }
            .nx-btn-reject { width: 100%; justify-content: center; }
        }
    </style>
    @include('partials.theme-manager')
</head>
<body class="admin-kyc-page">
    <header class="nx-topbar">
        <div class="nx-topbar__left">
            <a href="{{ route('admin.kyc.index') }}" class="nx-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Liste des dossiers</a>
            <a href="{{ route('admin.home') }}" class="nx-back nx-back--muted">Tableau de bord</a>
        </div>
        <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
    </header>

    <div class="nx-wrap">
        <article class="nx-shell" aria-labelledby="nx-approve-title">
            <header class="nx-shell__head">
                <h1 class="nx-shell__title" id="nx-approve-title">Approuver l’inscription : {{ $user->nom }}</h1>
                <p class="nx-shell__meta">E-mail : {{ $user->email }} · Téléphone : {{ $user->telephone ?? '—' }}</p>
            </header>

            <div class="nx-cols">
                <section class="nx-col" aria-labelledby="nx-lbl-boutique">
                    <div class="nx-col__label" id="nx-lbl-boutique">Boutique</div>
                    <h2 class="nx-shop-name">{{ $user->boutique?->nom ?? 'Non renseignée' }}</h2>
                    <p class="nx-desc">{{ $user->boutique?->description ?? 'Aucune description fournie.' }}</p>
                    @if ($user->boutique)
                        <div class="nx-kv">
                            @if ($user->boutique->categorie)
                                <div><span>Catégorie</span><span>{{ $user->boutique->categorie }}</span></div>
                            @endif
                            @if ($user->boutique->ville)
                                <div><span>Ville</span><span>{{ $user->boutique->ville }}</span></div>
                            @endif
                        </div>
                    @endif
                </section>

                <section class="nx-col" aria-labelledby="nx-lbl-docs">
                    <div class="nx-col__label" id="nx-lbl-docs">Documents</div>
                    @if ($user->kyc)
                        <a class="nx-doc-link" target="_blank" rel="noopener" href="{{ route('admin.kyc.document', [$user, 'piece_identite']) }}">Ouvrir pièce d’identité</a>
                        <a class="nx-doc-link" target="_blank" rel="noopener" href="{{ route('admin.kyc.document', [$user, 'selfie_piece']) }}">Ouvrir selfie avec pièce</a>
                    @else
                        <p class="nx-muted">Aucun document KYC.</p>
                    @endif
                </section>
            </div>

            <footer class="nx-action-bar">
                <form method="POST" action="{{ route('admin.kyc.valider', $user) }}">
                    @csrf
                    <button class="nx-btn-approve" type="submit"><i class="fa-solid fa-circle-check" aria-hidden="true"></i> Approuver l’inscription</button>
                </form>
                <form class="nx-reject-form" method="POST" action="{{ route('admin.kyc.rejeter', $user) }}">
                    @csrf
                    <input class="nx-motif" type="text" name="motif" required maxlength="500" placeholder="Motif du rejet" autocomplete="off" aria-label="Motif du rejet">
                    <button class="nx-btn-reject" type="submit">Rejeter</button>
                </form>
            </footer>
        </article>
    </div>
</body>
</html>
