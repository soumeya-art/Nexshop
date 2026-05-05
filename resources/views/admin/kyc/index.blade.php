<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.theme-init')
    <title>NexShop — Inscriptions vendeurs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --orange: #ff6b35;
            --orange-soft: rgba(255, 107, 53, 0.14);
            --success: #22c55e;
            --success-soft: rgba(34, 197, 94, 0.12);
            --danger: #ef4444;
            --danger-soft: rgba(239, 68, 68, 0.1);
            --warning: #f59e0b;
            --warning-soft: rgba(245, 158, 11, 0.12);
            --radius: 14px;
            --radius-sm: 10px;
            --shadow: 0 24px 48px -20px rgba(0, 0, 0, 0.55);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body.admin-kyc-page {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, system-ui, sans-serif;
            background: var(--bg, #0d0d0d);
            color: var(--text, #f0f0f0);
            line-height: 1.5;
        }

        body.admin-kyc-page::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 0% -10%, rgba(255, 107, 53, 0.08), transparent 50%),
                radial-gradient(ellipse 50% 40% at 100% 0%, rgba(255, 107, 53, 0.04), transparent 45%);
            pointer-events: none;
            z-index: 0;
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
            background: color-mix(in srgb, var(--bg2, #141414) 88%, transparent);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border, rgba(255, 255, 255, 0.08));
        }

        .nx-topbar__left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .nx-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--orange);
            text-decoration: none;
            transition: opacity 0.15s ease;
        }

        .nx-back:hover { opacity: 0.85; }

        .nx-crumb {
            font-size: 0.75rem;
            color: var(--muted, #9ca3af);
            max-width: 420px;
            line-height: 1.4;
        }

        .nx-wrap {
            position: relative;
            z-index: 1;
            max-width: 1140px;
            margin: 0 auto;
            padding: 28px 20px 48px;
        }

        .nx-head {
            margin-bottom: 28px;
        }

        .nx-eyebrow {
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 8px;
        }

        .nx-title {
            font-family: "Space Grotesk", sans-serif;
            font-size: clamp(1.5rem, 3vw, 1.85rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            margin: 0 0 8px;
            color: var(--text, #fff);
        }

        .nx-sub {
            margin: 0;
            font-size: 0.95rem;
            color: var(--muted, #9ca3af);
            max-width: 52ch;
        }

        .nx-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        @media (max-width: 720px) {
            .nx-stats { grid-template-columns: 1fr; }
        }

        .nx-stat {
            position: relative;
            padding: 20px 20px 18px;
            border-radius: var(--radius);
            background: var(--bg2, #141414);
            border: 1px solid var(--border, rgba(255, 255, 255, 0.08));
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .nx-stat::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
            opacity: 0.9;
        }

        .nx-stat--wait::after { background: linear-gradient(90deg, var(--warning), #fbbf24); }
        .nx-stat--ok::after { background: linear-gradient(90deg, var(--success), #4ade80); }
        .nx-stat--no::after { background: linear-gradient(90deg, var(--danger), #f87171); }

        .nx-stat__icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-bottom: 12px;
        }

        .nx-stat--wait .nx-stat__icon { background: var(--warning-soft); color: var(--warning); }
        .nx-stat--ok .nx-stat__icon { background: var(--success-soft); color: var(--success); }
        .nx-stat--no .nx-stat__icon { background: var(--danger-soft); color: var(--danger); }

        .nx-stat__label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted, #9ca3af);
            margin-bottom: 4px;
        }

        .nx-stat__val {
            font-family: "Space Grotesk", sans-serif;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text, #fff);
            line-height: 1.1;
        }

        .nx-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .nx-alert--ok {
            background: var(--success-soft);
            border: 1px solid rgba(34, 197, 94, 0.35);
            color: color-mix(in srgb, var(--success) 85%, #fff);
        }

        .nx-alert--err {
            background: var(--danger-soft);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #fecaca;
        }

        html[data-theme='light'] .nx-alert--err {
            color: #991b1b;
        }

        .nx-panel {
            border-radius: var(--radius);
            background: var(--bg2, #141414);
            border: 1px solid var(--border, rgba(255, 255, 255, 0.08));
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .nx-panel__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border, rgba(255, 255, 255, 0.08));
            background: color-mix(in srgb, var(--bg3, #1c1c1c) 70%, transparent);
        }

        .nx-panel__title {
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text, #fff);
        }

        .nx-panel__hint {
            font-size: 0.75rem;
            color: var(--muted, #9ca3af);
        }

        .nx-table-wrap { overflow-x: auto; }

        .nx-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .nx-table th {
            text-align: left;
            padding: 12px 18px;
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted, #9ca3af);
            background: color-mix(in srgb, var(--bg3, #1c1c1c) 80%, transparent);
            border-bottom: 1px solid var(--border, rgba(255, 255, 255, 0.08));
            white-space: nowrap;
        }

        .nx-table td {
            padding: 16px 18px;
            border-bottom: 1px solid var(--border, rgba(255, 255, 255, 0.06));
            vertical-align: middle;
            color: var(--text, #f0f0f0);
        }

        .nx-table tbody tr {
            transition: background 0.15s ease;
        }

        .nx-table tbody tr:hover td {
            background: color-mix(in srgb, var(--orange) 4%, transparent);
        }

        .nx-table tbody tr:last-child td { border-bottom: none; }

        .nx-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nx-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--orange-soft);
            color: var(--orange);
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .nx-name {
            font-weight: 600;
            color: var(--text, #fff);
        }

        .nx-mail {
            font-size: 0.8rem;
            color: var(--muted, #9ca3af);
        }

        .nx-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            font-family: "Space Grotesk", sans-serif;
            letter-spacing: 0.02em;
        }

        .nx-badge--wait {
            background: var(--warning-soft);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.35);
        }

        .nx-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            font-family: "Space Grotesk", sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid color-mix(in srgb, var(--orange) 45%, transparent);
            background: color-mix(in srgb, var(--orange) 12%, transparent);
            color: var(--orange);
            transition: background 0.15s ease, transform 0.12s ease, box-shadow 0.15s ease;
        }

        .nx-btn:hover {
            background: color-mix(in srgb, var(--orange) 22%, transparent);
            box-shadow: 0 4px 16px rgba(255, 107, 53, 0.2);
        }

        .nx-btn:active { transform: translateY(1px); }

        .nx-empty {
            padding: 48px 24px;
            text-align: center;
            color: var(--muted, #9ca3af);
        }

        .nx-empty i {
            font-size: 2rem;
            margin-bottom: 12px;
            opacity: 0.35;
            display: block;
        }

        .nx-pag {
            padding: 14px 18px;
            border-top: 1px solid var(--border, rgba(255, 255, 255, 0.08));
            display: flex;
            justify-content: center;
        }

        .nx-pag a {
            color: var(--orange);
        }
    </style>
    @include('partials.theme-manager')
</head>
<body class="admin-kyc-page">
    <header class="nx-topbar">
        <div class="nx-topbar__left">
            <a href="{{ route('admin.home') }}" class="nx-back"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Administration</a>
            <span class="nx-crumb">Validation des inscriptions vendeurs · vérification d’identité (KYC) et fiche boutique</span>
        </div>
        <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
    </header>

    <div class="nx-wrap">
        <header class="nx-head">
            <p class="nx-eyebrow">File d’attente</p>
            <h1 class="nx-title">Inscriptions vendeurs</h1>
            <p class="nx-sub">Examinez chaque dossier, contrôlez les pièces puis approuvez ou rejetez. Le vendeur n’accède à son espace qu’après validation.</p>
        </header>

        <div class="nx-stats">
            <div class="nx-stat nx-stat--wait">
                <div class="nx-stat__icon"><i class="fa-regular fa-hourglass-half" aria-hidden="true"></i></div>
                <div class="nx-stat__label">En attente de décision</div>
                <div class="nx-stat__val">{{ $stats['en_attente'] }}</div>
            </div>
            <div class="nx-stat nx-stat--ok">
                <div class="nx-stat__icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></div>
                <div class="nx-stat__label">Comptes validés</div>
                <div class="nx-stat__val">{{ $stats['valides'] }}</div>
            </div>
            <div class="nx-stat nx-stat--no">
                <div class="nx-stat__icon"><i class="fa-solid fa-ban" aria-hidden="true"></i></div>
                <div class="nx-stat__label">Dossiers rejetés</div>
                <div class="nx-stat__val">{{ $stats['rejetes'] }}</div>
            </div>
        </div>

        @if (session('success'))
            <div class="nx-alert nx-alert--ok" role="status"><i class="fa-solid fa-check-circle" aria-hidden="true"></i><span>{{ session('success') }}</span></div>
        @endif
        @if (session('error'))
            <div class="nx-alert nx-alert--err" role="alert"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i><span>{{ session('error') }}</span></div>
        @endif

        <section class="nx-panel" aria-labelledby="nx-queue-title">
            <div class="nx-panel__head">
                <h2 class="nx-panel__title" id="nx-queue-title">Dossiers à traiter</h2>
                <span class="nx-panel__hint">{{ $stats['en_attente'] }} en attente</span>
            </div>

            @php
                $kycLabels = [
                    'en_attente' => 'En attente',
                    'valide' => 'Validé',
                    'rejete' => 'Rejeté',
                    'non_soumis' => 'Non soumis',
                ];
            @endphp

            <div class="nx-table-wrap">
                <table class="nx-table">
                    <thead>
                        <tr>
                            <th>Vendeur</th>
                            <th>Contact</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th style="text-align:right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enAttente as $vendeur)
                            @php
                                $parts = preg_split('/\s+/', trim($vendeur->nom ?? ''), -1, PREG_SPLIT_NO_EMPTY);
                                $w0 = $parts[0] ?? '?';
                                $ini = isset($parts[1])
                                    ? strtoupper(mb_substr($w0, 0, 1).mb_substr($parts[1], 0, 1))
                                    : strtoupper(mb_substr($w0, 0, 1).mb_substr($w0, 1, 1));
                            @endphp
                            <tr>
                                <td>
                                    <div class="nx-user">
                                        <span class="nx-avatar" aria-hidden="true">{{ $ini }}</span>
                                        <div>
                                            <div class="nx-name">{{ $vendeur->nom }}</div>
                                            <div class="nx-mail">{{ $vendeur->boutique?->nom ?? 'Boutique à valider' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="nx-name" style="font-size:0.85rem">{{ $vendeur->email }}</div>
                                    <div class="nx-mail">{{ $vendeur->telephone ?? '—' }}</div>
                                </td>
                                <td style="color:var(--muted);font-size:0.85rem">{{ $vendeur->created_at?->format('d/m/Y') }}</td>
                                <td>
                                    <span class="nx-badge nx-badge--wait">
                                        <i class="fa-solid fa-circle" style="font-size:5px;opacity:.85"></i>
                                        {{ $kycLabels[$vendeur->statut_kyc] ?? $vendeur->statut_kyc }}
                                    </span>
                                </td>
                                <td style="text-align:right">
                                    <a href="{{ route('admin.kyc.show', $vendeur) }}" class="nx-btn">Examiner <i class="fa-solid fa-arrow-right" style="font-size:0.65rem"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="nx-empty">
                                        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
                                        Aucune inscription en attente pour le moment.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($enAttente->hasPages())
                <div class="nx-pag">{{ $enAttente->links() }}</div>
            @endif
        </section>
    </div>
</body>
</html>
