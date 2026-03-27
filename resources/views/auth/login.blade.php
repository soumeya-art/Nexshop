<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NexShop — Connexion</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
body{min-height:100vh;display:flex;flex-direction:column;background:var(--bg)}

</style>
</head>
<body>
<div class="auth-page">

  <!-- LEFT -->
  <div class="auth-left">
    <div class="auth-left-glow"></div>
    <a href="/" class="auth-logo">Nex<span>Shop</span></a>
    <div class="auth-left-content">
      <h2 class="auth-left-title">Bon retour<br>sur <span>NexShop</span> 👋</h2>
      <p class="auth-left-desc">Connecte-toi pour accéder à tes commandes, favoris et recommandations personnalisées.</p>
      <div class="auth-perks">
        <div class="auth-perk"><div class="auth-perk-ico"><i class="fa-solid fa-bag-shopping"></i></div>Suis tes commandes en temps réel</div>
        <div class="auth-perk"><div class="auth-perk-ico"><i class="fa-solid fa-heart"></i></div>Retrouve tous tes produits favoris</div>
        <div class="auth-perk"><div class="auth-perk-ico"><i class="fa-solid fa-money-bill-wave"></i></div>Paiement en espèces à la livraison</div>
        <div class="auth-perk"><div class="auth-perk-ico"><i class="fa-solid fa-headset"></i></div>Support prioritaire 24/7</div>
      </div>
    </div>
    <div class="auth-testimonial">
      <div class="auth-t-stars">★★★★★</div>
      <p class="auth-t-text">"NexShop a transformé ma façon de faire du shopping. Tout est simple, rapide et le paiement en espèces c'est parfait !"</p>
      <div class="auth-t-author">
        <img class="auth-t-avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&q=80" alt="Sophie">
        <div>
          <div class="auth-t-name">Soumeya Bachir</div>
          <div class="auth-t-role">Cliente depuis 2mois</div>
        </div>
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
            <input type="password" name="password" id="pwd" placeholder="••••••••" required autocomplete="current-password">
            <button type="button" class="af-toggle" onclick="togglePwd('pwd',this)"><i class="fa-regular fa-eye"></i></button>
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

<script>
function togglePwd(id, btn) {
  const input = document.getElementById(id);
  const icon = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'fa-regular fa-eye-slash';
  } else {
    input.type = 'password';
    icon.className = 'fa-regular fa-eye';
  }
}
</script>
</body>
</html>