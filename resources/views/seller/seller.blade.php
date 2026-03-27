<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NexShop — Tableau de Bord Vendeur</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
:root{
  --bg:#0D0D0D;--bg2:#141414;--bg3:#1C1C1C;--bg4:#222;
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
.nav-logo{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white)}
.nav-logo span{color:var(--orange)}
.nav-right{margin-left:auto;display:flex;align-items:center;gap:8px}
.nav-icon{width:36px;height:36px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:14px;cursor:pointer;transition:all var(--T);position:relative}
.nav-icon:hover{border-color:var(--orange);color:var(--orange)}
.nav-badge{position:absolute;top:-4px;right:-4px;width:16px;height:16px;border-radius:50%;background:var(--orange);color:#fff;font-size:9px;font-weight:800;font-family:'Space Grotesk',sans-serif;display:flex;align-items:center;justify-content:center;border:2px solid var(--bg)}
.nav-avatar{width:34px;height:34px;border-radius:50%;border:2px solid var(--orange);overflow:hidden;cursor:pointer}
.nav-avatar img{width:100%;height:100%;object-fit:cover}
.btn-primary{display:inline-flex;align-items:center;gap:8px;background:var(--orange);color:#fff;border:none;padding:9px 18px;border-radius:var(--radius-xs);font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:all var(--T);box-shadow:0 4px 14px rgba(255,107,53,.3)}
.btn-primary:hover{background:var(--orange2)}

/* LAYOUT */
.layout{display:flex;flex:1}
.sidebar{width:210px;flex-shrink:0;background:var(--bg2);border-right:1px solid var(--border);padding:16px 10px;display:flex;flex-direction:column;gap:2px;position:sticky;top:60px;height:calc(100vh - 60px);overflow-y:auto}
.sb-label{font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted2);padding:12px 10px 5px}
.sb-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:var(--radius-xs);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;transition:all var(--T);border:1px solid transparent}
.sb-item:hover{background:var(--bg3);color:var(--text)}
.sb-item.active{background:rgba(255,107,53,.1);color:var(--orange);border-color:rgba(255,107,53,.15)}
.sb-item i{width:15px;text-align:center;font-size:13px}
.sb-bottom{margin-top:auto}
.sb-shop{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:12px;margin-bottom:8px}
.sb-shop-avatar{width:40px;height:40px;border-radius:10px;overflow:hidden;border:2px solid var(--orange);margin-bottom:8px}
.sb-shop-avatar img{width:100%;height:100%;object-fit:cover}
.sb-shop-name{font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:800;color:var(--white);margin-bottom:1px}
.sb-shop-verified{font-size:10px;color:var(--orange);display:flex;align-items:center;gap:3px}
.sb-shop-stars{font-size:10px;color:var(--muted);margin-top:3px}
.sb-shop-stars span{color:#FCD34D}
.sb-logout{color:var(--danger) !important}

/* MAIN */
.main{flex:1;padding:24px 28px;overflow-y:auto;min-width:0}
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
.page-title{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white)}
.page-sub{font-size:12px;color:var(--muted);margin-top:3px}

/* KPI CARDS */
.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px}
.kpi-card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:20px;position:relative;overflow:hidden;transition:border-color var(--T)}
.kpi-card:hover{border-color:rgba(255,107,53,.2)}
.kpi-card::before{content:'';position:absolute;top:0;right:0;width:80px;height:80px;background:radial-gradient(circle,rgba(255,107,53,.06),transparent 70%)}
.kpi-label{font-size:11px;color:var(--muted);font-weight:500;margin-bottom:8px;text-transform:uppercase;letter-spacing:.07em;font-family:'Space Grotesk',sans-serif}
.kpi-val{font-family:'Space Grotesk',sans-serif;font-size:24px;font-weight:800;color:var(--white);margin-bottom:6px}
.kpi-trend{font-size:11px;display:flex;align-items:center;gap:4px}
.kpi-trend.up{color:var(--success)}
.kpi-trend.down{color:var(--danger)}
.kpi-icon{position:absolute;top:18px;right:18px;width:36px;height:36px;border-radius:10px;background:rgba(255,107,53,.1);border:1px solid rgba(255,107,53,.15);display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--orange)}

/* TWO COL */
.two-col{display:grid;grid-template-columns:1fr 300px;gap:20px;margin-bottom:28px}

/* TABLE */
.card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.card-head{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid var(--border)}
.card-title{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:800;color:var(--white)}
.card-sub{font-size:11px;color:var(--muted);margin-top:2px}
.card-action{font-size:11px;color:var(--orange);font-weight:600;cursor:pointer}
.search-wrap{display:flex;align-items:center;gap:10px}
.search-mini{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:7px 12px 7px 32px;color:var(--white);font-size:12px;outline:none;width:180px;position:relative;font-family:'Inter',sans-serif}
.search-mini::placeholder{color:var(--muted)}
.search-wrap-inner{position:relative}
.search-wrap-inner i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:11px}
.btn-filter{width:32px;height:32px;background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);display:flex;align-items:center;justify-content:center;color:var(--muted);cursor:pointer;font-size:12px;transition:all var(--T)}
.btn-filter:hover{border-color:var(--orange);color:var(--orange)}

.table{width:100%;border-collapse:collapse}
.table th{padding:11px 16px;text-align:left;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--muted);letter-spacing:.07em;text-transform:uppercase;border-bottom:1px solid var(--border);background:var(--bg3)}
.table td{padding:12px 16px;font-size:13px;border-bottom:1px solid var(--border);vertical-align:middle}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:rgba(255,255,255,.02)}
.prod-thumb{width:40px;height:40px;border-radius:var(--radius-xs);object-fit:cover;border:1px solid var(--border)}
.prod-thumb-wrap{display:flex;align-items:center;gap:10px}
.prod-thumb-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;color:var(--white)}
.status-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:50px;font-size:10px;font-weight:700;font-family:'Space Grotesk',sans-serif}
.status-badge.stock{background:rgba(34,197,94,.1);color:var(--success);border:1px solid rgba(34,197,94,.2)}
.status-badge.rupture{background:rgba(239,68,68,.1);color:var(--danger);border:1px solid rgba(239,68,68,.2)}
.status-badge.brouillon{background:rgba(156,163,175,.1);color:#9ca3af;border:1px solid rgba(156,163,175,.2)}
.text-danger{color:var(--danger);font-weight:600}
.table-actions{display:flex;gap:5px}
.tbl-btn{width:28px;height:28px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:11px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all var(--T)}
.tbl-btn:hover{border-color:var(--orange);color:var(--orange)}
.tbl-btn.del:hover{border-color:var(--danger);color:var(--danger)}
.table-foot{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid var(--border)}
.table-foot span{font-size:12px;color:var(--muted)}
.pag{display:flex;gap:4px}
.pag-btn{height:28px;padding:0 10px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:12px;cursor:pointer;transition:all var(--T);display:flex;align-items:center}
.pag-btn:hover,.pag-btn.active{background:var(--orange);border-color:var(--orange);color:#fff}

/* ORDERS */
.orders-list{padding:4px 0}
.order-item{display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid var(--border);transition:background var(--T);cursor:pointer}
.order-item:last-child{border-bottom:none}
.order-item:hover{background:rgba(255,255,255,.02)}
.order-avatar{width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid var(--border2);flex-shrink:0}
.order-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:var(--white)}
.order-id{font-size:11px;color:var(--muted)}
.order-right{margin-left:auto;text-align:right}
.order-amount{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:800;color:var(--white)}
.order-status{font-size:10px;font-weight:700;padding:2px 8px;border-radius:50px;font-family:'Space Grotesk',sans-serif;margin-top:3px;display:inline-block}
.order-status.paye{background:rgba(34,197,94,.12);color:var(--success)}
.order-status.expedie{background:rgba(30,144,255,.12);color:var(--blue)}
.order-status.attente{background:rgba(245,158,11,.12);color:var(--warning)}

/* SHOP PANEL */
.shop-panel{display:flex;flex-direction:column;gap:14px}
.shop-info-card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:20px}
.shop-avatar-lg{width:64px;height:64px;border-radius:14px;overflow:hidden;border:3px solid var(--orange);margin:0 auto 12px}
.shop-avatar-lg img{width:100%;height:100%;object-fit:cover}
.shop-name-lg{font-family:'Space Grotesk',sans-serif;font-size:16px;font-weight:800;color:var(--white);text-align:center}
.shop-verified{font-size:11px;color:var(--muted);text-align:center;margin-top:3px;display:flex;align-items:center;justify-content:center;gap:5px}
.shop-verified i{color:var(--orange)}
.shop-stars-row{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:6px;font-size:12px;color:var(--muted)}
.shop-stars-row span{color:#FCD34D}
.quick-actions{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.qa-title{font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;padding:14px 16px 8px}
.qa-item{display:flex;align-items:center;gap:10px;padding:12px 16px;cursor:pointer;transition:background var(--T);border-top:1px solid var(--border);font-size:13px;color:var(--text)}
.qa-item:hover{background:rgba(255,255,255,.03)}
.qa-item i{color:var(--orange);width:14px}
.qa-item.red{color:var(--danger)}
.qa-item.red i{color:var(--danger)}
.premium-banner{background:linear-gradient(135deg,var(--orange),var(--orange2));border-radius:var(--radius);padding:18px 16px;text-align:center}
.premium-banner i{font-size:22px;color:#fff;margin-bottom:8px}
.premium-banner-title{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:800;color:#fff;margin-bottom:4px}
.premium-banner-sub{font-size:11px;color:rgba(255,255,255,.8);line-height:1.5}

footer{border-top:1px solid var(--border);padding:14px 28px;display:flex;align-items:center;justify-content:space-between;font-size:12px;color:var(--muted);background:var(--bg2)}
footer a{color:var(--muted);margin-left:16px}footer a:hover{color:var(--orange)}
.fab{position:fixed;bottom:24px;right:24px;width:48px;height:48px;border-radius:50%;background:var(--blue);color:#fff;border:none;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(30,144,255,.4);z-index:200;transition:all var(--T)}
.fab:hover{transform:scale(1.1)}
</style>
</head>
<body>

<nav class="navbar">
  <a href="#" class="nav-logo">Nex<span>Shop</span></a>
  <div class="nav-right">
    <div class="nav-icon"><i class="fa-regular fa-bell"></i><span class="nav-badge">2</span></div>
    <div class="nav-avatar"><img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&q=80" alt=""></div>
  </div>
</nav>

<div class="layout">
  <aside class="sidebar">
    <div class="sb-label">Gestion</div>
    <div class="sb-item active"><i class="fa-solid fa-gauge"></i> Dashboard</div>
    <div class="sb-item"><i class="fa-solid fa-box"></i> Mes Produits</div>
    <div class="sb-item"><i class="fa-solid fa-plus"></i> Ajouter Produit</div>
    <div class="sb-item"><i class="fa-solid fa-shopping-cart"></i> Commandes</div>
    <div class="sb-label">Compte</div>
    <div class="sb-item"><i class="fa-solid fa-user"></i> Profil</div>
    <div class="sb-bottom">
      <div class="sb-item sb-logout"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</div>
    </div>
  </aside>

  <main class="main">
    <!-- PAGE HEADER -->
    <div class="page-head">
      <div><div class="page-title">Vue d'ensemble</div><div class="page-sub">Suivez vos performances et gérez votre boutique en temps réel.</div></div>
      <button class="btn-primary"><i class="fa-solid fa-plus"></i> Ajouter un produit</button>
    </div>

    <!-- KPIs -->
    <div class="kpi-grid">
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
        <div class="kpi-label">Ventes Totales</div>
        <div class="kpi-val">12 450 €</div>
        <div class="kpi-trend up"><i class="fa-solid fa-arrow-up"></i> +14% vs mois dernier</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-bag-shopping"></i></div>
        <div class="kpi-label">Commandes</div>
        <div class="kpi-val">154</div>
        <div class="kpi-trend up"><i class="fa-solid fa-arrow-up"></i> +8% vs mois dernier</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-cubes"></i></div>
        <div class="kpi-label">Produits Actifs</div>
        <div class="kpi-val">42</div>
        <div class="kpi-trend up"><i class="fa-solid fa-arrow-up"></i> +2 vs mois dernier</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-regular fa-comment"></i></div>
        <div class="kpi-label">Avis Clients</div>
        <div class="kpi-val">4.8/5</div>
        <div class="kpi-trend up"><i class="fa-solid fa-arrow-up"></i> +0.2 vs mois dernier</div>
      </div>
    </div>

    <!-- INVENTAIRE -->
    <div class="card" style="margin-bottom:20px">
      <div class="card-head">
        <div><div class="card-title">Inventaire des Produits</div><div class="card-sub">Gérez, modifiez et supprimez vos références catalogue.</div></div>
        <div class="search-wrap">
          <div class="search-wrap-inner">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input class="search-mini" type="text" placeholder="Chercher un produit…">
          </div>
          <div class="btn-filter"><i class="fa-solid fa-sliders"></i></div>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Image</th><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Statut</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><img class="prod-thumb" src="https://images.unsplash.com/photo-1542393545-10f5cde2c810?w=80&q=80" alt=""></td>
            <td><div class="prod-thumb-name">MacBook Pro 14" M3</div></td>
            <td>Électronique</td><td>2 499 €</td><td>12 pcs</td>
            <td><span class="status-badge stock"><i class="fa-solid fa-circle" style="font-size:6px"></i> en stock</span></td>
            <td><div class="table-actions"><div class="tbl-btn"><i class="fa-solid fa-pen"></i></div><div class="tbl-btn del"><i class="fa-solid fa-trash"></i></div><div class="tbl-btn"><i class="fa-solid fa-ellipsis-vertical"></i></div></div></td>
          </tr>
          <tr>
            <td><img class="prod-thumb" src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=80&q=80" alt=""></td>
            <td><div class="prod-thumb-name">iPhone 15 Pro Max</div></td>
            <td>Électronique</td><td>1 450 €</td><td class="text-danger">0 pcs</td>
            <td><span class="status-badge rupture"><i class="fa-solid fa-circle" style="font-size:6px"></i> rupture</span></td>
            <td><div class="table-actions"><div class="tbl-btn"><i class="fa-solid fa-pen"></i></div><div class="tbl-btn del"><i class="fa-solid fa-trash"></i></div><div class="tbl-btn"><i class="fa-solid fa-ellipsis-vertical"></i></div></div></td>
          </tr>
          <tr>
            <td><img class="prod-thumb" src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=80&q=80" alt=""></td>
            <td><div class="prod-thumb-name">Casque Sony WH-1000XM5</div></td>
            <td>Audio</td><td>399 €</td><td>45 pcs</td>
            <td><span class="status-badge stock"><i class="fa-solid fa-circle" style="font-size:6px"></i> en stock</span></td>
            <td><div class="table-actions"><div class="tbl-btn"><i class="fa-solid fa-pen"></i></div><div class="tbl-btn del"><i class="fa-solid fa-trash"></i></div><div class="tbl-btn"><i class="fa-solid fa-ellipsis-vertical"></i></div></div></td>
          </tr>
          <tr>
            <td><img class="prod-thumb" src="https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=80&q=80" alt=""></td>
            <td><div class="prod-thumb-name">Écran Dell UltraSharp 27"</div></td>
            <td>Bureautique</td><td>650 €</td><td>5 pcs</td>
            <td><span class="status-badge brouillon"><i class="fa-solid fa-circle" style="font-size:6px"></i> brouillon</span></td>
            <td><div class="table-actions"><div class="tbl-btn"><i class="fa-solid fa-pen"></i></div><div class="tbl-btn del"><i class="fa-solid fa-trash"></i></div><div class="tbl-btn"><i class="fa-solid fa-ellipsis-vertical"></i></div></div></td>
          </tr>
          <tr>
            <td><img class="prod-thumb" src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=80&q=80" alt=""></td>
            <td><div class="prod-thumb-name">Clavier Logitech MX Keys</div></td>
            <td>Bureautique</td><td>119 €</td><td>28 pcs</td>
            <td><span class="status-badge stock"><i class="fa-solid fa-circle" style="font-size:6px"></i> en stock</span></td>
            <td><div class="table-actions"><div class="tbl-btn"><i class="fa-solid fa-pen"></i></div><div class="tbl-btn del"><i class="fa-solid fa-trash"></i></div><div class="tbl-btn"><i class="fa-solid fa-ellipsis-vertical"></i></div></div></td>
          </tr>
        </tbody>
      </table>
      <div class="table-foot">
        <span>Affichage de 5 sur 42 produits</span>
        <div class="pag">
          <div class="pag-btn">Précédent</div>
          <div class="pag-btn active">1</div>
          <div class="pag-btn">2</div>
          <div class="pag-btn">3</div>
          <div class="pag-btn">Suivant</div>
        </div>
      </div>
    </div>

    <!-- ORDERS + SHOP PANEL -->
    <div class="two-col">
      <div class="card">
        <div class="card-head">
          <div><div class="card-title">Commandes Récentes</div><div class="card-sub">Dernières transactions effectuées sur votre boutique.</div></div>
          <span class="card-action">Voir tout</span>
        </div>
        <div class="orders-list">
          <div class="order-item">
            <img class="order-avatar" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&q=80" alt="">
            <div><div class="order-name">Jean Dupont</div><div class="order-id">ORD-7721 • 12 Mars 2024</div></div>
            <div class="order-right"><div class="order-amount">2 499 €</div><span class="order-status paye">payé</span></div>
          </div>
          <div class="order-item">
            <img class="order-avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&q=80" alt="">
            <div><div class="order-name">Marie Curie</div><div class="order-id">ORD-7722 • 11 Mars 2024</div></div>
            <div class="order-right"><div class="order-amount">119 €</div><span class="order-status expedie">expédié</span></div>
          </div>
          <div class="order-item">
            <img class="order-avatar" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&q=80" alt="">
            <div><div class="order-name">Lucas Martin</div><div class="order-id">ORD-7723 • 10 Mars 2024</div></div>
            <div class="order-right"><div class="order-amount">399 €</div><span class="order-status attente">en_attente</span></div>
          </div>
          <div class="order-item">
            <img class="order-avatar" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&q=80" alt="">
            <div><div class="order-name">Sophie Bernard</div><div class="order-id">ORD-7724 • 09 Mars 2024</div></div>
            <div class="order-right"><div class="order-amount">1 450 €</div><span class="order-status paye">payé</span></div>
          </div>
          <div class="order-item">
            <img class="order-avatar" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&q=80" alt="">
            <div><div class="order-name">Thomas Petit</div><div class="order-id">ORD-7725 • 09 Mars 2024</div></div>
            <div class="order-right"><div class="order-amount">650 €</div><span class="order-status expedie">expédié</span></div>
          </div>
        </div>
      </div>

      <div class="shop-panel">
        <div class="shop-info-card">
          <div class="shop-avatar-lg"><img src="https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=80&q=80" alt=""></div>
          <div class="shop-name-lg">Tech & Gear Pro</div>
          <div class="shop-verified"><i class="fa-solid fa-circle-check"></i> Vendeur vérifié • Depuis 2022</div>
          <div class="shop-stars-row"><span>★★★★★</span> (1 240 avis)</div>
        </div>
        <div class="quick-actions">
          <div class="qa-title">Actions Rapides</div>
          <div class="qa-item"><i class="fa-solid fa-gear"></i> Paramètres boutique</div>
          <div class="qa-item"><i class="fa-solid fa-download"></i> Exporter rapports PDF</div>
          <div class="qa-item red"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</div>
        </div>
        <div class="premium-banner">
          <i class="fa-solid fa-shield-halved"></i>
          <div class="premium-banner-title">Boutique Premium Activée</div>
          <div class="premium-banner-sub">Vous bénéficiez des commissions réduites à 3%.</div>
        </div>
      </div>
    </div>

  </main>
</div>

<button class="fab"><i class="fa-solid fa-plus"></i></button>

<footer>
  <span>© 2026 NexShop. Tous droits réservés.</span>
  <div><a href="#">Conditions d'utilisation</a><a href="#">Confidentialité</a><a href="#">Support</a></div>
</footer>

<script>
document.querySelectorAll('.sb-item').forEach(i=>i.addEventListener('click',()=>{document.querySelectorAll('.sb-item').forEach(x=>x.classList.remove('active'));i.classList.add('active');}));
document.querySelectorAll('.pag-btn').forEach(b=>b.addEventListener('click',()=>{document.querySelectorAll('.pag-btn').forEach(x=>x.classList.remove('active'));if(!['Précédent','Suivant'].includes(b.textContent))b.classList.add('active');}));
</script>
</body>
</html>
