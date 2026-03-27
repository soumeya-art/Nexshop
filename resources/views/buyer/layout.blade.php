<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Espace Acheteur') — NexShop</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
:root{
  --bg:#0D0D0D;--bg2:#141414;--bg3:#1C1C1C;
  --border:rgba(255,255,255,.07);--border2:rgba(255,255,255,.12);
  --orange:#FF6B35;--orange2:#FF8C5A;
  --blue:#1E90FF;--white:#FFFFFF;--text:#F0F0F0;--muted:#777;--muted2:#444;
  --success:#22C55E;--danger:#EF4444;--warning:#F59E0B;
  --radius:14px;--radius-sm:10px;--radius-xs:7px;--T:.2s ease;
}
/* Nav & zone acheteur (priorité sur app.css) */
body.buyer-app .navbar{height:60px;padding:0 24px;gap:20px;background:rgba(13,13,13,.96);border-bottom:1px solid var(--border);display:flex;align-items:center;position:sticky;top:0;z-index:100;backdrop-filter:blur(20px)}
body.buyer-app .nav-logo{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white);white-space:nowrap}
body.buyer-app .nav-logo span{color:var(--orange)}
.nav-search{flex:1;max-width:420px;position:relative}
.nav-search input{width:100%;background:var(--bg3);border:1.5px solid var(--border2);border-radius:50px;padding:8px 18px 8px 40px;color:var(--white);font-size:13px;outline:none;transition:border-color var(--T);font-family:'Inter',sans-serif}
.nav-search input:focus{border-color:var(--orange)}
.nav-search i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px}
.page-container{max-width:1280px;margin:0 auto;padding:28px 40px;flex:1}
.sub-nav{background:rgba(13,13,13,.96);border-bottom:1px solid var(--border);padding:0 28px;backdrop-filter:blur(20px)}
.sub-nav-inner{display:flex;gap:0}
.nav-tab{padding:12px 18px;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;color:var(--muted);border:none;background:none;transition:all var(--T);border-bottom:2.5px solid transparent;margin-bottom:-1px;text-decoration:none;display:inline-block}
.nav-tab:hover{color:var(--text)}
.nav-tab.active{color:var(--orange);border-bottom-color:var(--orange)}
.nav-right{margin-left:auto;display:flex;align-items:center;gap:8px}
.nav-icon{width:36px;height:36px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:14px;position:relative;text-decoration:none;color:inherit}
.nav-icon:hover{border-color:var(--orange);color:var(--orange)}
.nav-badge{position:absolute;top:-4px;right:-4px;min-width:16px;height:16px;padding:0 4px;border-radius:50%;background:var(--orange);color:#fff;font-size:9px;font-weight:800;font-family:'Space Grotesk',sans-serif;display:flex;align-items:center;justify-content:center;border:2px solid var(--bg)}
.nav-avatar{width:34px;height:34px;border-radius:50%;border:2px solid var(--orange);overflow:hidden;cursor:pointer;background:var(--bg3)}
.nav-avatar img{width:100%;height:100%;object-fit:cover}
.page-container{max-width:1280px;margin:0 auto;padding:28px 40px;flex:1}
.hero{border-radius:var(--radius);overflow:hidden;margin-bottom:24px;position:relative;height:170px;background:linear-gradient(135deg,#0a1628,#001a40 50%,#0d0d0d);border:1px solid var(--border)}
.hero::before{content:'';position:absolute;inset:0;background:linear-gradient(90deg,rgba(255,107,53,.1),transparent 60%)}
.hero-img{position:absolute;right:0;top:0;height:100%;width:45%;object-fit:cover;opacity:.2}
.hero-content{position:relative;z-index:2;padding:28px 36px;height:100%;display:flex;flex-direction:column;justify-content:center}
.hero-tag{display:inline-flex;align-items:center;gap:5px;background:rgba(255,107,53,.15);border:1px solid rgba(255,107,53,.3);color:var(--orange);font-size:10px;font-weight:700;font-family:'Space Grotesk',sans-serif;padding:3px 10px;border-radius:50px;margin-bottom:10px}
.hero-title{font-family:'Space Grotesk',sans-serif;font-size:26px;font-weight:800;color:var(--white);line-height:1.1;margin-bottom:14px}
.hero-title span{color:var(--orange)}
.hero-btn{display:inline-flex;align-items:center;gap:7px;background:var(--orange);color:#fff;padding:9px 20px;border-radius:50px;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;cursor:pointer;border:none;transition:all var(--T);box-shadow:0 4px 14px rgba(255,107,53,.35);text-decoration:none}
.hero-btn:hover{background:var(--orange2);color:#fff}
.cat-bar{display:flex;align-items:center;gap:7px;flex-wrap:wrap;margin-bottom:22px}
.cat-label-txt{font-size:11px;font-weight:700;color:var(--muted2);font-family:'Space Grotesk',sans-serif;letter-spacing:.08em;text-transform:uppercase;display:flex;align-items:center;gap:5px;margin-right:4px}
.cat-chip{background:var(--bg3);border:1.5px solid var(--border);color:var(--muted);padding:6px 14px;border-radius:50px;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:600;transition:all var(--T);white-space:nowrap;text-decoration:none;display:inline-block}
.cat-chip:hover{border-color:rgba(255,107,53,.3);color:var(--text)}
.cat-chip.active{background:rgba(255,107,53,.1);border-color:var(--orange);color:var(--orange)}
.sec-row{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px}
.sec-title{font-family:'Space Grotesk',sans-serif;font-size:17px;font-weight:800;color:var(--white)}
.sec-sub{font-size:12px;color:var(--muted);margin-top:2px}
.sec-link{font-size:12px;color:var(--orange);font-weight:600;display:flex;align-items:center;gap:4px;white-space:nowrap;margin-top:4px}
.prods-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
@media(max-width:900px){.prods-grid{grid-template-columns:repeat(2,1fr)}}
.prod-card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:border-color var(--T),transform var(--T);cursor:pointer;text-decoration:none;color:inherit;display:block}
.prod-card:hover{border-color:rgba(255,107,53,.3);transform:translateY(-3px)}
.prod-img-wrap{position:relative;height:175px;overflow:hidden;background:var(--bg3)}
.prod-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.prod-card:hover .prod-img-wrap img{transform:scale(1.06)}
.prod-badge{position:absolute;top:9px;left:9px;background:var(--orange);color:#fff;font-size:9px;font-weight:800;padding:3px 8px;border-radius:50px;font-family:'Space Grotesk',sans-serif}
.prod-badge.new{background:var(--blue)}
.prod-wish{position:absolute;top:9px;right:9px;width:28px;height:28px;border-radius:50%;background:rgba(13,13,13,.85);backdrop-filter:blur(8px);border:none;color:var(--muted);cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center;transition:all var(--T)}
.prod-wish.in-fav{color:#ef4444}
.prod-body{padding:12px}
.prod-cat-lbl{font-size:9px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--orange);font-family:'Space Grotesk',sans-serif;margin-bottom:3px}
.prod-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:var(--white);margin-bottom:5px;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.prod-stars{color:#FCD34D;font-size:10px}
.prod-rcount{font-size:10px;color:var(--muted);margin-left:3px}
.prod-foot{display:flex;align-items:center;justify-content:space-between;margin-top:10px}
.prod-price{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:800;color:var(--orange)}
.prod-old{font-size:11px;color:var(--muted);text-decoration:line-through;margin-left:3px}
.prod-btns{display:flex;gap:5px}
.btn-eye{width:30px;height:30px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:12px;display:flex;align-items:center;justify-content:center;transition:all var(--T);text-decoration:none;color:inherit}
.btn-eye:hover{border-color:var(--orange);color:var(--orange)}
.btn-add{height:30px;padding:0 12px;border-radius:var(--radius-xs);background:var(--orange);color:#fff;border:none;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;cursor:pointer;transition:all var(--T);display:inline-flex;align-items:center;gap:5px}
.btn-add:hover{background:var(--orange2);color:#fff}
.btn-add.added{background:var(--success)}
.alert{padding:12px 18px;border-radius:var(--radius-sm);margin-bottom:20px;display:flex;align-items:center;gap:10px}
.alert-success{background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.4);color:#22C55E}
.alert-error{background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.4);color:#EF4444}
.toast{position:fixed;bottom:22px;right:22px;z-index:999;background:var(--bg3);border:1px solid var(--border2);border-radius:var(--radius-sm);padding:12px 18px;font-size:13px;color:var(--text);box-shadow:0 8px 32px rgba(0,0,0,.5);transform:translateY(80px);opacity:0;transition:all .3s;pointer-events:none;display:flex;align-items:center;gap:9px}
.toast.show{transform:translateY(0);opacity:1}
.toast i{color:var(--success)}
.btn-primary{display:inline-flex;align-items:center;gap:8px;background:var(--orange);color:#fff;padding:10px 20px;border-radius:var(--radius-sm);font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;text-decoration:none}
.btn-primary:hover{background:var(--orange2);color:#fff}
.btn-secondary{display:inline-flex;align-items:center;gap:8px;background:var(--bg3);color:var(--text);padding:10px 20px;border-radius:var(--radius-sm);border:1px solid var(--border);font-size:13px;cursor:pointer;text-decoration:none}
.btn-secondary:hover{border-color:var(--orange);color:var(--orange)}
.btn-danger{background:var(--danger);color:#fff;padding:8px 14px;border-radius:var(--radius-sm);border:none;font-size:12px;cursor:pointer}
.btn-danger:hover{opacity:.9}
.pagination{display:flex;gap:8px;margin-top:24px;flex-wrap:wrap}
.pagination a,.pagination span{padding:8px 14px;border-radius:var(--radius-sm);background:var(--bg3);border:1px solid var(--border);color:var(--text);font-size:13px;text-decoration:none}
.pagination a:hover{border-color:var(--orange);color:var(--orange)}
.pagination .current{background:rgba(255,107,53,.2);border-color:var(--orange);color:var(--orange)}
</style>
@stack('styles')
</head>
<body class="buyer-app">

<nav class="navbar">
  <a href="{{ route('buyer.home') }}" class="nav-logo">Nex<span>Shop</span></a>
  <form action="{{ route('buyer.products.index') }}" method="get" class="nav-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un produit…">
  </form>
  <div class="nav-right">
    <a href="{{ route('buyer.favorites.index') }}" class="nav-icon" title="Favoris"><i class="fa-regular fa-heart"></i></a>
    <a href="{{ route('buyer.cart.index') }}" class="nav-icon" title="Panier">
      <i class="fa-solid fa-bag-shopping"></i>
      @php $cartCount = auth()->user()->panier()->count(); @endphp
      @if($cartCount > 0)<span class="nav-badge">{{ $cartCount }}</span>@endif
    </a>
    <a href="{{ route('buyer.profile.edit') }}" class="nav-avatar" title="Mon profil">
      <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nom) }}&background=FF6B35&color=fff" alt="">
    </a>
  </div>
</nav>

<div class="sub-nav">
  <div class="sub-nav-inner">
    <a href="{{ route('buyer.home') }}" class="nav-tab {{ request()->routeIs('buyer.home') ? 'active' : '' }}">Explorer</a>
    <a href="{{ route('buyer.orders.index') }}" class="nav-tab {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}">Mes Commandes</a>
    <a href="{{ route('buyer.profile.edit') }}" class="nav-tab {{ request()->routeIs('buyer.profile.*') ? 'active' : '' }}">Mon Profil</a>
    <form action="{{ route('logout') }}" method="post" style="margin-left:auto;display:flex;align-items:center">
      @csrf
      <button type="submit" class="nav-tab" style="cursor:pointer;font-size:13px" title="Se déconnecter">Déconnexion</button>
    </form>
  </div>
</div>

<div class="page-container">
  @if(session('success'))
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-error"><i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-error"><i class="fa-solid fa-exclamation-circle"></i> {{ $errors->first() }}</div>
  @endif

  @yield('content')
</div>

<footer class="footer">
  <div class="footer-grid">
    <div>
      <div class="f-logo">Nex<span>Shop</span></div>
      <p class="f-desc">La marketplace qui connecte acheteurs et vendeurs. Paiement en espèces, livraison rapide.</p>
      <div class="f-socials">
        <a href="#" class="soc-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" class="soc-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" class="soc-btn" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="#" class="soc-btn" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
      </div>
    </div>
    <div>
      <div class="f-col-title">Navigation</div>
      <ul class="f-links">
        <li><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-right"></i>Accueil</a></li>
        <li><a href="{{ route('buyer.home') }}"><i class="fa-solid fa-chevron-right"></i>Produits</a></li>
        <li><a href="{{ route('buyer.cart.index') }}"><i class="fa-solid fa-chevron-right"></i>Panier</a></li>
        <li><a href="{{ route('buyer.orders.index') }}"><i class="fa-solid fa-chevron-right"></i>Mes commandes</a></li>
      </ul>
    </div>
    <div>
      <div class="f-col-title">Informations</div>
      <ul class="f-links">
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>À propos</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Politique de livraison</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>CGU & CGV</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Confidentialité</a></li>
      </ul>
    </div>
    <div>
      <div class="f-col-title">Contact</div>
      <div class="f-contact"><i class="fa-solid fa-location-dot"></i><span>Djibouti, République de Djibouti</span></div>
      <div class="f-contact"><i class="fa-solid fa-phone"></i><span>+253 77 00 00 00</span></div>
      <div class="f-contact"><i class="fa-solid fa-envelope"></i><span>contact@nexshop.dj</span></div>
      <div class="f-contact"><i class="fa-solid fa-clock"></i><span>Lun–Sam : 8h – 17h</span></div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ date('Y') }} NexShop. Tous droits réservés.</span>
    <div class="pay-chips">
      <div class="pay-chip"><i class="fa-solid fa-money-bill-wave"></i> Espèces</div>
      <div class="pay-chip"><i class="fa-solid fa-truck-fast"></i> Livraison</div>
      <div class="pay-chip"><i class="fa-solid fa-shield-halved"></i> Sécurisé</div>
    </div>
  </div>
</footer>

@stack('scripts')
</body>
</html>
