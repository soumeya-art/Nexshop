<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NexShop — Marketplace</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}"></head>
<body>

<!-- TOPBAR -->
<div class="topbar">
  <i class="fa-solid fa-truck-fast"></i> Livraison gratuite dès 49€
  &nbsp;|&nbsp;
  <i class="fa-solid fa-money-bill-wave"></i> Paiement en espèces à la livraison
  &nbsp;|&nbsp;
  <i class="fa-solid fa-shield-halved"></i> Achats sécurisés
</div>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="nav-logo">Nex<span>Shop</span></div>

  <div class="search-wrap">
    <input type="text" placeholder="Rechercher un produit, une marque…">
    <button><i class="fa-solid fa-magnifying-glass"></i></button>
  </div>

  <ul class="nav-cats">
    <li><a href="#">Mode</a></li>
    <li><a href="#">Électronique</a></li>
    <li><a href="#">Gaming</a></li>
    <li><a href="#">Sport</a></li>
    <li><a href="#">Beauté</a></li>
    <li><a href="#">Maison</a></li>
  </ul>

  <div class="nav-right">
    <button class="icon-btn"><i class="fa-regular fa-heart"></i></button>
    <button class="icon-btn">
      <i class="fa-solid fa-bag-shopping"></i>
      <span class="badge">3</span>
    </button>
    <a href="{{ route('login') }}" class="btn-login">Connexion</a>
    <a href="{{ route('register') }}" class="btn-signup">S'inscrire</a>
  </div>

  <button class="hamburger" onclick="toggleDrawer()"><i class="fa-solid fa-bars"></i></button>
</nav>

<!-- DRAWER -->
<div class="drawer-overlay" id="overlay" onclick="toggleDrawer()"></div>
<div class="drawer" id="drawer">
  <button class="drawer-close" onclick="toggleDrawer()"><i class="fa-solid fa-xmark"></i></button>
  <div class="drawer-logo">Nex<span>Shop</span></div>
  <ul class="drawer-links">
    <li><a href="#"><i class="fa-solid fa-shirt"></i>Mode</a></li>
    <li><a href="#"><i class="fa-solid fa-laptop"></i>Électronique</a></li>
    <li><a href="#"><i class="fa-solid fa-couch"></i>Maison</a></li>
    <li><a href="#"><i class="fa-solid fa-gamepad"></i>Gaming</a></li>
    <li><a href="#"><i class="fa-solid fa-dumbbell"></i>Sport</a></li>
    <li><a href="#"><i class="fa-regular fa-heart"></i>Favoris</a></li>
    <li><a href="#"><i class="fa-solid fa-bag-shopping"></i>Panier</a></li>
    <li><a href="#"><i class="fa-regular fa-user"></i>Compte</a></li>
  </ul>
  <div class="drawer-btns">
    <a href="{{ route('login') }}" class="btn-signup" style="border-radius:10px;padding:13px;display:block;text-align:center">Connexion</a>
    <a href="{{ route('register') }}" class="btn-login" style="border-radius:10px;padding:13px;display:block;text-align:center">S'inscrire</a>
  </div>
</div>

<!-- HERO -->
<section class="hero">
  <div class="hero-left">
    <div class="hero-tag"><i class="fa-solid fa-bolt"></i> Marketplace #1 en Djibouti</div>
    <h1 class="hero-title">
      Tout ce dont<br>tu as besoin,<br>
      <span class="accent">livré</span> chez toi.
    </h1>
    <p class="hero-desc">
      Des milliers de produits de vendeurs certifiés.
      <strong>Paiement en espèces</strong> à la livraison — aucune carte requise.
    </p>
    <div class="hero-btns">
      <button class="btn-primary">
        <i class="fa-solid fa-arrow-right"></i> Acheter maintenant
      </button>
      <button class="btn-ghost">
        <i class="fa-solid fa-store"></i> Devenir vendeur
      </button>
    </div>
    <div class="hero-stats">
      <div><div class="stat-num">12K+</div><div class="stat-label">Produits</div></div>
      <div><div class="stat-num">1.2K</div><div class="stat-label">Vendeurs</div></div>
      <div><div class="stat-num">4.9★</div><div class="stat-label">Note moyenne</div></div>
    </div>
  </div>

  <div class="hero-right">
    <img src="{{ asset('images\shopping.png')}}" alt="Shopping">
    <div class="hero-float">
      <div class="float-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
      <div>
        <div class="float-title">Paiement en espèces</div>
        <div class="float-sub">À la réception du colis</div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<div class="features">
  <div class="feat"><div class="feat-ico"><i class="fa-solid fa-truck-fast"></i></div><div><div class="feat-title">Livraison rapide</div><div class="feat-sub">Gratuite dès 49€</div></div></div>
  <div class="feat"><div class="feat-ico"><i class="fa-solid fa-money-bill-wave"></i></div><div><div class="feat-title">Espèces uniquement</div><div class="feat-sub">Paiement à la réception</div></div></div>
  <div class="feat"><div class="feat-ico"><i class="fa-solid fa-rotate-left"></i></div><div><div class="feat-title">Retours 30 jours</div><div class="feat-sub">Sans frais</div></div></div>
  <div class="feat"><div class="feat-ico"><i class="fa-solid fa-headset"></i></div><div><div class="feat-title">Support 24/7</div><div class="feat-sub">Toujours là pour toi</div></div></div>
</div>

<!-- CATÉGORIES -->
<section class="section reveal">
  <div class="sec-head">
    <div><div class="sec-tag">Collections</div><h2 class="sec-title">Explore les catégories</h2></div>
    <a href="#" class="see-all">Tout voir <i class="fa-solid fa-arrow-right"></i></a>
  </div>
    <div class="cats-grid">
    <div class="cat-card"><img src="{{ asset('images\vetement_0-3mois.png')}}" alt="Bébés"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-baby"></i></div><div class="cat-name">Bébés</div><div class="cat-count">1 240 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\nike-air-max-90.png')}}" alt="Sport"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-dumbbell"></i></div><div class="cat-name">Sport</div><div class="cat-count">2 180 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\housse_pour_voiture.png')}}" alt="Voitures"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-car"></i></div><div class="cat-name">Voitures</div><div class="cat-count">890 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\gaming.png')}}" alt="Gaming"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-gamepad"></i></div><div class="cat-name">Gaming</div><div class="cat-count">740 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\table_assi_debout.jpg')}}" alt="Bureau"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-graduation-cap"></i></div><div class="cat-name">Scolaires & Bureau</div><div class="cat-count">1 560 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\bracelet_bien_etre.png')}}" alt="Santé"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-heart-pulse"></i></div><div class="cat-name">Santé & Bien-être</div><div class="cat-count">980 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\canape2per.png')}}" alt="Maison"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-house"></i></div><div class="cat-name">Maison</div><div class="cat-count">3 150 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\macbook14.png')}}" alt="Électronique"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-microchip"></i></div><div class="cat-name">Électronique</div><div class="cat-count">1 620 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\mode.png')}}" alt="Montres"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-clock"></i></div><div class="cat-name">Montres & Accessoires</div><div class="cat-count">670 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\beaute.png')}}" alt="Beauté"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-spa"></i></div><div class="cat-name">Beauté</div><div class="cat-count">2 340 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\vetement&mode.png')}}" alt="Mode"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-shirt"></i></div><div class="cat-name">Vêtements & Mode</div><div class="cat-count">2 840 produits</div></div></div>
    <div class="cat-card"><img src="{{ asset('images\telephone.png')}}" alt="Téléphones"><div class="cat-info"><div class="cat-ico"><i class="fa-solid fa-mobile-screen"></i></div><div class="cat-name">Téléphones</div><div class="cat-count">1 120 produits</div></div></div>
  </div>
</section>

<!-- PRODUITS -->
<section class="section reveal" style="padding-top:0">
  <div class="sec-head">
    <div><div class="sec-tag">Tendances</div><h2 class="sec-title">Produits populaires</h2></div>
    <a href="#" class="see-all">Tout voir <i class="fa-solid fa-arrow-right"></i></a>
  </div>
    <div class="cat-filters">
    <button class="cf-btn active" onclick="filterCat(this,'all')">Tous</button>
    <button class="cf-btn" onclick="filterCat(this,'Bébés')">👶 Bébés</button>
    <button class="cf-btn" onclick="filterCat(this,'Sport')">🏋️ Sport</button>
    <button class="cf-btn" onclick="filterCat(this,'Voitures')">🚗 Voitures</button>
    <button class="cf-btn" onclick="filterCat(this,'Gaming')">🎮 Gaming</button>
    <button class="cf-btn" onclick="filterCat(this,'Scolaires & Bureau')">📚 Bureau</button>
    <button class="cf-btn" onclick="filterCat(this,'Santé & Bien-être')">💊 Santé</button>
    <button class="cf-btn" onclick="filterCat(this,'Maison')">🏠 Maison</button>
    <button class="cf-btn" onclick="filterCat(this,'Électronique')">💻 Électronique</button>
    <button class="cf-btn" onclick="filterCat(this,'Montres & Accessoires')">⌚ Montres</button>
    <button class="cf-btn" onclick="filterCat(this,'Beauté')">💄 Beauté</button>
    <button class="cf-btn" onclick="filterCat(this,'Vêtements & Mode')">👗 Mode</button>
    <button class="cf-btn" onclick="filterCat(this,'Téléphones')">📱 Téléphones</button>
  </div>
    <div class="prods-grid" id="prods-grid">

    <!-- ══ BÉBÉS ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\boussette_a_4roues.png')}}" alt="Poussette"><span class="prod-badge">-20%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Bébés</div><div class="prod-name">Poussette 4 Roues Confort</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(94)</span></div><div class="prod-foot"><div><span class="prod-price">249€</span><span class="prod-old">319€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\lit_a_barreaux.png')}}" alt="Lit bébé"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Bébés</div><div class="prod-name">Lit à Barreaux Évolutif</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(61)</span></div><div class="prod-foot"><span class="prod-price">189€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\tapis_evil_mus.png')}}" alt="Jouets"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Bébés</div><div class="prod-name">Tapis d'Éveil Musical</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(113)</span></div><div class="prod-foot"><span class="prod-price">45€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\vetement_0-3mois.png')}}" alt="Vêtements bébé"><span class="prod-badge">-30%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Bébés</div><div class="prod-name">Pack Vêtements 0-3 Mois</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(77)</span></div><div class="prod-foot"><div><span class="prod-price">35€</span><span class="prod-old">50€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ SPORT ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\velo.png')}}" alt="Vélo"><span class="prod-badge">-15%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Sport</div><div class="prod-name">Vélo de Route Carbon 21V</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(142)</span></div><div class="prod-foot"><div><span class="prod-price">599€</span><span class="prod-old">699€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\haltere-reglable-40-kg.png')}}" alt="Haltères"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Sport</div><div class="prod-name">Set Haltères Réglables 40kg</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(205)</span></div><div class="prod-foot"><span class="prod-price">129€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\nike-air-max2026.png')}}" alt="Chaussures sport"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Sport</div><div class="prod-name">Nike Air Max 2026</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(387)</span></div><div class="prod-foot"><span class="prod-price">149€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\tapis_yoga.webp')}}" alt="Tapis yoga"><span class="prod-badge">-25%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Sport</div><div class="prod-name">Tapis Yoga Antidérapant</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(156)</span></div><div class="prod-foot"><div><span class="prod-price">39€</span><span class="prod-old">52€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ VOITURES ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\Auto-siege-bebe.png')}}" alt="Siège auto"><span class="prod-badge">-10%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Voitures</div><div class="prod-name">Siège Auto Bébé Groupe 0+</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(88)</span></div><div class="prod-foot"><div><span class="prod-price">179€</span><span class="prod-old">199€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\dashcam_cam1.png')}}" alt="Dashcam"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Voitures</div><div class="prod-name">Dashcam 4K WiFi GPS</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(223)</span></div><div class="prod-foot"><span class="prod-price">89€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\housse_pour_voiture.png')}}" alt="Housse voiture"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Voitures</div><div class="prod-name">Housse Protection Voiture</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(67)</span></div><div class="prod-foot"><span class="prod-price">49€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\tomtom.png')}}" alt="GPS"><span class="prod-badge">-20%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Voitures</div><div class="prod-name">GPS Tomtom Go 620</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(134)</span></div><div class="prod-foot"><div><span class="prod-price">119€</span><span class="prod-old">149€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ GAMING ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\gaming.png')}}" alt="PS5"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Gaming</div><div class="prod-name">PlayStation 5 Slim</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(521)</span></div><div class="prod-foot"><span class="prod-price">549€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\clavier gaming.png')}}" alt="Clavier"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Gaming</div><div class="prod-name">Clavier Mécanique RGB</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(203)</span></div><div class="prod-foot"><span class="prod-price">129€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\chaise gaming.png')}}" alt="Chaise gaming"><span class="prod-badge">-18%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Gaming</div><div class="prod-name">Chaise Gaming Pro Ergonomique</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(312)</span></div><div class="prod-foot"><div><span class="prod-price">299€</span><span class="prod-old">365€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\Gaming audio.png')}}" alt="Casque gaming"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Gaming</div><div class="prod-name">Casque Gaming 7.1 Surround</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(189)</span></div><div class="prod-foot"><span class="prod-price">89€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ SCOLAIRES & BUREAU ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\sac ecole.png')}}" alt="Sac école"><span class="prod-badge">-22%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Scolaires & Bureau</div><div class="prod-name">Cartable Ergonomique 18L</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(145)</span></div><div class="prod-foot"><div><span class="prod-price">55€</span><span class="prod-old">70€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Bureau"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Scolaires & Bureau</div><div class="prod-name">Bureau Réglable Debout/Assis</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(98)</span></div><div class="prod-foot"><span class="prod-price">349€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\imprimante_laser.png')}}" alt="Imprimante"><span class="prod-badge">-15%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Scolaires & Bureau</div><div class="prod-name">Imprimante Laser Wi-Fi</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(167)</span></div><div class="prod-foot"><div><span class="prod-price">129€</span><span class="prod-old">152€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\Set Stylos Premium 12 pcs.png')}}" alt="Stylo"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Scolaires & Bureau</div><div class="prod-name">Set Stylos Premium 12 pcs</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(234)</span></div><div class="prod-foot"><span class="prod-price">19€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ SANTÉ & BIEN-ÊTRE ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\bracelet_bien_etre.png')}}" alt="Smartwatch santé"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Santé & Bien-être</div><div class="prod-name">Bracelet Santé Connecté</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(289)</span></div><div class="prod-foot"><span class="prod-price">79€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\huille_essentielle.png')}}" alt="Huiles"><span class="prod-badge">-20%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Santé & Bien-être</div><div class="prod-name">Huiles Essentielles Bio 10 pcs</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(178)</span></div><div class="prod-foot"><div><span class="prod-price">29€</span><span class="prod-old">36€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\tapis_yoga.webp')}}" alt="Yoga"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Santé & Bien-être</div><div class="prod-name">Diffuseur Arômes Ultrasonique</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(412)</span></div><div class="prod-foot"><span class="prod-price">45€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\Balance Connectée IMC.png')}}" alt="Balance"><span class="prod-badge">-30%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Santé & Bien-être</div><div class="prod-name">Balance Connectée IMC</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(123)</span></div><div class="prod-foot"><div><span class="prod-price">35€</span><span class="prod-old">50€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ MAISON ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\canape2per.png')}}" alt="Canapé"><span class="prod-badge">-25%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Maison</div><div class="prod-name">Canapé Convertible 2 Places</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(156)</span></div><div class="prod-foot"><div><span class="prod-price">499€</span><span class="prod-old">665€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\aspirateur.png')}}" alt="Robot aspirateur"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Maison</div><div class="prod-name">Robot Aspirateur Wi-Fi</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(341)</span></div><div class="prod-foot"><span class="prod-price">299€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\robot_cuissiner.png')}}" alt="Cuisine"><span class="prod-badge">-18%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Maison</div><div class="prod-name">Robot Cuiseur Multifonction</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(267)</span></div><div class="prod-foot"><div><span class="prod-price">219€</span><span class="prod-old">267€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\Lampe LED Ambiance Smart.png')}}" alt="Lampe"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Maison</div><div class="prod-name">Lampe LED Ambiance Smart</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(198)</span></div><div class="prod-foot"><span class="prod-price">59€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ ÉLECTRONIQUE ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\iMac 24 M3 Argent.png')}}" alt="iMac"><span class="prod-badge">-20%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Électronique</div><div class="prod-name">iMac 24" M3 Argent</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(128)</span></div><div class="prod-foot"><div><span class="prod-price">1 199€</span><span class="prod-old">1 499€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\tv-smart.png')}}" alt="TV"><span class="prod-badge">-25%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Électronique</div><div class="prod-name">TV Samsung QLED 55"</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(178)</span></div><div class="prod-foot"><div><span class="prod-price">749€</span><span class="prod-old">999€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\audio.png')}}" alt="Casque"><span class="prod-badge">-35%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Électronique</div><div class="prod-name">Casque Sony WH-1000XM5</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(312)</span></div><div class="prod-foot"><div><span class="prod-price">199€</span><span class="prod-old">309€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('images\macbook14.png')}}" alt="Laptop"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Électronique</div><div class="prod-name">MacBook Pro 14" M3 Max</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(445)</span></div><div class="prod-foot"><span class="prod-price">2 199€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ MONTRES & ACCESSOIRES ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Montre"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Montres & Accessoires</div><div class="prod-name">Montre Automatique Acier</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(84)</span></div><div class="prod-foot"><span class="prod-price">289€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Apple Watch"><span class="prod-badge">-12%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Montres & Accessoires</div><div class="prod-name">Apple Watch Series 10</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(631)</span></div><div class="prod-foot"><div><span class="prod-price">439€</span><span class="prod-old">499€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Ceinture"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Montres & Accessoires</div><div class="prod-name">Ceinture Cuir Véritable</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(92)</span></div><div class="prod-foot"><span class="prod-price">49€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Sac"><span class="prod-badge">-15%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Montres & Accessoires</div><div class="prod-name">Sac à Dos Business 30L</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(187)</span></div><div class="prod-foot"><div><span class="prod-price">79€</span><span class="prod-old">93€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ BEAUTÉ ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Maquillage"><span class="prod-badge">-30%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Beauté</div><div class="prod-name">Palette Maquillage 24 Teintes</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(356)</span></div><div class="prod-foot"><div><span class="prod-price">35€</span><span class="prod-old">50€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Soin visage"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Beauté</div><div class="prod-name">Sérum Anti-Âge Vitamine C</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(278)</span></div><div class="prod-foot"><span class="prod-price">39€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Parfum"><span class="prod-badge">-20%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Beauté</div><div class="prod-name">Eau de Parfum 100ml</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(445)</span></div><div class="prod-foot"><div><span class="prod-price">69€</span><span class="prod-old">86€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Lisseur"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Beauté</div><div class="prod-name">Lisseur Cheveux Céramique</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(192)</span></div><div class="prod-foot"><span class="prod-price">55€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ VÊTEMENTS & MODE ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Veste"><span class="prod-badge">-40%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Vêtements & Mode</div><div class="prod-name">Veste Cuir Homme Premium</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(234)</span></div><div class="prod-foot"><div><span class="prod-price">149€</span><span class="prod-old">249€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Robe"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Vêtements & Mode</div><div class="prod-name">Robe Été Florale</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(178)</span></div><div class="prod-foot"><span class="prod-price">45€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Jean"><span class="prod-badge">-25%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Vêtements & Mode</div><div class="prod-name">Jean Slim Stretch Homme</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(312)</span></div><div class="prod-foot"><div><span class="prod-price">49€</span><span class="prod-old">65€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Lunettes"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Vêtements & Mode</div><div class="prod-name">Lunettes Soleil Polarisées</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(156)</span></div><div class="prod-foot"><span class="prod-price">29€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

    <!-- ══ TÉLÉPHONES ══ -->
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="iPhone"><span class="prod-badge new">Nouveau</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Téléphones</div><div class="prod-name">iPhone 16 Pro Max 256Go</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(892)</span></div><div class="prod-foot"><span class="prod-price">1 329€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Samsung"><span class="prod-badge">-18%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Téléphones</div><div class="prod-name">Samsung Galaxy S25 Ultra</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(567)</span></div><div class="prod-foot"><div><span class="prod-price">999€</span><span class="prod-old">1 219€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Coque"><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Téléphones</div><div class="prod-name">Coque Protection MagSafe</div><div class="prod-rating"><span class="stars">★★★★☆</span><span class="reviews">(234)</span></div><div class="prod-foot"><span class="prod-price">25€</span><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>
    <div class="prod-card"><div class="prod-img"><img src="{{ asset('')}}" alt="Chargeur"><span class="prod-badge">-35%</span><div class="prod-actions"><button class="act-btn" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button><button class="act-btn"><i class="fa-regular fa-eye"></i></button></div></div><div class="prod-body"><div class="prod-cat">Téléphones</div><div class="prod-name">Chargeur Sans Fil 45W</div><div class="prod-rating"><span class="stars">★★★★★</span><span class="reviews">(445)</span></div><div class="prod-foot"><div><span class="prod-price">29€</span><span class="prod-old">45€</span></div><button class="add-btn" onclick="addCart(this)"><i class="fa-solid fa-plus"></i></button></div></div></div>

  </div>
</section>

<!-- PROMO -->
<div class="promo-wrap reveal">
  <div class="promo-bg"></div>
  <div class="promo-glow"></div>
  <div class="promo-content">
    <div class="promo-tag"><i class="fa-solid fa-bolt"></i> Vente flash</div>
    <h2 class="promo-title">Jusqu'à <span>-50%</span><br>sur l'électronique</h2>
    <p class="promo-desc">Offre limitée — paiement en espèces à la livraison. Aucune carte requise.</p>
    <div class="countdown">
      <div class="cd-block"><div class="cd-num" id="cd-h">08</div><div class="cd-label">Heures</div></div>
      <div class="cd-block"><div class="cd-num" id="cd-m">24</div><div class="cd-label">Minutes</div></div>
      <div class="cd-block"><div class="cd-num" id="cd-s">00</div><div class="cd-label">Secondes</div></div>
    </div>
    <button class="btn-primary">Voir les offres <i class="fa-solid fa-arrow-right"></i></button>
  </div>
</div>

<!-- AVIS -->
<section class="section reveal">
  <div class="sec-head">
    <div><div class="sec-tag">Témoignages</div><h2 class="sec-title">Ils nous font confiance</h2></div>
  </div>
  <div class="reviews-grid">
    <div class="rev-card"><div class="rev-q">"</div><div class="rev-stars">★★★★★</div><p class="rev-text">Expérience d'achat au top. La livraison était ultra rapide et le paiement en espèces super pratique. Je recommande à 100%.</p><div class="rev-author"><img class="rev-avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&q=80" alt="Sophie"><div><div class="rev-name">Sophie Martin</div><div class="rev-loc">Paris, France</div></div></div></div>
    <div class="rev-card"><div class="rev-q">"</div><div class="rev-stars">★★★★★</div><p class="rev-text">Des produits de qualité à des prix imbattables. Le vendeur était très pro et le suivi de commande parfait.</p><div class="rev-author"><img class="rev-avatar" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80" alt="Lucas"><div><div class="rev-name">Lucas Bernard</div><div class="rev-loc">Lyon, France</div></div></div></div>
    <div class="rev-card"><div class="rev-q">"</div><div class="rev-stars">★★★★★</div><p class="rev-text">J'utilise NexShop depuis 6 mois pour ma boutique. Mes ventes ont explosé de 40%. Les outils vendeur sont excellents.</p><div class="rev-author"><img class="rev-avatar" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&q=80" alt="Amina"><div><div class="rev-name">Amina Karim</div><div class="rev-loc">Marseille, France</div></div></div></div>
  </div>
</section>

<!-- NEWSLETTER -->

<!-- ══ BOUTIQUES PARTENAIRES ══ -->
<section class="section reveal" style="padding-top:0">
  <div class="sec-head">
    <div><div class="sec-tag">Vendeurs certifiés</div><h2 class="sec-title">Boutiques à la une</h2></div>
    <a href="#" class="see-all">Voir toutes <i class="fa-solid fa-arrow-right"></i></a>
  </div>
  <div class="shops-grid">

    <div class="shop-card">
      <div class="shop-banner"><img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&q=80" alt="TechZone"></div>
      <div class="shop-body">
        <div class="shop-avatar"><img src="https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=80&q=80" alt="TechZone"></div>
        <div class="shop-info">
          <div class="shop-name">TechZone Pro <i class="fa-solid fa-circle-check"></i></div>
          <div class="shop-cat">Électronique & Gadgets</div>
          <div class="shop-stats">
            <span><i class="fa-solid fa-star"></i> 4.9</span>
            <span><i class="fa-solid fa-box"></i> 1 240 produits</span>
            <span><i class="fa-solid fa-users"></i> 8.2K abonnés</span>
          </div>
          <p class="shop-desc">Spécialiste en électronique haut de gamme. Livraison express, garantie 2 ans sur tous les produits.</p>
          <div class="shop-tags"><span class="stag">iPhone</span><span class="stag">MacBook</span><span class="stag">Samsung</span></div>
        </div>
        <a href="#" class="btn-shop">Visiter la boutique <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>

    <div class="shop-card">
      <div class="shop-banner"><img src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?w=600&q=80" alt="ModaStyle"></div>
      <div class="shop-body">
        <div class="shop-avatar"><img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=80&q=80" alt="ModaStyle"></div>
        <div class="shop-info">
          <div class="shop-name">ModaStyle <i class="fa-solid fa-circle-check"></i></div>
          <div class="shop-cat">Vêtements & Mode</div>
          <div class="shop-stats">
            <span><i class="fa-solid fa-star"></i> 4.8</span>
            <span><i class="fa-solid fa-box"></i> 2 840 produits</span>
            <span><i class="fa-solid fa-users"></i> 15K abonnés</span>
          </div>
          <p class="shop-desc">Tendances mode pour femmes et hommes. Collections mises à jour chaque semaine, retours gratuits.</p>
          <div class="shop-tags"><span class="stag">Robes</span><span class="stag">Vestes</span><span class="stag">Accessoires</span></div>
        </div>
        <a href="#" class="btn-shop">Visiter la boutique <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>

    <div class="shop-card">
      <div class="shop-banner"><img src="https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=600&q=80" alt="BeautyHub"></div>
      <div class="shop-body">
        <div class="shop-avatar"><img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=80&q=80" alt="BeautyHub"></div>
        <div class="shop-info">
          <div class="shop-name">BeautyHub <i class="fa-solid fa-circle-check"></i></div>
          <div class="shop-cat">Beauté & Bien-être</div>
          <div class="shop-stats">
            <span><i class="fa-solid fa-star"></i> 4.7</span>
            <span><i class="fa-solid fa-box"></i> 980 produits</span>
            <span><i class="fa-solid fa-users"></i> 6.5K abonnés</span>
          </div>
          <p class="shop-desc">Produits de beauté naturels et bio. Certifiés cruelty-free, 100% testés par nos expertes beauté.</p>
          <div class="shop-tags"><span class="stag">Bio</span><span class="stag">Skincare</span><span class="stag">Parfums</span></div>
        </div>
        <a href="#" class="btn-shop">Visiter la boutique <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>

    <div class="shop-card">
      <div class="shop-banner"><img src="https://images.unsplash.com/photo-1593640408182-31c228b3e5f5?w=600&q=80" alt="GamersWorld"></div>
      <div class="shop-body">
        <div class="shop-avatar"><img src="https://images.unsplash.com/photo-1607853202273-797f1c22a38e?w=80&q=80" alt="GamersWorld"></div>
        <div class="shop-info">
          <div class="shop-name">GamersWorld <i class="fa-solid fa-circle-check"></i></div>
          <div class="shop-cat">Gaming & High-Tech</div>
          <div class="shop-stats">
            <span><i class="fa-solid fa-star"></i> 4.9</span>
            <span><i class="fa-solid fa-box"></i> 740 produits</span>
            <span><i class="fa-solid fa-users"></i> 12K abonnés</span>
          </div>
          <p class="shop-desc">Tout pour les gamers : consoles, périphériques, jeux. Prix imbattables et stock toujours disponible.</p>
          <div class="shop-tags"><span class="stag">PS5</span><span class="stag">Xbox</span><span class="stag">PC Gaming</span></div>
        </div>
        <a href="#" class="btn-shop">Visiter la boutique <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>

  </div>

  <!-- CTA Vendeur -->
  <div class="seller-cta reveal">
    <div class="seller-cta-left">
      <div class="sec-tag">Rejoins-nous</div>
      <h3 class="seller-cta-title">Tu as une boutique ?<br><span>Vends sur NexShop</span></h3>
      <p class="seller-cta-desc">Rejoins plus de 1 200 vendeurs certifiés. Crée ta boutique gratuitement et commence à vendre dès aujourd'hui.</p>
      <div class="seller-perks">
        <div class="perk"><i class="fa-solid fa-check"></i> Inscription 100% gratuite</div>
        <div class="perk"><i class="fa-solid fa-check"></i> Tableau de bord vendeur complet</div>
        <div class="perk"><i class="fa-solid fa-check"></i> Paiement espèces garanti</div>
        <div class="perk"><i class="fa-solid fa-check"></i> Support dédié 7j/7</div>
      </div>
      <button class="btn-primary" style="margin-top:28px"><i class="fa-solid fa-store"></i> Créer ma boutique</button>
    </div>
    <div class="seller-cta-right">
      <div class="seller-stat-grid">
        <div class="seller-stat"><div class="ss-num">1 200+</div><div class="ss-label">Vendeurs actifs</div></div>
        <div class="seller-stat"><div class="ss-num">48K+</div><div class="ss-label">Clients satisfaits</div></div>
        <div class="seller-stat"><div class="ss-num">12K+</div><div class="ss-label">Produits listés</div></div>
        <div class="seller-stat"><div class="ss-num">4.9★</div><div class="ss-label">Note moyenne</div></div>
      </div>
    </div>
  </div>
</section>
<!-- ══ CONTACT ══ -->
<section class="section reveal" id="contact">

  <div class="contact-bg">
    <img src="{{ asset('images/contact.jpg') }}" alt="">
  </div>

  <div class="sec-head" style="position:relative;z-index:2">
    <div>
      <div class="sec-tag">Nous contacter</div>
      <h2 class="sec-title">Une question ? On répond</h2>
    </div>
  </div>

  <div class="contact-grid">

    <div class="contact-infos">
      <div class="contact-item">
        <div class="contact-ico"><i class="fa-solid fa-location-dot"></i></div>
        <div>
          <div class="contact-item-title">Adresse</div>
          <div class="contact-item-val">Djibouti, République de Djibouti</div>
        </div>
      </div>
      <div class="contact-item">
        <div class="contact-ico"><i class="fa-solid fa-phone"></i></div>
        <div>
          <div class="contact-item-title">Téléphone</div>
          <div class="contact-item-val">+253 77 00 00 00</div>
        </div>
      </div>
      <div class="contact-item">
        <div class="contact-ico"><i class="fa-solid fa-envelope"></i></div>
        <div>
          <div class="contact-item-title">Email</div>
          <div class="contact-item-val">contact@nexshop.dj</div>
        </div>
      </div>
      <div class="contact-item">
        <div class="contact-ico"><i class="fa-solid fa-clock"></i></div>
        <div>
          <div class="contact-item-title">Horaires</div>
          <div class="contact-item-val">Lun–Sam : 8h – 17h</div>
        </div>
      </div>
      <div class="contact-socials">
        <a href="#" class="csoc"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" class="csoc"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" class="csoc"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="#" class="csoc"><i class="fa-brands fa-tiktok"></i></a>
      </div>
    </div>

    <div class="contact-form-wrap">
      <form class="contact-form" onsubmit="submitContact(event)">
        <div class="form-row">
          <div class="form-group">
            <label>Prénom & Nom</label>
            <input type="text" placeholder="Sophie Martin" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" placeholder="sophie@email.com" required>
          </div>
        </div>
        <div class="form-group">
          <label>Sujet</label>
          <select>
            <option value="">Choisir un sujet…</option>
            <option>Question sur une commande</option>
            <option>Problème de livraison</option>
            <option>Devenir vendeur</option>
            <option>Signaler un problème</option>
            <option>Autre</option>
          </select>
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea placeholder="Décris ta demande en détail…" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center">
          <i class="fa-solid fa-paper-plane"></i> Envoyer le message
        </button>
      </form>
    </div>

  </div>
</section>
<div class="newsletter reveal">
  <h2 class="nl-title">Ne rate aucune <span>offre exclusive</span></h2>
  <p class="nl-sub">Inscris-toi et reçois nos meilleures promotions en avant-première.</p>
  <div class="nl-form">
    <input type="email" placeholder="Ton adresse email…">
    <button><i class="fa-solid fa-paper-plane"></i> S'inscrire</button>
  </div>
</div>
<!-- ══ DESTINATIONS DJIBOUTI ══ -->
<section class="dj-section reveal">
  <div class="sec-head">
    <div>
      <div class="sec-tag"><i class="fa-solid fa-location-dot"></i> Découvrir Djibouti</div>
      <h2 class="sec-title">Les lieux incontournables</h2>
      <p class="sec-sub">Explorez les merveilles naturelles de Djibouti</p>
    </div>
  </div>

  <div class="dj-grid">

    <div class="dj-card dj-card--large">
      <div class="dj-img-wrap">
        <img src="{{ asset('images/vacance.png') }}" alt="Plage de Djibouti">
        <div class="dj-overlay"></div>
      </div>
      <div class="dj-content">
        <div class="dj-tag"><i class="fa-solid fa-umbrella-beach"></i> Plage</div>
        <h3 class="dj-title">Plages Paradisiaques</h3>
        <p class="dj-desc">Détendez-vous sur les plus belles plages de sable blanc baignées par les eaux turquoise du Golfe d'Aden.</p>
        <div class="dj-meta">
          <span><i class="fa-solid fa-star"></i> 4.9</span>
          <span><i class="fa-solid fa-users"></i> 2.4K visites</span>
        </div>
        <button class="dj-btn">Découvrir <i class="fa-solid fa-arrow-right"></i></button>
      </div>
    </div>

    <div class="dj-card">
      <div class="dj-img-wrap">
        <img src="{{ asset('images/ile moucha.png') }}" alt="Île Moucha">
        <div class="dj-overlay"></div>
      </div>
      <div class="dj-content">
        <div class="dj-tag"><i class="fa-solid fa-water"></i> Île</div>
        <h3 class="dj-title">Île Moucha</h3>
        <p class="dj-desc">Un archipel corallien aux eaux cristallines, paradis des plongeurs et snorkelers.</p>
        <div class="dj-meta">
          <span><i class="fa-solid fa-star"></i> 4.8</span>
          <span><i class="fa-solid fa-users"></i> 1.8K visites</span>
        </div>
        <button class="dj-btn">Découvrir <i class="fa-solid fa-arrow-right"></i></button>
      </div>
    </div>

    <div class="dj-card">
      <div class="dj-img-wrap">
        <img src="{{ asset('images/sable blanche.png') }}" alt="Sables Blancs">
        <div class="dj-overlay"></div>
      </div>
      <div class="dj-content">
        <div class="dj-tag"><i class="fa-solid fa-sun"></i> Nature</div>
        <h3 class="dj-title">Sables Blancs</h3>
        <p class="dj-desc">Des paysages sauvages et authentiques entre mer turquoise et falaises rocheuses.</p>
        <div class="dj-meta">
          <span><i class="fa-solid fa-star"></i> 4.7</span>
          <span><i class="fa-solid fa-users"></i> 1.2K visites</span>
        </div>
        <button class="dj-btn">Découvrir <i class="fa-solid fa-arrow-right"></i></button>
      </div>
    </div>

  </div>

  <!-- BANDEAU ANIMÉ -->
  <div class="dj-ticker-wrap">
    <div class="dj-ticker">
      <span>🌊 Île Moucha</span><span>•</span>
      <span>🏖️ Plage du Lagon Bleu</span><span>•</span>
      <span>🦈 Plongée avec les requins baleines</span><span>•</span>
      <span>🌋 Lac Assal</span><span>•</span>
      <span>🦒 Forêt du Day</span><span>•</span>
      <span>🐬 Golfe de Tadjourah</span><span>•</span>
      <span>🌊 Île Moucha</span><span>•</span>
      <span>🦈 Plongée avec les requins baleines</span><span>•</span>
      <span>🌋 Lac Assal</span><span>•</span>
      <span>🦒 Forêt du Day</span><span>•</span>
      <span>🐬 Golfe de Tadjourah</span>
    </div>
  </div>

</section>
<!-- FOOTER -->
<footer class="footer">
  <div class="footer-grid">
    <div>
      <div class="f-logo">Nex<span>Shop</span></div>
      <p class="f-desc">La marketplace qui connecte acheteurs et vendeurs partout en France. Paiement en espèces, livraison rapide.</p>
      <div class="f-socials">
        <button class="soc-btn"><i class="fa-brands fa-instagram"></i></button>
        <button class="soc-btn"><i class="fa-brands fa-facebook-f"></i></button>
        <button class="soc-btn"><i class="fa-brands fa-x-twitter"></i></button>
        <button class="soc-btn"><i class="fa-brands fa-tiktok"></i></button>
      </div>
    </div>
    <div>
      <div class="f-col-title">Navigation</div>
      <ul class="f-links">
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Accueil</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Produits</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Catégories</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Promotions</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Devenir vendeur</a></li>
      </ul>
    </div>
    <div>
      <div class="f-col-title">Informations</div>
      <ul class="f-links">
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>À propos</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Politique de livraison</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Retours & remboursements</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>CGU & CGV</a></li>
        <li><a href="#"><i class="fa-solid fa-chevron-right"></i>Confidentialité</a></li>
      </ul>
    </div>
    <div>
      <div class="f-col-title">Contact</div>
      <div class="f-contact"><i class="fa-solid fa-location-dot"></i><span>15 Rue du Commerce, 75015 Paris</span></div>
      <div class="f-contact"><i class="fa-solid fa-phone"></i><span>+33 1 23 45 67 89</span></div>
      <div class="f-contact"><i class="fa-solid fa-envelope"></i><span><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="22414d4c56434156624c475a514a4d520c4450">[email&#160;protected]</a></span></div>
      <div class="f-contact"><i class="fa-solid fa-clock"></i><span>Lun–Sam : 9h – 18h</span></div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2026 NexShop. Tous droits réservés.</span>
    <div class="pay-chips">
      <div class="pay-chip"><i class="fa-solid fa-money-bill-wave"></i> Espèces</div>
      <div class="pay-chip"><i class="fa-solid fa-truck-fast"></i> Livraison</div>
      <div class="pay-chip"><i class="fa-solid fa-shield-halved"></i> Sécurisé</div>
    </div>
  </div>
</footer>

<div class="toast" id="toast"><i class="fa-solid fa-circle-check"></i><span id="tmsg">Action effectuée</span></div>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
function toggleDrawer(){document.getElementById('drawer').classList.toggle('open');document.getElementById('overlay').classList.toggle('open')}
function toggleWish(btn){const i=btn.querySelector('i');const a=btn.classList.toggle('active');i.className=a?'fa-solid fa-heart':'fa-regular fa-heart';showToast(a?'❤️ Ajouté aux favoris':'Retiré des favoris')}
let cart=3;
function addCart(btn){cart++;document.querySelector('.badge').textContent=cart;btn.innerHTML='<i class="fa-solid fa-check"></i>';btn.style.background='#22C55E';setTimeout(()=>{btn.innerHTML='<i class="fa-solid fa-plus"></i>';btn.style.background=''},1400);showToast('🛒 Ajouté au panier !')}
let tt;
function showToast(m){const t=document.getElementById('toast');document.getElementById('tmsg').textContent=m;t.classList.add('show');clearTimeout(tt);tt=setTimeout(()=>t.classList.remove('show'),2800)}
let end=Date.now()+(8*3600+24*60)*1000;
function cd(){const d=Math.max(0,end-Date.now());document.getElementById('cd-h').textContent=String(Math.floor(d/3600000)).padStart(2,'0');document.getElementById('cd-m').textContent=String(Math.floor(d%3600000/60000)).padStart(2,'0');document.getElementById('cd-s').textContent=String(Math.floor(d%60000/1000)).padStart(2,'0')}
cd();setInterval(cd,1000);
const obs=new IntersectionObserver(e=>e.forEach((el,i)=>{if(el.isIntersecting)setTimeout(()=>el.target.classList.add('visible'),i*80)}),{threshold:.1});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));
</script>
</body>
</html>