<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexShop - Verification KYC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700;800&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0D0D0D;--bg2:#141414;--bg3:#101010;--bd:rgba(255,255,255,.1);--txt:#F0F0F0;--muted:#9CA3AF;--orange:#FF6B35}
        html[data-theme="light"]{--bg:#f4f7fb;--bg2:#ffffff;--bg3:#f8fafc;--bd:rgba(15,23,42,.14);--txt:#0f172a;--muted:#5b6473;--orange:#FF6B35}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--txt);font-family:Inter,sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .card{max-width:840px;width:100%;background:var(--bg2);border:1px solid var(--bd);border-radius:18px;padding:26px}
        .top{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap}
        .title{font-family:"Space Grotesk",sans-serif;font-size:32px;margin:8px 0}.sub{color:var(--muted)}
        .pill{display:inline-block;background:rgba(255,107,53,.14);border:1px solid rgba(255,107,53,.35);color:#FDBA74;padding:5px 10px;border-radius:99px;font-size:12px}
        html[data-theme="light"] .pill{color:#c2410c}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin:16px 0}
        .box{background:var(--bg3);border:1px solid var(--bd);border-radius:12px;padding:14px}
        .line{margin:6px 0}.actions{display:flex;gap:10px;margin-top:14px;flex-wrap:wrap}
        a.btn,button{background:var(--orange);color:#fff;border:none;padding:11px 14px;border-radius:10px;font-weight:700;cursor:pointer;text-decoration:none}
        a.ghost{background:#1f1f1f}
        html[data-theme="light"] a.ghost{background:#e2e8f0;color:#0f172a}
        .theme-toggle{border:1px solid var(--bd);background:transparent;color:var(--muted);padding:7px 12px;border-radius:999px;font-weight:600;cursor:pointer}
        @media (max-width:700px){.grid{grid-template-columns:1fr}.title{font-size:28px}}
    </style>
</head>
<body>
    <div class="card">
        <div class="top">
            <span class="pill">Dossier en verification</span>
            <button type="button" class="theme-toggle" data-theme-toggle>Mode clair</button>
        </div>
        <div class="title">Votre dossier est en cours de verification ⏳</div>
        <p class="sub">Bonjour {{ $user->nom }}, notre equipe examine vos documents. Vous recevrez un email a {{ $user->email }} des validation.</p>

        <div class="grid">
            <div class="box">
                <strong>Documents soumis</strong>
                <div class="line">✅ Piece d'identite</div>
                <div class="line">✅ Selfie avec piece</div>
                <div class="line">✅ Boutique: {{ $user->boutique?->nom ?? 'En attente' }}</div>
            </div>
            <div class="box">
                <strong>Delai estime</strong>
                <div class="line">Sous 24 heures</div>
                <div class="line sub">Vous serez informe automatiquement par email.</div>
            </div>
        </div>

        @if($user->statut_kyc === 'rejete')
            <div class="box" style="border-color:rgba(239,68,68,.35);background:rgba(239,68,68,.12);">
                <strong>❌ Dossier rejete</strong>
                <div class="line">Motif: {{ $user->motif_rejet_kyc }}</div>
                <a class="btn" href="{{ route('vendeur.inscription.kyc') }}">Resoumettre mes documents</a>
            </div>
        @endif

        <div class="actions">
            <a class="btn ghost" href="mailto:{{ env('MAIL_ADMIN_ADDRESS', 'nexshop.dj@gmail.com') }}">Contacter le support</a>
            <form method="POST" action="{{ route('logout') }}">@csrf <button type="submit">Se deconnecter</button></form>
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
        })();
    </script>
</body>
</html>
