<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@include('partials.theme-init')
<title>NexShop — Inscription acheteur</title>
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
.steps{display:flex;flex-direction:column;gap:20px}
.step{display:flex;align-items:flex-start;gap:14px}
.step-num{width:32px;height:32px;border-radius:50%;background:var(--orange);color:#fff;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(255,107,53,.35)}
.step-title{font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:700;color:var(--white);margin-bottom:2px}
.step-desc{font-size:12px;color:var(--muted)}
.auth-stats{display:grid;grid-template-columns:1fr 1fr;gap:12px;position:relative;z-index:2}
.auth-stat{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:var(--radius);padding:18px;text-align:center}
.as-num{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--orange);margin-bottom:3px}
.as-label{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.07em}

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
.af-input-wrap i.icon{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px;pointer-events:none}
.af-input-wrap input{
  width:100%;background:var(--bg2);border:1.5px solid var(--border);border-radius:var(--radius-sm);
  padding:12px 14px 12px 42px;color:var(--white);font-family:'Inter',sans-serif;font-size:14px;
  outline:none;transition:border-color var(--T),box-shadow var(--T);
}
.af-input-wrap input::placeholder{color:var(--muted)}
.af-input-wrap input:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(255,107,53,.1)}
.form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}

.af-check{display:flex;align-items:flex-start;gap:10px;cursor:pointer;font-size:13px;color:var(--muted);line-height:1.5}
.af-check input[type=checkbox]{width:16px;height:16px;margin-top:2px;accent-color:var(--orange);cursor:pointer;flex-shrink:0}
.af-check a{color:var(--orange)}

/* Password strength */
.pwd-strength{margin-top:6px}
.pwd-bar{height:4px;border-radius:2px;background:var(--border);overflow:hidden;margin-bottom:4px}
.pwd-fill{height:100%;width:0%;border-radius:2px;transition:width .3s,background .3s}
.pwd-label{font-size:11px;color:var(--muted)}

.btn-auth{width:100%;background:var(--orange);color:#fff;border:none;padding:14px;border-radius:var(--radius-sm);font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;cursor:pointer;transition:all var(--T);box-shadow:0 4px 16px rgba(255,107,53,.35);display:flex;align-items:center;justify-content:center;gap:10px}
.btn-auth:hover{background:var(--orange2);transform:translateY(-1px);box-shadow:0 8px 24px rgba(255,107,53,.45)}
.af-divider{display:flex;align-items:center;gap:14px;color:var(--muted);font-size:11px;letter-spacing:.08em;text-transform:uppercase}
.af-divider::before,.af-divider::after{content:'';flex:1;height:1px;background:var(--border)}
.af-socials{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.af-social-btn{display:flex;align-items:center;justify-content:center;gap:8px;background:var(--bg2);border:1.5px solid var(--border);color:var(--text);padding:11px;border-radius:var(--radius-sm);font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all var(--T)}
.af-social-btn:hover{border-color:var(--orange);color:var(--orange)}

/* ── Light mode ── */
html[data-theme='light'] body{background:#f5f7fb}
html[data-theme='light'] .auth-left{background:linear-gradient(135deg,#eef2f9 0%,#e4eaf4 50%,#dde4f0 100%)}
html[data-theme='light'] .auth-left::before{background-image:linear-gradient(rgba(255,107,53,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(255,107,53,.06) 1px,transparent 1px)}
html[data-theme='light'] .auth-left-glow{background:radial-gradient(circle,rgba(255,107,53,.08) 0%,transparent 65%)}
html[data-theme='light'] .auth-logo{color:#0f172a}
html[data-theme='light'] .auth-left-title{color:#0f172a}
html[data-theme='light'] .auth-left-desc{color:#475569}
html[data-theme='light'] .step-title{color:#0f172a}
html[data-theme='light'] .step-desc{color:#64748b}
html[data-theme='light'] .auth-stat{background:rgba(15,23,42,.03);border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .as-label{color:#64748b}
html[data-theme='light'] .auth-right{background:#f5f7fb}
html[data-theme='light'] .auth-box-title{color:#0f172a}
html[data-theme='light'] .auth-box-sub{color:#64748b}
html[data-theme='light'] .af-group label{color:#64748b}
html[data-theme='light'] .af-input-wrap input{background:#fff;border-color:rgba(15,23,42,.12);color:#0f172a}
html[data-theme='light'] .af-input-wrap input::placeholder{color:#94a3b8}
html[data-theme='light'] .af-input-wrap i.icon{color:#94a3b8}
html[data-theme='light'] .af-check{color:#64748b}
html[data-theme='light'] .af-divider{color:#94a3b8}
html[data-theme='light'] .af-divider::before,html[data-theme='light'] .af-divider::after{background:rgba(15,23,42,.1)}
html[data-theme='light'] .af-social-btn{background:#fff;border-color:rgba(15,23,42,.1);color:#334155}
html[data-theme='light'] .af-social-btn:hover{border-color:var(--orange);color:var(--orange)}
html[data-theme='light'] .pwd-bar{background:rgba(15,23,42,.08)}
html[data-theme='light'] .pwd-label{color:#94a3b8}
.auth-theme-toggle{position:absolute;top:20px;right:20px;z-index:10}

@media(max-width:900px){.auth-page{grid-template-columns:1fr}.auth-left{display:none}.auth-right{padding:32px 20px}}
@media(max-width:500px){.form-row-2{grid-template-columns:1fr}}
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
      <h2 class="auth-left-title">Rejoins<br><span>NexShop</span><br>dès aujourd'hui</h2>
      <p class="auth-left-desc">Inscription gratuite en 2 minutes. Parcours des milliers de produits et commande en toute simplicité.</p>
      <div class="steps">
        <div class="step"><div class="step-num">1</div><div><div class="step-title">Crée ton compte</div><div class="step-desc">Remplis le formulaire en 2 min</div></div></div>
        <div class="step"><div class="step-num">2</div><div><div class="step-title">Confirme ton email</div><div class="step-desc">Un lien de vérification t'est envoyé</div></div></div>
        <div class="step"><div class="step-num">3</div><div><div class="step-title">Commence à explorer</div><div class="step-desc">Découvre les boutiques et passe ta première commande</div></div></div>
      </div>
    </div>
    <div class="auth-stats">
      <div class="auth-stat"><div class="as-num">100%</div><div class="as-label">Local</div></div>
      <div class="auth-stat"><div class="as-num">Gratuit</div><div class="as-label">Inscription</div></div>
      <div class="auth-stat"><div class="as-num">24h</div><div class="as-label">Livraison</div></div>
      <div class="auth-stat"><div class="as-num">5 jours</div><div class="as-label">Retour garanti</div></div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="auth-right">
    <div class="auth-box">
      <h1 class="auth-box-title">Créer un compte acheteur</h1>
      <p class="auth-box-sub">Déjà membre ? <a href="{{ route('login') }}">Se connecter</a> · Vendeur ? <a href="{{ route('vendeur.inscription.index') }}">Ouvrir une boutique</a></p>

      <form class="auth-form" method="POST" action="{{ route('register.submit') }}">
        @csrf

        @if($errors->any())
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:8px;padding:12px 16px;color:#ef4444;font-size:13px;">
          <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
        @endif

        <div class="form-row-2">
          <div class="af-group">
            <label>Prénom</label>
            <div class="af-input-wrap">
              <i class="fa-solid fa-user icon"></i>
              <input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Sophie" required>
            </div>
          </div>
          <div class="af-group">
            <label>Nom</label>
            <div class="af-input-wrap">
              <i class="fa-solid fa-user icon"></i>
              <input type="text" name="nom" value="{{ old('nom') }}" placeholder="Martin" required>
            </div>
          </div>
        </div>

        <div class="af-group">
          <label>Adresse email</label>
          <div class="af-input-wrap">
            <i class="fa-regular fa-envelope icon"></i>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="sophie@email.com" required>
          </div>
        </div>

        <div class="af-group">
          <label>Téléphone</label>
          <div class="af-input-wrap">
            <i class="fa-solid fa-phone icon"></i>
            <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="+33 6 12 34 56 78">
          </div>
        </div>

        <div class="af-group">
          <label>Mot de passe</label>
          <div class="af-input-wrap">
            <i class="fa-solid fa-lock icon"></i>
            <input type="password" name="password" placeholder="Min. 8 caractères" required oninput="checkStrength(this.value)">
          </div>
          <div class="pwd-strength">
            <div class="pwd-bar"><div class="pwd-fill" id="pwdFill"></div></div>
            <div class="pwd-label" id="pwdLabel">Entrez un mot de passe</div>
          </div>
        </div>

        <div class="af-group">
          <label>Confirmer le mot de passe</label>
          <div class="af-input-wrap">
            <i class="fa-solid fa-lock icon"></i>
            <input type="password" name="password_confirmation" placeholder="Répète le mot de passe" required>
          </div>
        </div>

        <label class="af-check">
          <input type="checkbox" name="terms" required>
          J'accepte les <a href="#">Conditions d'utilisation</a> et la <a href="#">Politique de confidentialité</a>
        </label>

        <button type="submit" class="btn-auth">
          <i class="fa-solid fa-user-plus"></i> Créer mon compte
        </button>

        <div class="af-divider">ou s'inscrire avec</div>
        <div class="af-socials">
          <button type="button" class="af-social-btn"><i class="fa-brands fa-google" style="color:#EA4335"></i> Google</button>
          <button type="button" class="af-social-btn"><i class="fa-brands fa-facebook-f" style="color:#1877F2"></i> Facebook</button>
        </div>
      </form>
    </div>
  </div>

</div>
<script>
function checkStrength(val) {
  const fill = document.getElementById('pwdFill');
  const label = document.getElementById('pwdLabel');
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const levels = [
    {w:'0%', c:'transparent', t:'Entrez un mot de passe'},
    {w:'25%', c:'#ef4444', t:'Trop faible'},
    {w:'50%', c:'#f97316', t:'Faible'},
    {w:'75%', c:'#eab308', t:'Moyen'},
    {w:'100%', c:'#22c55e', t:'Fort ✓'},
  ];
  const l = val.length === 0 ? levels[0] : levels[Math.min(score, 4)];
  fill.style.width = l.w; fill.style.background = l.c; label.textContent = l.t;
  label.style.color = l.c;
}
</script>
</body>
</html>
