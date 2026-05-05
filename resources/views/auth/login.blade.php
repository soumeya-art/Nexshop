<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@include('partials.theme-init')
<title>NexShop — Connexion</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
body{min-height:100vh;display:flex;flex-direction:column;background:var(--bg)}
.auth-page{flex:1;display:grid;grid-template-columns:1fr 1.2fr;min-height:100vh}

.auth-left{
  position:relative;overflow:hidden;
  background:linear-gradient(135deg,#0D0D0D 0%,#001a0a 50%,#0a0010 100%);
  display:flex;flex-direction:column;justify-content:space-between;padding:48px 52px;
}
.auth-left::before{
  content:'';position:absolute;inset:0;
  background-image:linear-gradient(rgba(255,107,53,.04) 1px,transparent 1px),
    linear-gradient(90deg,rgba(255,107,53,.04) 1px,transparent 1px);
  background-size:50px 50px;
}
.auth-left-glow{position:absolute;bottom:-100px;left:-100px;width:500px;height:500px;background:radial-gradient(circle,rgba(255,107,53,.12) 0%,transparent 65%);pointer-events:none}
.auth-logo{font-family:'Space Grotesk',sans-serif;font-size:28px;font-weight:800;color:var(--white);position:relative;z-index:2}
.auth-logo span{color:var(--orange)}
.auth-left-content{position:relative;z-index:2}
.auth-left-title{font-size:clamp(32px,3vw,46px);font-weight:800;color:var(--white);line-height:1.1;margin-bottom:18px}
.auth-left-title span{color:var(--orange)}
.auth-left-desc{font-size:15px;color:var(--muted);line-height:1.75;margin-bottom:36px}
.auth-perks{display:flex;flex-direction:column;gap:14px}
.auth-perk{display:flex;align-items:center;gap:12px;font-size:14px;color:var(--muted)}
.auth-perk-ico{width:36px;height:36px;border-radius:10px;background:rgba(255,107,53,.1);display:flex;align-items:center;justify-content:center;color:var(--orange);font-size:14px;flex-shrink:0}
.auth-testimonial{position:relative;z-index:2;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:var(--radius);padding:20px}
.auth-t-stars{color:#FCD34D;font-size:14px;margin-bottom:10px}
.auth-t-text{font-size:13px;color:var(--muted);line-height:1.7;font-style:italic;margin-bottom:14px}
.auth-t-author{display:flex;align-items:center;gap:10px}
.auth-t-avatar{width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid var(--orange)}
.auth-t-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:var(--white)}
.auth-t-role{font-size:11px;color:var(--muted)}

/* RIGHT */
.auth-right{display:flex;align-items:center;justify-content:center;padding:40px 56px;background:var(--bg);overflow-y:auto}
.auth-box{width:100%;max-width:480px}
.auth-box-title{font-family:'Space Grotesk',sans-serif;font-size:28px;font-weight:800;color:var(--white);margin-bottom:6px}
.auth-box-sub{font-size:14px;color:var(--muted);margin-bottom:28px}
.auth-box-sub a{color:var(--orange);font-weight:600}

/* FORM */
.auth-form{display:flex;flex-direction:column;gap:16px}
.af-group{display:flex;flex-direction:column;gap:7px}
.af-group label{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--muted)}
.af-input-wrap{position:relative}
.af-input-wrap i{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px;pointer-events:none}
.af-input-wrap input{
  width:100%;background:var(--bg2);border:1.5px solid var(--border);border-radius:var(--radius-sm);
  padding:12px 14px 12px 42px;color:var(--white);font-family:'Inter',sans-serif;font-size:14px;
  outline:none;transition:border-color var(--T),box-shadow var(--T);
}
.af-input-wrap input::placeholder{color:var(--muted)}
.af-input-wrap input:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(255,107,53,.1)}
.af-row{display:flex;align-items:center;justify-content:space-between}
.af-check{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--muted)}
.af-check input[type=checkbox]{width:16px;height:16px;accent-color:var(--orange);cursor:pointer}
.af-forgot{font-size:13px;color:var(--orange);font-weight:600}
.btn-auth{width:100%;background:var(--orange);color:#fff;border:none;padding:14px;border-radius:var(--radius-sm);font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;cursor:pointer;transition:all var(--T);box-shadow:0 4px 16px rgba(255,107,53,.35);display:flex;align-items:center;justify-content:center;gap:10px}
.btn-auth:hover{background:var(--orange2);transform:translateY(-1px);box-shadow:0 8px 24px rgba(255,107,53,.45)}
.af-divider{display:flex;align-items:center;gap:14px;color:var(--muted);font-size:11px;letter-spacing:.08em;text-transform:uppercase}
.af-divider::before,.af-divider::after{content:'';flex:1;height:1px;background:var(--border)}
.af-socials{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.af-social-btn{display:flex;align-items:center;justify-content:center;gap:8px;background:var(--bg2);border:1.5px solid var(--border);color:var(--text);padding:11px;border-radius:var(--radius-sm);font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all var(--T)}
.af-social-btn:hover{border-color:var(--orange);color:var(--orange)}
.auth-footer-link{font-size:13px;color:var(--muted);text-align:center}
.auth-footer-link a{color:var(--orange);font-weight:600}

/* ── Light mode ── */
html[data-theme='light'] body{background:#f5f7fb}
html[data-theme='light'] .auth-left{background:linear-gradient(135deg,#eef2f9 0%,#e4eaf4 50%,#dde4f0 100%)}
html[data-theme='light'] .auth-left::before{background-image:linear-gradient(rgba(255,107,53,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(255,107,53,.06) 1px,transparent 1px)}
html[data-theme='light'] .auth-left-glow{background:radial-gradient(circle,rgba(255,107,53,.08) 0%,transparent 65%)}
html[data-theme='light'] .auth-logo{color:#0f172a}
html[data-theme='light'] .auth-left-title{color:#0f172a}
html[data-theme='light'] .auth-left-desc{color:#475569}
html[data-theme='light'] .auth-perk{color:#475569}
html[data-theme='light'] .auth-perk-ico{background:rgba(255,107,53,.1)}
html[data-theme='light'] .auth-testimonial{background:rgba(15,23,42,.03);border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .auth-t-text{color:#475569}
html[data-theme='light'] .auth-t-name{color:#0f172a}
html[data-theme='light'] .auth-t-role{color:#64748b}
html[data-theme='light'] .auth-right{background:#f5f7fb}
html[data-theme='light'] .auth-box-title{color:#0f172a}
html[data-theme='light'] .auth-box-sub{color:#64748b}
html[data-theme='light'] .af-group label{color:#64748b}
html[data-theme='light'] .af-input-wrap input{background:#fff;border-color:rgba(15,23,42,.12);color:#0f172a}
html[data-theme='light'] .af-input-wrap input::placeholder{color:#94a3b8}
html[data-theme='light'] .af-input-wrap i{color:#94a3b8}
html[data-theme='light'] .af-check{color:#64748b}
html[data-theme='light'] .af-forgot{color:var(--orange)}
html[data-theme='light'] .af-divider{color:#94a3b8}
html[data-theme='light'] .af-divider::before,html[data-theme='light'] .af-divider::after{background:rgba(15,23,42,.1)}
html[data-theme='light'] .af-social-btn{background:#fff;border-color:rgba(15,23,42,.1);color:#334155}
html[data-theme='light'] .af-social-btn:hover{border-color:var(--orange);color:var(--orange)}
html[data-theme='light'] .auth-footer-link{color:#64748b}
.auth-theme-toggle{position:absolute;top:20px;right:20px;z-index:10}

@media(max-width:900px){.auth-page{grid-template-columns:1fr}.auth-left{display:none}.auth-right{padding:32px 20px}}
</style>
@include('partials.theme-manager')
</head>
<body>
<div class="auth-page" style="position:relative">

  <div class="auth-theme-toggle">
    <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
  </div>

  <!-- LEFT -->
  <div class="auth-left">
    <div class="auth-left-glow"></div>
    <a href="/" class="auth-logo">Nex<span>Shop</span></a>
    <div class="auth-left-content">
      <h2 class="auth-left-title">Bon retour<br>sur <span>NexShop</span></h2>
      <p class="auth-left-desc">Connecte-toi pour accéder à tes commandes, favoris et recommandations personnalisées.</p>
      <div class="auth-perks">
        <div class="auth-perk"><div class="auth-perk-ico"><i class="fa-solid fa-bag-shopping"></i></div>Suis tes commandes en temps réel</div>
        <div class="auth-perk"><div class="auth-perk-ico"><i class="fa-solid fa-heart"></i></div>Retrouve tous tes produits favoris</div>
        <div class="auth-perk"><div class="auth-perk-ico"><i class="fa-solid fa-money-bill-wave"></i></div>Paiement en espèces à la livraison</div>
        <div class="auth-perk"><div class="auth-perk-ico"><i class="fa-solid fa-headset"></i></div>Support prioritaire 24/7</div>
      </div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="auth-right">
    <div class="auth-box">
      <h1 class="auth-box-title">Connexion</h1>
      <p class="auth-box-sub">Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire gratuitement</a></p>

      <form class="auth-form" method="POST" action="{{ route('login.submit') }}">
        @csrf

        @if(session('success'))
        <div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:8px;padding:12px 16px;color:#22c55e;font-size:13px;">
          <i class="fa-solid fa-circle-check"></i>
          {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:8px;padding:12px 16px;color:#ef4444;font-size:13px;">
          <i class="fa-solid fa-circle-exclamation"></i>
          {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:8px;padding:12px 16px;color:#ef4444;font-size:13px;">
          <i class="fa-solid fa-circle-exclamation"></i>
          {{ $errors->first() }}
        </div>
        @endif

        <div class="af-group">
          <label>Adresse email</label>
          <div class="af-input-wrap">
            <i class="fa-regular fa-envelope"></i>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="sophie@email.com" required autocomplete="email">
          </div>
        </div>

        <div class="af-group">
          <label>Mot de passe</label>
          <div class="af-input-wrap">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
          </div>
        </div>

        <div class="af-row">
          <label class="af-check">
            <input type="checkbox" name="remember">
            Se souvenir de moi
          </label>
          <a href="#" class="af-forgot">Mot de passe oublié ?</a>
        </div>

        <button type="submit" class="btn-auth">
          <i class="fa-solid fa-arrow-right-to-bracket"></i> Se connecter
        </button>
      </form>

      <div style="margin-top:24px;display:flex;flex-direction:column;gap:16px">
        <div class="af-divider">ou continuer avec</div>
        <div class="af-socials">
          <button class="af-social-btn"><i class="fa-brands fa-google" style="color:#EA4335"></i> Google</button>
          <button class="af-social-btn"><i class="fa-brands fa-facebook-f" style="color:#1877F2"></i> Facebook</button>
        </div>
      </div>

      <p class="auth-footer-link" style="margin-top:28px">
        Tu veux vendre ? <a href="#">Créer une boutique</a>
      </p>
    </div>
  </div>

</div>
</body>
</html>