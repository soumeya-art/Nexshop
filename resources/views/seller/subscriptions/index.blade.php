<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.theme-init')
    <title>NexShop — Abonnement vendeur</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .seller-subscription-page {
            --nx-bg: #f6f7f9;
            --nx-surface: #ffffff;
            --nx-text: #0f172a;
            --nx-muted: #64748b;
            --nx-border: #e2e8f0;
            --nx-accent: #FF6B35;
            --nx-accent-soft: rgba(255, 107, 53, 0.12);
            --nx-shadow: 0 1px 3px rgba(15, 23, 42, 0.06), 0 8px 24px rgba(15, 23, 42, 0.06);
            --nx-radius: 20px;
            --nx-font: 'Inter', system-ui, sans-serif;
            --nx-display: 'Space Grotesk', system-ui, sans-serif;
        }
        html[data-theme='dark'] .seller-subscription-page {
            --nx-bg: #0c0c0e;
            --nx-surface: #141416;
            --nx-text: #f1f5f9;
            --nx-muted: #94a3b8;
            --nx-border: rgba(255, 255, 255, 0.1);
            --nx-accent-soft: rgba(255, 107, 53, 0.15);
            --nx-shadow: 0 1px 0 rgba(255, 255, 255, 0.06), 0 16px 48px rgba(0, 0, 0, 0.35);
        }
        * { box-sizing: border-box; }
        body.seller-subscription-page {
            margin: 0;
            min-height: 100vh;
            background: var(--nx-bg);
            color: var(--nx-text);
            font-family: var(--nx-font);
            -webkit-font-smoothing: antialiased;
        }
        .nx-shell { max-width: 1120px; margin: 0 auto; padding: 0 20px 56px; }
        .nx-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 0 20px;
            flex-wrap: wrap;
        }
        .nx-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--nx-accent);
            text-decoration: none;
        }
        .nx-back:hover { text-decoration: underline; }
        .nx-brand {
            font-family: var(--nx-display);
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: -0.02em;
            color: var(--nx-text);
        }
        .nx-brand span { color: var(--nx-accent); }
        .nx-hero { text-align: center; padding: 8px 0 28px; max-width: 640px; margin: 0 auto; }
        .nx-hero h1 {
            font-family: var(--nx-display);
            font-size: clamp(1.65rem, 4vw, 2.15rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            margin: 0 0 10px;
            line-height: 1.15;
        }
        .nx-hero p { margin: 0; font-size: 15px; line-height: 1.55; color: var(--nx-muted); }
        .nx-status {
            max-width: 720px;
            margin: 0 auto 20px;
            padding: 14px 18px;
            border-radius: 14px;
            border: 1px solid var(--nx-border);
            background: var(--nx-surface);
            box-shadow: var(--nx-shadow);
            font-size: 14px;
            line-height: 1.5;
        }
        .nx-status strong { color: var(--nx-accent); font-weight: 700; }
        .nx-alert {
            max-width: 720px;
            margin: 0 auto 16px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
        }
        .nx-alert--ok { background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.25); color: #15803d; }
        html[data-theme='dark'] .nx-alert--ok { color: #86efac; }
        .nx-alert--err { background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); color: #b91c1c; }
        html[data-theme='dark'] .nx-alert--err { color: #fca5a5; }
        .nx-alert--info { background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.22); color: #1d4ed8; }
        html[data-theme='dark'] .nx-alert--info { color: #93c5fd; }
        .nx-pending {
            max-width: 720px;
            margin: 0 auto 28px;
            padding: 14px 18px;
            border-radius: 14px;
            border: 1px dashed var(--nx-border);
            background: var(--nx-surface);
            font-size: 13px;
            color: var(--nx-muted);
        }
        .nx-pending strong { color: var(--nx-text); }
        .nx-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            align-items: stretch;
        }
        @media (max-width: 900px) {
            .nx-grid { grid-template-columns: 1fr; max-width: 420px; margin: 0 auto; }
        }
        .nx-card {
            position: relative;
            background: var(--nx-surface);
            border: 1px solid var(--nx-border);
            border-radius: var(--nx-radius);
            padding: 24px 22px 22px;
            box-shadow: var(--nx-shadow);
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }
        .nx-card--highlight {
            border-color: rgba(255, 107, 53, 0.35);
            background: linear-gradient(180deg, var(--nx-accent-soft) 0%, var(--nx-surface) 42%);
        }
        .nx-card__ribbon {
            position: absolute;
            top: 14px;
            right: 14px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 5px 10px;
            border-radius: 999px;
            background: var(--nx-accent-soft);
            color: var(--nx-accent);
            border: 1px solid rgba(255, 107, 53, 0.25);
        }
        .nx-card__name {
            font-family: var(--nx-display);
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 0 4px;
            letter-spacing: -0.02em;
        }
        .nx-card__price {
            font-family: var(--nx-display);
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--nx-accent);
            margin-bottom: 2px;
        }
        .nx-card__price small {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--nx-muted);
        }
        .nx-card__tagline {
            font-size: 13px;
            color: var(--nx-muted);
            margin: 0 0 18px;
            min-height: 2.6em;
            line-height: 1.45;
        }
        .nx-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px 16px;
            border-radius: 999px;
            font-family: var(--nx-display);
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }
        .nx-btn:hover { transform: translateY(-1px); }
        .nx-btn--solid {
            background: var(--nx-text);
            color: var(--nx-surface);
            border-color: var(--nx-text);
        }
        html[data-theme='dark'] .nx-btn--solid {
            background: #f8fafc;
            color: #0f172a;
            border-color: #f8fafc;
        }
        .nx-btn--solid:hover { box-shadow: 0 8px 24px rgba(15, 23, 42, 0.15); }
        .nx-btn--accent {
            background: linear-gradient(135deg, var(--nx-accent), #ff8f66);
            color: #fff;
            border: none;
        }
        .nx-btn--accent:hover { box-shadow: 0 8px 28px rgba(255, 107, 53, 0.35); }
        .nx-btn--ghost {
            background: transparent;
            color: var(--nx-text);
            border-color: var(--nx-border);
        }
        .nx-btn--ghost:hover { background: rgba(15, 23, 42, 0.04); }
        html[data-theme='dark'] .nx-btn--ghost:hover { background: rgba(255, 255, 255, 0.06); }
        .nx-btn[disabled], .nx-btn[aria-disabled='true'] {
            opacity: 0.5;
            pointer-events: none;
            transform: none;
            box-shadow: none;
        }
        .nx-features {
            list-style: none;
            margin: 20px 0 0;
            padding: 0;
            flex: 1;
        }
        .nx-features li {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            font-size: 13px;
            color: var(--nx-muted);
            line-height: 1.45;
            margin-bottom: 10px;
        }
        .nx-features li:last-child { margin-bottom: 0; }
        .nx-features i {
            color: var(--nx-accent);
            margin-top: 2px;
            flex-shrink: 0;
        }
        .nx-footnote {
            text-align: center;
            max-width: 560px;
            margin: 32px auto 0;
            font-size: 12px;
            line-height: 1.65;
            color: var(--nx-muted);
        }
        .nx-charter {
            margin-top: 40px;
            padding: 24px 22px 26px;
            border-radius: var(--nx-radius);
            border: 1px solid var(--nx-border);
            background: var(--nx-surface);
            box-shadow: var(--nx-shadow);
        }
        .nx-charter h2 {
            font-family: var(--nx-display);
            font-size: 1.15rem;
            font-weight: 800;
            margin: 0 0 12px;
            letter-spacing: -0.02em;
        }
        .nx-charter__lead, .nx-charter__seller {
            font-size: 13px;
            line-height: 1.6;
            color: var(--nx-muted);
            margin: 0 0 16px;
        }
        .nx-charter__seller { margin-bottom: 0; margin-top: 18px; padding-top: 16px; border-top: 1px solid var(--nx-border); color: var(--nx-text); }
        .nx-charter__grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        @media (max-width: 900px) {
            .nx-charter__grid { grid-template-columns: 1fr; }
        }
        .nx-charter__col h3 {
            font-family: var(--nx-display);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--nx-accent);
            margin: 0 0 10px;
        }
        .nx-charter__col ul {
            margin: 0;
            padding-left: 18px;
            font-size: 12px;
            line-height: 1.55;
            color: var(--nx-muted);
        }
        .nx-charter__col li { margin-bottom: 4px; }
        .theme-toggle {
            border: 1px solid var(--nx-border);
            background: var(--nx-surface);
            color: var(--nx-text);
            border-radius: 10px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 13px;
        }
    </style>
    @include('partials.theme-manager')
</head>
<body class="seller-subscription-page">
<div class="nx-shell">
    <div class="nx-top">
        <a href="{{ route('vendeur.home') }}" class="nx-back"><i class="fa-solid fa-arrow-left"></i> Espace vendeur</a>
        <div class="nx-brand">nex<span>shop</span></div>
        <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
    </div>

    <header class="nx-hero">
        <h1>Choisissez votre formule</h1>
        <p>Commandes, badge vérifié, statistiques et messagerie : tout s’aligne sur votre ambition. Le paiement s’effectue sur l’étape suivante, comme un checkout moderne.</p>
    </header>

    @if(session('success'))<div class="nx-alert nx-alert--ok">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="nx-alert nx-alert--err">{{ session('error') }}</div>@endif
    @if(session('info'))<div class="nx-alert nx-alert--info">{{ session('info') }}</div>@endif

    <div class="nx-status">
        @if($user->hasActivePaidSubscription())
            Formule actuelle : <strong>{{ strtoupper($user->abonnement_plan) }}</strong>
            — échéance <strong>{{ $user->abonnement_expires_at?->format('d/m/Y') }}</strong>
            @if($user->sellerSubscriptionDaysRemaining() !== null)
                ({{ $user->sellerSubscriptionDaysRemaining() }} jour(s) restant(s))
            @endif
        @else
            Plan enregistré : <strong>{{ strtoupper($user->abonnement_plan ?? 'FREE') }}</strong>
            — ce mois-ci : <strong>{{ $used }} / {{ $limit }}</strong> commandes (hors annulées)
            @if($user->sellerSubscriptionLocked())
                <br><span style="color:#e11d48;font-weight:600">Compte limité : passez à Pro ou Premium pour débloquer l’ensemble des outils.</span>
            @endif
        @endif
    </div>

    @if($pending->isNotEmpty())
    <div class="nx-pending">
        <strong>Demandes en attente de validation</strong>
        <ul style="margin:8px 0 0;padding-left:18px">
            @foreach($pending as $py)
                <li>{{ strtoupper($py->plan) }} — {{ number_format($py->amount_fdj, 0, ',', ' ') }} FDJ ({{ $py->payment_method === 'dmoney' ? 'D‑Money' : 'En espèce' }}) — {{ $py->created_at?->diffForHumans() }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @php $hasPaid = $user->hasActivePaidSubscription(); @endphp

    <div class="nx-grid">
        <article class="nx-card">
            <div class="nx-card__name">Free</div>
            <div class="nx-card__price">0 <small>FDJ / mois</small></div>
            <p class="nx-card__tagline">Démarrer sur NexShop : idéal pour tester le marché.</p>
            @if(! $hasPaid && ($user->abonnement_plan ?? 'free') === 'free')
                <span class="nx-btn nx-btn--ghost" aria-disabled="true">Votre formule actuelle</span>
            @else
                <span class="nx-btn nx-btn--ghost" aria-disabled="true">Inclus à l’inscription</span>
            @endif
            <ul class="nx-features">
                @foreach(config('nexshop.seller_subscription.plan_features.free', []) as $line)
                    <li><i class="fa-solid fa-check"></i> {{ str_replace(':limit', (string) $limit, $line) }}</li>
                @endforeach
            </ul>
        </article>

        <article class="nx-card">
            <div class="nx-card__name">Pro</div>
            <div class="nx-card__price">{{ number_format($plans['pro']['price_fdj'] ?? 5000, 0, ',', ' ') }} <small>FDJ / mois</small></div>
            <p class="nx-card__tagline">Vendez sans limite, rassurez les acheteurs, suivez votre activité.</p>
            @if($hasPaid)
                <span class="nx-btn nx-btn--ghost" aria-disabled="true">Abonnement déjà actif</span>
            @else
                <a href="{{ route('vendeur.abonnement.checkout', ['plan' => 'pro']) }}" class="nx-btn nx-btn--solid">Continuer vers le paiement</a>
            @endif
            <ul class="nx-features">
                @foreach(config('nexshop.seller_subscription.plan_features.pro', []) as $line)
                    <li><i class="fa-solid fa-check"></i> {{ $line }}</li>
                @endforeach
            </ul>
        </article>

        <article class="nx-card nx-card--highlight">
            <span class="nx-card__ribbon">Max visibilité</span>
            <div class="nx-card__name">Premium</div>
            <div class="nx-card__price">{{ number_format($plans['premium']['price_fdj'] ?? 10000, 0, ',', ' ') }} <small>FDJ / mois</small></div>
            <p class="nx-card__tagline">Priorité catalogue, stats avancées et accompagnement VIP.</p>
            @if($hasPaid)
                <span class="nx-btn nx-btn--ghost" aria-disabled="true">Abonnement déjà actif</span>
            @else
                <a href="{{ route('vendeur.abonnement.checkout', ['plan' => 'premium']) }}" class="nx-btn nx-btn--accent">Continuer vers le paiement</a>
            @endif
            <ul class="nx-features">
                @foreach(config('nexshop.seller_subscription.plan_features.premium', []) as $line)
                    <li><i class="fa-solid fa-check"></i> {{ $line }}</li>
                @endforeach
            </ul>
        </article>
    </div>

    @php $charter = config('nexshop.seller_subscription.charter', []); @endphp
    <section class="nx-charter" aria-labelledby="nx-charter-title">
        <h2 id="nx-charter-title">{{ $charter['title'] ?? 'Engagements & obligations' }}</h2>
        <p class="nx-charter__lead">{{ $charter['platform'] ?? '' }}</p>
        <div class="nx-charter__grid">
            <div class="nx-charter__col">
                <h3>Free — appliqué par NexShop</h3>
                <ul>
                    @foreach(config('nexshop.seller_subscription.plan_features.free', []) as $line)
                        <li>{{ str_replace(':limit', (string) $limit, $line) }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="nx-charter__col">
                <h3>Pro — appliqué par NexShop</h3>
                <ul>
                    @foreach(config('nexshop.seller_subscription.plan_features.pro', []) as $line)
                        <li>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="nx-charter__col">
                <h3>Premium — appliqué par NexShop</h3>
                <ul>
                    @foreach(config('nexshop.seller_subscription.plan_features.premium', []) as $line)
                        <li>{{ $line }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <p class="nx-charter__seller"><strong>Obligations vendeur :</strong> {{ $charter['seller'] ?? '' }}</p>
    </section>

    <p class="nx-footnote">Après paiement, l’équipe NexShop Djibouti valide sous 24–48 h. Chaque période validée active le plan pendant <strong>30 jours</strong>. D‑Money : <a href="{{ config('nexshop.seller_subscription.dmoney_portal_login_url') }}" target="_blank" rel="noopener noreferrer" style="color:var(--nx-accent);font-weight:600">portail officiel</a> — transfert vers <strong style="color:var(--nx-accent)">{{ config('nexshop.seller_subscription.payment_recipient_phone') }}</strong>.</p>
</div>
</body>
</html>
