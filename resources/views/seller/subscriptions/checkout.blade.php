<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.theme-init')
    <title>NexShop — Paiement {{ strtoupper($plan) }}</title>
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
            --nx-radius: 18px;
            --nx-font: 'Inter', system-ui, sans-serif;
            --nx-display: 'Space Grotesk', system-ui, sans-serif;
        }
        html[data-theme='dark'] .seller-subscription-page {
            --nx-bg: #0c0c0e;
            --nx-surface: #141416;
            --nx-text: #f1f5f9;
            --nx-muted: #94a3b8;
            --nx-border: rgba(255, 255, 255, 0.1);
        }
        * { box-sizing: border-box; }
        body.seller-subscription-page {
            margin: 0;
            min-height: 100vh;
            background: var(--nx-bg);
            color: var(--nx-text);
            font-family: var(--nx-font);
        }
        .nx-co-wrap { max-width: 480px; margin: 0 auto; padding: 20px 20px 48px; }
        .nx-co-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 20px;
        }
        .nx-co-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--nx-accent);
            text-decoration: none;
        }
        .nx-co-back:hover { text-decoration: underline; }
        .nx-co-brand { font-family: var(--nx-display); font-weight: 800; font-size: 1rem; }
        .nx-co-brand span { color: var(--nx-accent); }
        .theme-toggle {
            border: 1px solid var(--nx-border);
            background: var(--nx-surface);
            color: var(--nx-text);
            border-radius: 10px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 13px;
        }
        .nx-co-card {
            background: var(--nx-surface);
            border: 1px solid var(--nx-border);
            border-radius: var(--nx-radius);
            padding: 28px 24px 26px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06), 0 12px 40px rgba(15, 23, 42, 0.08);
        }
        html[data-theme='dark'] .nx-co-card {
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.06), 0 20px 50px rgba(0, 0, 0, 0.4);
        }
        .nx-co-kicker {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--nx-muted);
            margin-bottom: 8px;
        }
        .nx-co-title {
            font-family: var(--nx-display);
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 0 6px;
            letter-spacing: -0.02em;
        }
        .nx-co-amount {
            font-family: var(--nx-display);
            font-size: 2rem;
            font-weight: 800;
            color: var(--nx-accent);
            margin-bottom: 4px;
        }
        .nx-co-meta { font-size: 13px; color: var(--nx-muted); margin-bottom: 24px; line-height: 1.5; }
        .nx-co-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--nx-muted);
            margin-bottom: 8px;
        }
        .nx-pay-options { display: flex; flex-direction: column; gap: 10px; margin-bottom: 18px; }
        .nx-pay-opt {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid var(--nx-border);
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
        }
        .nx-pay-opt:hover { border-color: rgba(255, 107, 53, 0.35); }
        .nx-pay-opt:has(input:checked) {
            border-color: var(--nx-accent);
            background: rgba(255, 107, 53, 0.06);
        }
        html[data-theme='dark'] .nx-pay-opt:has(input:checked) {
            background: rgba(255, 107, 53, 0.1);
        }
        .nx-pay-opt input { width: 18px; height: 18px; accent-color: var(--nx-accent); }
        .nx-pay-opt strong { display: block; font-size: 14px; }
        .nx-pay-opt span { font-size: 12px; color: var(--nx-muted); }
        .nx-co-input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid var(--nx-border);
            background: var(--nx-surface);
            color: var(--nx-text);
            font-size: 14px;
            font-family: inherit;
            margin-bottom: 20px;
        }
        .nx-co-input:focus {
            outline: none;
            border-color: var(--nx-accent);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.15);
        }
        .nx-co-submit {
            width: 100%;
            padding: 14px 18px;
            border: none;
            border-radius: 999px;
            font-family: var(--nx-display);
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, var(--nx-accent), #ff8f66);
            cursor: pointer;
            transition: box-shadow 0.15s, transform 0.15s;
        }
        .nx-co-submit:hover { box-shadow: 0 10px 32px rgba(255, 107, 53, 0.35); transform: translateY(-1px); }
        .nx-co-legal {
            margin-top: 18px;
            font-size: 11px;
            line-height: 1.55;
            color: var(--nx-muted);
            text-align: center;
        }
        .nx-dmoney-panel {
            display: none;
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid rgba(255, 107, 53, 0.28);
            background: rgba(255, 107, 53, 0.07);
        }
        html[data-theme='dark'] .nx-dmoney-panel {
            background: rgba(255, 107, 53, 0.12);
        }
        .nx-dmoney-panel p { margin: 0 0 12px; font-size: 13px; line-height: 1.45; color: var(--nx-text); }
        .nx-dmoney-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            font-family: var(--nx-display);
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            color: var(--nx-accent);
            border: 2px solid var(--nx-accent);
            background: var(--nx-surface);
            transition: background 0.15s, color 0.15s;
        }
        .nx-dmoney-cta:hover {
            background: var(--nx-accent);
            color: #fff;
        }
        .nx-phone-callout {
            margin-bottom: 22px;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid var(--nx-border);
            background: rgba(15, 23, 42, 0.03);
            font-size: 13px;
            line-height: 1.55;
        }
        html[data-theme='dark'] .nx-phone-callout {
            background: rgba(255, 255, 255, 0.05);
        }
        .nx-phone-callout strong { color: var(--nx-text); }
        .nx-phone-num {
            display: inline-block;
            margin-top: 4px;
            font-family: var(--nx-display);
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--nx-accent);
            letter-spacing: 0.02em;
        }
        .nx-phone-callout a.nx-phone-num { text-decoration: none; }
        .nx-phone-callout a.nx-phone-num:hover { text-decoration: underline; }
        @supports not selector(:has(*)) {
            .nx-pay-opt input:checked + div { font-weight: 700; }
        }
        .nx-plan-recap {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid var(--nx-border);
            background: rgba(15, 23, 42, 0.03);
        }
        html[data-theme='dark'] .nx-plan-recap { background: rgba(255, 255, 255, 0.04); }
        .nx-plan-recap h2 {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--nx-muted);
            margin: 0 0 10px;
        }
        .nx-plan-recap ul { margin: 0; padding-left: 18px; font-size: 13px; line-height: 1.55; color: var(--nx-text); }
        .nx-accept {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.5;
            color: var(--nx-text);
            cursor: pointer;
        }
        .nx-accept input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            flex-shrink: 0;
            accent-color: var(--nx-accent);
        }
    </style>
    @include('partials.theme-manager')
</head>
<body class="seller-subscription-page">
<div class="nx-co-wrap">
    <div class="nx-co-top">
        <a href="{{ route('vendeur.abonnement.index') }}" class="nx-co-back"><i class="fa-solid fa-arrow-left"></i> Formules</a>
        <div class="nx-co-brand">nex<span>shop</span></div>
        <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
    </div>

    <div class="nx-co-card">
        <div class="nx-co-kicker">Récapitulatif</div>
        <h1 class="nx-co-title">Plan {{ strtoupper($plan) }}</h1>
        <div class="nx-co-amount">{{ number_format($amount, 0, ',', ' ') }} FDJ</div>
        <p class="nx-co-meta">Facturation mensuelle · <strong>30 jours</strong> d’accès après validation du paiement par NexShop.</p>

        @if(! empty($planFeatures))
        <div class="nx-plan-recap" aria-labelledby="nx-plan-recap-h">
            <h2 id="nx-plan-recap-h">Fonctionnalités de la formule {{ strtoupper($plan) }}</h2>
            <ul>
                @foreach($planFeatures as $line)
                    <li>{{ $line }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(! empty($paymentRecipientPhone))
        <div class="nx-phone-callout">
            <p style="margin:0 0 10px"><strong>D‑Money :</strong> transférez le montant (<strong>{{ number_format($amount, 0, ',', ' ') }} FDJ</strong>) vers le numéro NexShop :</p>
            <a href="tel:{{ preg_replace('/\s+/', '', $paymentRecipientPhone) }}" class="nx-phone-num">{{ $paymentRecipientPhone }}</a>
            <p style="margin:12px 0 0;font-size:12px;color:var(--nx-muted)"><strong>En espèce :</strong> contactez NexShop au même numéro avant de vous déplacer.</p>
        </div>
        @endif

        <form action="{{ route('vendeur.abonnement.store') }}" method="POST">
            @csrf
            <input type="hidden" name="plan" value="{{ $plan }}">

            <span class="nx-co-label">Moyen de paiement</span>
            <div class="nx-pay-options">
                <label class="nx-pay-opt">
                    <input type="radio" name="payment_method" value="dmoney" checked>
                    <div>
                        <strong>D‑Money</strong>
                        <span>Paiement mobile — indiquez la référence après transfert</span>
                    </div>
                </label>
                <label class="nx-pay-opt">
                    <input type="radio" name="payment_method" value="manual">
                    <div>
                        <strong>En espèce</strong>
                        <span>Paiement au comptoir ou en liquide — validation manuelle par l’administration</span>
                    </div>
                </label>
            </div>

            @if(! empty($dmoneyPortalUrl))
            <div id="nx-dmoney-panel" class="nx-dmoney-panel" role="region" aria-label="Paiement D-Money">
                <p><strong>Étapes :</strong> ouvrez le portail D‑Money, connectez-vous, puis envoyez <strong>{{ number_format($amount, 0, ',', ' ') }} FDJ</strong> au numéro <strong>{{ $paymentRecipientPhone ?: 'indiqué ci-dessus' }}</strong>. Indiquez ensuite la référence de transaction ci-dessous.</p>
                <a href="{{ $dmoneyPortalUrl }}" class="nx-dmoney-cta" target="_blank" rel="noopener noreferrer">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    Ouvrir le portail D‑Money
                </a>
            </div>
            @endif

            <label class="nx-co-label" for="buyer_reference">Référence (optionnel)</label>
            <input class="nx-co-input" id="buyer_reference" type="text" name="buyer_reference" value="{{ old('buyer_reference') }}" placeholder="Nº de transaction, nom sur le versement…" maxlength="191">

            @if ($errors->any())
                <div style="color:#e11d48;font-size:13px;margin-bottom:14px">{{ $errors->first() }}</div>
            @endif

            <label class="nx-accept">
                <input type="checkbox" name="accepted_plan_terms" value="1" {{ old('accepted_plan_terms') ? 'checked' : '' }} required>
                <span>J’ai pris connaissance des <strong>fonctionnalités du plan {{ strtoupper($plan) }}</strong> ci-dessus, des <a href="{{ route('vendeur.abonnement.index') }}#nx-charter-title" style="color:var(--nx-accent);font-weight:600">engagements NexShop et obligations vendeur</a>, et je m’engage à les respecter.</span>
            </label>

            <button type="submit" class="nx-co-submit">Confirmer la demande</button>
        </form>

        <p class="nx-co-legal">Aucun prélèvement automatique : votre accès est activé une fois le paiement confirmé. Vous recevrez une notification dans votre espace vendeur.</p>
    </div>
</div>
@if(! empty($dmoneyPortalUrl))
<script>
(function () {
  var panel = document.getElementById('nx-dmoney-panel');
  if (!panel) return;
  var radios = document.querySelectorAll('input[name="payment_method"]');
  function sync() {
    var dm = document.querySelector('input[name="payment_method"][value="dmoney"]');
    panel.style.display = dm && dm.checked ? 'block' : 'none';
  }
  radios.forEach(function (r) { r.addEventListener('change', sync); });
  sync();
})();
</script>
@endif
</body>
</html>
