<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NexShop — Mon Espace Acheteur</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
:root{
  --bg:#0D0D0D;--bg2:#141414;--bg3:#1C1C1C;
  --border:rgba(255,255,255,.07);--border2:rgba(255,255,255,.12);
  --orange:#FF6B35;--orange2:#FF8C5A;
  --blue:#1E90FF;--white:#FFFFFF;--text:#F0F0F0;--muted:#777;--muted2:#444;
  --success:#22C55E;--danger:#EF4444;--warning:#F59E0B;
  --radius:14px;--radius-sm:10px;--radius-xs:7px;--T:.2s ease;
}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;flex-direction:column}
a{text-decoration:none;color:inherit}

/* NAVBAR */
.navbar{height:60px;background:rgba(13,13,13,.96);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 24px;position:sticky;top:0;z-index:100;backdrop-filter:blur(20px);gap:20px}
.nav-logo{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white);white-space:nowrap}
.nav-logo span{color:var(--orange)}
.nav-search{flex:1;max-width:420px;position:relative}
.nav-search input{width:100%;background:var(--bg3);border:1.5px solid var(--border2);border-radius:50px;padding:8px 18px 8px 40px;color:var(--white);font-size:13px;outline:none;transition:border-color var(--T);font-family:'Inter',sans-serif}
.nav-search input:focus{border-color:var(--orange)}
.nav-search i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px}
/* SUB-NAV */
.sub-nav{background:rgba(13,13,13,.96);border-bottom:1px solid var(--border);padding:0 28px;backdrop-filter:blur(20px)}
.sub-nav-inner{display:flex}
.nav-tab{padding:12px 18px;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;border:none;background:none;transition:all var(--T);border-bottom:2.5px solid transparent;margin-bottom:-1px}
.nav-tab:hover{color:var(--text)}
.nav-tab.active{color:var(--orange);border-bottom-color:var(--orange)}
.nav-right{margin-left:auto;display:flex;align-items:center;gap:8px}
.nav-icon{width:36px;height:36px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:14px;cursor:pointer;transition:all var(--T);position:relative}
.nav-icon:hover{border-color:var(--orange);color:var(--orange)}
.nav-badge{position:absolute;top:-4px;right:-4px;width:16px;height:16px;border-radius:50%;background:var(--orange);color:#fff;font-size:9px;font-weight:800;font-family:'Space Grotesk',sans-serif;display:flex;align-items:center;justify-content:center;border:2px solid var(--bg)}
.nav-avatar{width:34px;height:34px;border-radius:50%;border:2px solid var(--orange);overflow:hidden;cursor:pointer}
.nav-avatar img{width:100%;height:100%;object-fit:cover}

/* PAGE CONTAINER */
.page-container{max-width:1280px;margin:0 auto;padding:28px 40px}

/* HERO */
.hero{border-radius:var(--radius);overflow:hidden;margin-bottom:24px;position:relative;height:170px;background:linear-gradient(135deg,#0a1628,#001a40 50%,#0d0d0d);border:1px solid var(--border)}
.hero::before{content:'';position:absolute;inset:0;background:linear-gradient(90deg,rgba(255,107,53,.1),transparent 60%)}
.hero-img{position:absolute;right:0;top:0;height:100%;width:45%;object-fit:cover;opacity:.2}
.hero-content{position:relative;z-index:2;padding:28px 36px;height:100%;display:flex;flex-direction:column;justify-content:center}
.hero-tag{display:inline-flex;align-items:center;gap:5px;background:rgba(255,107,53,.15);border:1px solid rgba(255,107,53,.3);color:var(--orange);font-size:10px;font-weight:700;font-family:'Space Grotesk',sans-serif;padding:3px 10px;border-radius:50px;margin-bottom:10px}
.hero-title{font-family:'Space Grotesk',sans-serif;font-size:26px;font-weight:800;color:var(--white);line-height:1.1;margin-bottom:14px}
.hero-title span{color:var(--orange)}
.hero-btn{display:inline-flex;align-items:center;gap:7px;background:var(--orange);color:#fff;padding:9px 20px;border-radius:50px;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;cursor:pointer;border:none;transition:all var(--T);box-shadow:0 4px 14px rgba(255,107,53,.35)}
.hero-btn:hover{background:var(--orange2)}

/* CAT FILTER */
.cat-bar{display:flex;align-items:center;gap:7px;flex-wrap:wrap;margin-bottom:22px}
.cat-label-txt{font-size:11px;font-weight:700;color:var(--muted2);font-family:'Space Grotesk',sans-serif;letter-spacing:.08em;text-transform:uppercase;display:flex;align-items:center;gap:5px;margin-right:4px}
.cat-chip{background:var(--bg3);border:1.5px solid var(--border);color:var(--muted);padding:6px 14px;border-radius:50px;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:600;cursor:pointer;transition:all var(--T);white-space:nowrap}
.cat-chip:hover{border-color:rgba(255,107,53,.3);color:var(--text)}
.cat-chip.active{background:rgba(255,107,53,.1);border-color:var(--orange);color:var(--orange)}

/* SECTION */
.sec-row{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px}
.sec-title{font-family:'Space Grotesk',sans-serif;font-size:17px;font-weight:800;color:var(--white)}
.sec-sub{font-size:12px;color:var(--muted);margin-top:2px}
.sec-link{font-size:12px;color:var(--orange);font-weight:600;cursor:pointer;display:flex;align-items:center;gap:4px;white-space:nowrap;margin-top:4px}

/* PRODUCTS */
.prods-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.prod-card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:border-color var(--T),transform var(--T);cursor:pointer}
.prod-card:hover{border-color:rgba(255,107,53,.3);transform:translateY(-3px)}
.prod-img-wrap{position:relative;height:175px;overflow:hidden;background:var(--bg3)}
.prod-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.prod-card:hover .prod-img-wrap img{transform:scale(1.06)}
.prod-badge{position:absolute;top:9px;left:9px;background:var(--orange);color:#fff;font-size:9px;font-weight:800;padding:3px 8px;border-radius:50px;font-family:'Space Grotesk',sans-serif}
.prod-badge.new{background:var(--blue)}
.prod-wish{position:absolute;top:9px;right:9px;width:28px;height:28px;border-radius:50%;background:rgba(13,13,13,.85);backdrop-filter:blur(8px);border:none;color:var(--muted);cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center;transition:all var(--T)}
.prod-body{padding:12px}
.prod-cat-lbl{font-size:9px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--orange);font-family:'Space Grotesk',sans-serif;margin-bottom:3px}
.prod-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:var(--white);margin-bottom:5px;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.prod-stars{color:#FCD34D;font-size:10px}
.prod-rcount{font-size:10px;color:var(--muted);margin-left:3px}
.prod-foot{display:flex;align-items:center;justify-content:space-between;margin-top:10px}
.prod-price{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:800;color:var(--orange)}
.prod-old{font-size:11px;color:var(--muted);text-decoration:line-through;margin-left:3px}
.prod-btns{display:flex;gap:5px}
.btn-eye{width:30px;height:30px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:12px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all var(--T)}
.btn-eye:hover{border-color:var(--orange);color:var(--orange)}
.btn-add{height:30px;padding:0 12px;border-radius:var(--radius-xs);background:var(--orange);color:#fff;border:none;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;cursor:pointer;transition:all var(--T);display:flex;align-items:center;gap:5px}
.btn-add:hover{background:var(--orange2)}
.btn-add.added{background:var(--success)}

/* FOOTER */
footer{border-top:1px solid var(--border);padding:16px 28px;display:flex;align-items:center;justify-content:space-between;font-size:12px;color:var(--muted);background:var(--bg2)}
footer a{color:var(--muted);margin-left:20px}footer a:hover{color:var(--orange)}

/* TOAST */
.toast{position:fixed;bottom:22px;right:22px;z-index:999;background:var(--bg3);border:1px solid var(--border2);border-radius:var(--radius-sm);padding:12px 18px;font-size:13px;color:var(--text);box-shadow:0 8px 32px rgba(0,0,0,.5);transform:translateY(80px);opacity:0;transition:all .3s;pointer-events:none;display:flex;align-items:center;gap:9px}
.toast.show{transform:translateY(0);opacity:1}
.toast i{color:var(--success)}
</style>
</head>
<body>

<nav class="navbar">
  <a href="#" class="nav-logo">Nex<span>Shop</span></a>
  <div class="nav-search"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Rechercher un produit…"></div>
  <div class="nav-right">
    <div class="nav-icon"><i class="fa-regular fa-bell"></i><span class="nav-badge">3</span></div>
    <div class="nav-icon"><i class="fa-solid fa-bag-shopping"></i><span class="nav-badge" id="cartBadge">0</span></div>
    <div class="nav-avatar"><img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=80&q=80" alt=""></div>
  </div>
</nav>

<div class="sub-nav">
  <div class="sub-nav-inner">
    <button class="nav-tab active">Explorer</button>
    <button class="nav-tab">Mes Commandes</button>
    <button class="nav-tab">Mon Profil</button>
  </div>
</div>

<div class="page-container">
  <main>
    <!-- HERO -->
    <div class="hero">
      <img class="hero-img" src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=60" alt="">
      <div class="hero-content">
        <div class="hero-tag"><i class="fa-solid fa-bolt"></i> Nouvelle Collection</div>
        <div class="hero-title">Préparez votre été<br>avec <span>style.</span></div>
        <button class="hero-btn"><i class="fa-solid fa-arrow-right"></i> Acheter maintenant</button>
      </div>
    </div>

    <!-- CATEGORIES -->
    <div class="cat-bar">
      <span class="cat-label-txt"><i class="fa-solid fa-sliders"></i> Catégories</span>
      <div class="cat-chip active" onclick="filterP(this,'all')">Tous</div>
      <div class="cat-chip" onclick="filterP(this,'Électronique')">Électronique</div>
      <div class="cat-chip" onclick="filterP(this,'Mode')">Mode</div>
      <div class="cat-chip" onclick="filterP(this,'Maison')">Maison</div>
      <div class="cat-chip" onclick="filterP(this,'Beauté')">Beauté</div>
      <div class="cat-chip" onclick="filterP(this,'Sport')">Sport</div>
      <div class="cat-chip" onclick="filterP(this,'Livres')">Livres</div>
    </div>

    <!-- SECTION TITLE -->
    <div class="sec-row">
      <div><div class="sec-title">Sélection du moment</div><div class="sec-sub">Basé sur vos préférences et les tendances actuelles.</div></div>
      <span class="sec-link">Affichage de 8 produits <i class="fa-solid fa-chevron-right"></i></span>
    </div>

    <!-- PRODUCTS -->
    <div class="prods-grid" id="grid">

      <div class="prod-card" data-cat="Électronique">
        <div class="prod-img-wrap"><img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80" alt="Casque"><button class="prod-wish" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button></div>
        <div class="prod-body"><div class="prod-cat-lbl">Électronique</div><div class="prod-name">Casque Audio Premium Sans Fil</div><div><span class="prod-stars">★★★★★</span><span class="prod-rcount">(4.8)</span></div><div class="prod-foot"><div><span class="prod-price">249,00 €</span></div><div class="prod-btns"><button class="btn-eye"><i class="fa-regular fa-eye"></i></button><button class="btn-add" onclick="addCart(this)"><i class="fa-solid fa-cart-plus"></i> Ajouter</button></div></div></div>
      </div>

      <div class="prod-card" data-cat="Électronique">
        <div class="prod-img-wrap"><img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&q=80" alt="Montre"><span class="prod-badge new">Nouveau</span><button class="prod-wish" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button></div>
        <div class="prod-body"><div class="prod-cat-lbl">Électronique</div><div class="prod-name">Montre Connectée Sport Pro</div><div><span class="prod-stars">★★★★☆</span><span class="prod-rcount">(4.8)</span></div><div class="prod-foot"><div><span class="prod-price">189,50 €</span></div><div class="prod-btns"><button class="btn-eye"><i class="fa-regular fa-eye"></i></button><button class="btn-add" onclick="addCart(this)"><i class="fa-solid fa-cart-plus"></i> Ajouter</button></div></div></div>
      </div>

      <div class="prod-card" data-cat="Mode">
        <div class="prod-img-wrap"><img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&q=80" alt="Sac"><button class="prod-wish" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button></div>
        <div class="prod-body"><div class="prod-cat-lbl">Mode</div><div class="prod-name">Sac à Dos Urbain Ergonomique</div><div><span class="prod-stars">★★★★☆</span><span class="prod-rcount">(4.8)</span></div><div class="prod-foot"><div><span class="prod-price">75,00 €</span></div><div class="prod-btns"><button class="btn-eye"><i class="fa-regular fa-eye"></i></button><button class="btn-add" onclick="addCart(this)"><i class="fa-solid fa-cart-plus"></i> Ajouter</button></div></div></div>
      </div>

      <div class="prod-card" data-cat="Maison">
        <div class="prod-img-wrap"><img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=500&q=80" alt="Cafetière"><button class="prod-wish" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button></div>
        <div class="prod-body"><div class="prod-cat-lbl">Maison</div><div class="prod-name">Cafetière à Piston Italienne</div><div><span class="prod-stars">★★★★★</span><span class="prod-rcount">(4.8)</span></div><div class="prod-foot"><div><span class="prod-price">42,00 €</span></div><div class="prod-btns"><button class="btn-eye"><i class="fa-regular fa-eye"></i></button><button class="btn-add" onclick="addCart(this)"><i class="fa-solid fa-cart-plus"></i> Ajouter</button></div></div></div>
      </div>

      <div class="prod-card" data-cat="Sport">
        <div class="prod-img-wrap"><img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&q=80" alt="Sneakers"><span class="prod-badge">-20%</span><button class="prod-wish" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button></div>
        <div class="prod-body"><div class="prod-cat-lbl">Sport</div><div class="prod-name">Sneakers de Course Performance</div><div><span class="prod-stars">★★★★☆</span><span class="prod-rcount">(4.8)</span></div><div class="prod-foot"><div><span class="prod-price">120,00 €</span><span class="prod-old">149€</span></div><div class="prod-btns"><button class="btn-eye"><i class="fa-regular fa-eye"></i></button><button class="btn-add" onclick="addCart(this)"><i class="fa-solid fa-cart-plus"></i> Ajouter</button></div></div></div>
      </div>

      <div class="prod-card" data-cat="Électronique">
        <div class="prod-img-wrap"><img src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500&q=80" alt="Enceinte"><button class="prod-wish" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button></div>
        <div class="prod-body"><div class="prod-cat-lbl">Électronique</div><div class="prod-name">Enceinte Bluetooth Waterproof</div><div><span class="prod-stars">★★★★☆</span><span class="prod-rcount">(4.8)</span></div><div class="prod-foot"><div><span class="prod-price">89,00 €</span></div><div class="prod-btns"><button class="btn-eye"><i class="fa-regular fa-eye"></i></button><button class="btn-add" onclick="addCart(this)"><i class="fa-solid fa-cart-plus"></i> Ajouter</button></div></div></div>
      </div>

      <div class="prod-card" data-cat="Maison">
        <div class="prod-img-wrap"><img src="https://images.unsplash.com/photo-1594226801341-41427b4e5c22?w=500&q=80" alt="Couteaux"><button class="prod-wish" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button></div>
        <div class="prod-body"><div class="prod-cat-lbl">Maison</div><div class="prod-name">Set de Couteaux de Cuisine</div><div><span class="prod-stars">★★★★★</span><span class="prod-rcount">(4.8)</span></div><div class="prod-foot"><div><span class="prod-price">155,00 €</span></div><div class="prod-btns"><button class="btn-eye"><i class="fa-regular fa-eye"></i></button><button class="btn-add" onclick="addCart(this)"><i class="fa-solid fa-cart-plus"></i> Ajouter</button></div></div></div>
      </div>

      <div class="prod-card" data-cat="Beauté">
        <div class="prod-img-wrap"><img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=500&q=80" alt="Sérum"><span class="prod-badge new">Nouveau</span><button class="prod-wish" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button></div>
        <div class="prod-body"><div class="prod-cat-lbl">Beauté</div><div class="prod-name">Sérum Visage Hydratant Bio</div><div><span class="prod-stars">★★★★☆</span><span class="prod-rcount">(4.8)</span></div><div class="prod-foot"><div><span class="prod-price">34,90 €</span></div><div class="prod-btns"><button class="btn-eye"><i class="fa-regular fa-eye"></i></button><button class="btn-add" onclick="addCart(this)"><i class="fa-solid fa-cart-plus"></i> Ajouter</button></div></div></div>
      </div>

    </div>
  </main>
</div>

<footer>
  <span>© 2026 NexShop. Tous droits réservés.</span>
  <div><a href="#">Conditions d'utilisation</a><a href="#">Confidentialité</a><a href="#">Support</a></div>
</footer>

<div class="toast" id="toast"><i class="fa-solid fa-check-circle"></i><span id="toastMsg"></span></div>

<script>
let cart=0;
function addCart(btn){cart++;document.getElementById('cartBadge').textContent=cart;btn.classList.add('added');btn.innerHTML='<i class="fa-solid fa-check"></i> Ajouté';setTimeout(()=>{btn.classList.remove('added');btn.innerHTML='<i class="fa-solid fa-cart-plus"></i> Ajouter';},1600);toast2('Produit ajouté au panier !');}
function toggleWish(btn){btn.classList.toggle('active');const i=btn.querySelector('i');if(btn.classList.contains('active')){i.className='fa-solid fa-heart';i.style.color='#ef4444';toast2('Ajouté aux favoris ❤️');}else{i.className='fa-regular fa-heart';i.style.color='';}}
function filterP(chip,cat){document.querySelectorAll('.cat-chip').forEach(c=>c.classList.remove('active'));chip.classList.add('active');document.querySelectorAll('.prod-card').forEach(c=>{c.style.display=cat==='all'||c.dataset.cat===cat?'':'none';});}
function toast2(msg){const t=document.getElementById('toast');document.getElementById('toastMsg').textContent=msg;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),2500);}
document.querySelectorAll('.nav-tab').forEach(t=>t.addEventListener('click',()=>{document.querySelectorAll('.nav-tab').forEach(x=>x.classList.remove('active'));t.classList.add('active');}));
</script>
</body>
</html>
