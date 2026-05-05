<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('partials.theme-init')
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
.nav-logo{display:inline-flex;align-items:center;gap:10px;font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white);max-width:min(360px,45vw)}
.nav-logo-mark{width:38px;height:38px;border-radius:11px;background:linear-gradient(145deg,rgba(255,107,53,.38),rgba(255,107,53,.1));border:1px solid rgba(255,107,53,.35);display:flex;align-items:center;justify-content:center;color:var(--orange);font-size:17px;flex-shrink:0}
.nav-logo-img{width:38px;height:38px;border-radius:11px;object-fit:cover;border:1px solid rgba(255,107,53,.35);flex-shrink:0;background:var(--bg3)}
.nav-logo-label{font-size:20px;line-height:1.1;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
.nav-logo-label .nx-brand-accent{color:var(--orange)}
.nav-right{margin-left:auto;display:flex;align-items:center;gap:8px}
.nav-icon{width:36px;height:36px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:14px;cursor:pointer;transition:all var(--T);position:relative;text-decoration:none}
.nav-icon:hover{border-color:var(--orange);color:var(--orange)}
.nav-badge{position:absolute;top:-4px;right:-4px;width:16px;height:16px;border-radius:50%;background:var(--orange);color:#fff;font-size:9px;font-weight:800;font-family:'Space Grotesk',sans-serif;display:flex;align-items:center;justify-content:center;border:2px solid var(--bg)}
.nav-avatar{width:34px;height:34px;border-radius:50%;border:2px solid var(--orange);overflow:hidden;cursor:pointer}
.nav-avatar img{width:100%;height:100%;object-fit:cover}
.nav-user-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;color:var(--text)}
.btn-primary{display:inline-flex;align-items:center;gap:8px;background:var(--orange);color:#fff;border:none;padding:9px 18px;border-radius:var(--radius-xs);font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:all var(--T);box-shadow:0 4px 14px rgba(255,107,53,.3)}
.btn-primary:hover{background:var(--orange2)}
.btn-sm{padding:6px 12px;font-size:11px}
.btn-danger{background:var(--danger);box-shadow:0 4px 14px rgba(239,68,68,.3)}
.btn-danger:hover{background:#DC2626}

/* LAYOUT */
.layout{display:flex;flex:1}
.sidebar{width:210px;flex-shrink:0;background:var(--bg2);border-right:1px solid var(--border);padding:16px 10px;display:flex;flex-direction:column;gap:2px;position:sticky;top:60px;height:calc(100vh - 60px);overflow-y:auto}
.sb-label{font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted2);padding:12px 10px 5px}
.sb-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:var(--radius-xs);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;transition:all var(--T);border:1px solid transparent}
.sb-item:hover{background:var(--bg3);color:var(--text)}
.sb-item.active{background:rgba(255,107,53,.1);color:var(--orange);border-color:rgba(255,107,53,.15)}
.sb-item i{width:15px;text-align:center;font-size:13px}
.sb-bottom{margin-top:auto}
.sb-shop{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:12px;margin-bottom:8px;text-align:center}
.sb-shop-logo{display:block;width:64px;height:64px;margin:0 auto 10px;border-radius:12px;object-fit:cover;border:1px solid var(--border);background:var(--bg2)}
.sb-shop-name{font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:800;color:var(--white);margin-bottom:1px;line-height:1.25}
.sb-shop-verified{font-size:10px;color:var(--orange);display:flex;align-items:center;justify-content:center;gap:6px;margin-top:6px;width:100%}
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
.kpi-icon{position:absolute;top:18px;right:18px;width:36px;height:36px;border-radius:10px;background:rgba(255,107,53,.1);border:1px solid rgba(255,107,53,.15);display:flex;align-items:center;justify-content:center;font-size:16px;color:var(--orange)}

/* TABLE */
.card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.card-head{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid var(--border)}
.card-title{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:800;color:var(--white)}
.card-sub{font-size:11px;color:var(--muted);margin-top:2px}
.card-action{font-size:11px;color:var(--orange);font-weight:600;cursor:pointer}
.card-body{padding:20px}

.search-mini{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:7px 12px 7px 32px;color:var(--white);font-size:12px;outline:none;width:180px;font-family:'Inter',sans-serif}
.search-mini::placeholder{color:var(--muted)}
.search-wrap{display:flex;align-items:center;gap:10px}
.search-wrap-inner{position:relative}
.search-wrap-inner i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:11px}

.table{width:100%;border-collapse:collapse}
.table th{padding:11px 16px;text-align:left;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--muted);letter-spacing:.07em;text-transform:uppercase;border-bottom:1px solid var(--border);background:var(--bg3)}
.table td{padding:12px 16px;font-size:13px;border-bottom:1px solid var(--border);vertical-align:middle}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:rgba(255,255,255,.02)}
.prod-thumb{width:40px;height:40px;border-radius:var(--radius-xs);object-fit:cover;border:1px solid var(--border)}
.prod-thumb-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;color:var(--white)}
.status-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:50px;font-size:10px;font-weight:700;font-family:'Space Grotesk',sans-serif}
.status-badge.actif,.status-badge.stock{background:rgba(34,197,94,.1);color:var(--success);border:1px solid rgba(34,197,94,.2)}
.status-badge.rupture{background:rgba(239,68,68,.1);color:var(--danger);border:1px solid rgba(239,68,68,.2)}
.status-badge.inactif,.status-badge.brouillon{background:rgba(156,163,175,.1);color:#9ca3af;border:1px solid rgba(156,163,175,.2)}
.status-badge.en-validation,.status-badge.en_attente_admin{background:rgba(245,158,11,.12);color:#f59e0b;border:1px solid rgba(245,158,11,.25)}
.text-danger{color:var(--danger);font-weight:600}
.table-actions{display:flex;gap:5px}
.tbl-btn{width:28px;height:28px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:11px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all var(--T)}
.tbl-btn:hover{border-color:var(--orange);color:var(--orange)}
.tbl-btn.del:hover{border-color:var(--danger);color:var(--danger)}
.table-foot{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid var(--border)}
.table-foot span{font-size:12px;color:var(--muted)}
.pag{display:flex;gap:4px}
.pag a,.pag span{height:28px;padding:0 10px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:12px;cursor:pointer;transition:all var(--T);display:flex;align-items:center;text-decoration:none}
.pag a:hover,.pag span.active{background:var(--orange);border-color:var(--orange);color:#fff}

/* TWO COL */
.two-col{display:grid;grid-template-columns:1fr 300px;gap:20px;margin-bottom:28px}

/* ORDERS */
.orders-list{padding:4px 0}
.order-item{display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid var(--border);transition:background var(--T);cursor:pointer}
.order-item:last-child{border-bottom:none}
.order-item:hover{background:rgba(255,255,255,.02)}
.order-avatar{width:38px;height:38px;border-radius:50%;background:var(--bg3);display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--orange);flex-shrink:0;font-family:'Space Grotesk',sans-serif;font-weight:700}
.order-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:var(--white)}
.order-id{font-size:11px;color:var(--muted)}
.order-right{margin-left:auto;text-align:right}
.order-amount{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:800;color:var(--white)}
.order-status{font-size:10px;font-weight:700;padding:2px 8px;border-radius:50px;font-family:'Space Grotesk',sans-serif;margin-top:3px;display:inline-block}
.order-status.paye{background:rgba(34,197,94,.12);color:var(--success)}
.order-status.livree{background:rgba(34,197,94,.12);color:var(--success)}
.order-status.en_livraison,.order-status.expedie{background:rgba(30,144,255,.12);color:var(--blue)}
.order-status.en_attente,.order-status.attente{background:rgba(245,158,11,.12);color:var(--warning)}
.order-status.confirmee,.order-status.en_preparation{background:rgba(168,85,247,.12);color:#A855F7}
.order-status.annulee{background:rgba(239,68,68,.12);color:var(--danger)}

/* SHOP PANEL */
.shop-panel{display:flex;flex-direction:column;gap:14px}
.shop-info-card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:20px}
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

/* ALERT */
.alert{padding:12px 16px;border-radius:var(--radius-xs);margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px}
.alert-success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:var(--success)}
.alert-error{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:var(--danger)}

/* FORM */
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px}
.form-group{display:flex;flex-direction:column;gap:5px;margin-bottom:12px}
.form-group label{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em}
.form-group input,.form-group textarea,.form-group select{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:9px 12px;color:var(--white);font-size:13px;outline:none;font-family:'Inter',sans-serif}
.form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:var(--orange)}
.form-group textarea{min-height:80px;resize:vertical}

footer{border-top:1px solid var(--border);padding:14px 28px;display:flex;align-items:center;justify-content:space-between;font-size:12px;color:var(--muted);background:var(--bg2)}
footer a{color:var(--muted);margin-left:16px}footer a:hover{color:var(--orange)}

/* MODAL */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:300;align-items:center;justify-content:center}
.modal-overlay.open{display:flex}
.modal{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:24px;max-width:520px;width:90%;max-height:80vh;overflow-y:auto}
.modal-title{font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:800;color:var(--white);margin-bottom:16px}

.fab{position:fixed;bottom:24px;right:24px;width:48px;height:48px;border-radius:50%;background:var(--orange);color:#fff;border:none;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(255,107,53,.4);z-index:200;transition:all var(--T);text-decoration:none}
.fab:hover{transform:scale(1.1)}
.table-scroll{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;overscroll-behavior-x:contain}

@media (max-width:900px){
.two-col{grid-template-columns:1fr;gap:16px}
.search-wrap{flex-wrap:wrap;width:100%}
.search-mini{width:100%;max-width:100%}
.card-head{flex-direction:column;align-items:stretch;gap:12px}
.pag{flex-wrap:wrap}
}

@media (max-width:768px){
.navbar{min-height:54px;height:auto;padding:10px 12px;gap:10px;flex-wrap:nowrap}
.nav-logo{font-size:17px;max-width:none;flex:1;min-width:0;overflow:hidden}
.nav-logo-label{font-size:17px}
.nav-right{margin-left:0;gap:6px}
.nav-user-name{display:none}
.nav-icon{width:34px;height:34px}
.layout{flex-direction:column}
.sidebar{
width:100%;height:auto;max-height:none;
position:sticky;top:54px;z-index:95;
flex-direction:row;flex-wrap:nowrap;
align-items:stretch;
overflow-x:auto;overflow-y:hidden;
-webkit-overflow-scrolling:touch;
scrollbar-width:thin;
border-right:none;border-bottom:1px solid var(--border);
padding:10px 10px 12px;gap:8px
}
.sidebar::-webkit-scrollbar{height:5px}
.sidebar::-webkit-scrollbar-thumb{background:var(--border2);border-radius:4px}
.sb-shop{
flex:0 0 auto;min-width:120px;max-width:150px;margin-bottom:0;
padding:10px 10px 8px;display:flex;flex-direction:column;align-items:center;justify-content:center
}
.sb-shop-logo{width:44px;height:44px;margin-bottom:6px}
.sb-shop-verified{margin-top:4px}
.sb-label{display:none !important}
.sb-item{flex:0 0 auto;white-space:nowrap;padding:9px 14px;font-size:12.5px}
.sb-item i{width:auto}
.sb-bottom{flex:0 0 auto;margin-top:0;display:flex;align-items:stretch}
.sb-bottom form{display:flex;align-items:stretch}
.sb-item.sb-logout,.sb-bottom .sb-item{padding:9px 14px !important;width:auto !important;white-space:nowrap}
.main{padding:14px 12px 72px}
.page-head{flex-direction:column;align-items:stretch;gap:12px;margin-bottom:18px}
.page-title{font-size:19px}
.kpi-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin-bottom:22px}
.kpi-card{padding:14px 14px 16px}
.kpi-val{font-size:20px}
.kpi-icon{top:12px;right:12px;width:32px;height:32px;font-size:14px}
.table th,.table td{padding:9px 10px;font-size:12px}
.table th{white-space:nowrap}
.prod-thumb{width:36px;height:36px}
.status-badge{font-size:9px;padding:3px 8px}
.form-row{grid-template-columns:1fr;gap:10px}
footer{flex-direction:column;align-items:flex-start;gap:12px;padding:14px 16px}
footer div a:first-child{margin-left:0}
.modal{width:94%;max-width:none;padding:18px 16px;max-height:88vh}
.modal .form-row{grid-template-columns:1fr}
.fab{bottom:calc(16px + env(safe-area-inset-bottom,0));right:calc(14px + env(safe-area-inset-right,0))}
.table-scroll{margin:0 -4px;padding:0 4px}
.order-item{flex-wrap:wrap;padding:12px 14px}
.order-right{margin-left:0;width:100%;text-align:left;padding-top:8px}
}

@media (max-width:400px){
.kpi-grid{grid-template-columns:1fr}
.navbar{padding:8px 10px}
.sidebar{padding:8px}
.sb-item{font-size:11.5px;padding:8px 11px}
}
</style>
@include('partials.theme-manager')
</head>
<body>

<nav class="navbar">
  <a href="{{ route('vendeur.home') }}" class="nav-logo" title="NexShop — espace vendeur">
    <span class="nav-logo-label">nex<span class="nx-brand-accent">shop</span></span>
  </a>
  <div class="nav-right">
    <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
    @php
      $__sellerBellTypes = [
        \App\Notifications\NewChatMessage::class,
        \App\Notifications\SellerProductValidated::class,
        \App\Notifications\SellerProductRejected::class,
        \App\Notifications\SellerSubscriptionActivated::class,
        \App\Notifications\SellerSubscriptionExpiring::class,
        \App\Notifications\SellerSubscriptionExpired::class,
        \App\Notifications\SellerSubscriptionOrderLimitReached::class,
      ];
      $sellerBellUnread = Auth::user()->unreadNotifications()->whereIn('type', $__sellerBellTypes)->count();
    @endphp
    <a href="{{ route('vendeur.notifications.index') }}" class="nav-icon" title="Notifications">
      <i class="fa-regular fa-bell"></i>
      @if($sellerBellUnread > 0)
        <span class="nav-badge">{{ $sellerBellUnread > 9 ? '9+' : $sellerBellUnread }}</span>
      @endif
    </a>
    <span class="nav-user-name">{{ Auth::user()->nom }}</span>
  </div>
</nav>

<div class="layout">
  <aside class="sidebar">
    @if($vendeurProfil)
    @php
      $sellerBoutiqueSb = $boutique ?? Auth::user()->boutique;
      $sbLogo = $sellerBoutiqueSb?->logoUrl();
      $sbName = $sellerBoutiqueSb?->nom ?? ($vendeurProfil->nom_boutique ?? 'Ma Boutique');
    @endphp
    <div class="sb-shop">
      @if($sbLogo)<img src="{{ $sbLogo }}" alt="" class="sb-shop-logo" width="64" height="64">@endif
      <div class="sb-shop-name">{{ $sbName }}</div>
      @if(Auth::user()->sellerShowsVerifiedBadge())
      <div class="sb-shop-verified"><i class="fa-solid fa-circle-check"></i> Vendeur vérifié</div>
      @else
      <div class="sb-shop-verified" style="color:var(--muted)"><i class="fa-regular fa-circle"></i> Plan {{ strtoupper(Auth::user()->abonnement_plan ?? 'FREE') }}</div>
      @endif
    </div>
    @endif
    <div class="sb-label">Gestion</div>
    <a href="{{ route('vendeur.home') }}" class="sb-item {{ $section === 'dashboard' ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="{{ route('vendeur.products') }}" class="sb-item {{ $section === 'produits' ? 'active' : '' }}"><i class="fa-solid fa-box"></i> Mes Produits</a>
    <a href="{{ route('vendeur.products.create') }}" class="sb-item"><i class="fa-solid fa-plus"></i> Ajouter Produit</a>
    <a href="{{ route('vendeur.orders') }}" class="sb-item {{ $section === 'commandes' ? 'active' : '' }}"><i class="fa-solid fa-shopping-cart"></i> Commandes</a>
    <a href="{{ route('vendeur.messages.index') }}" class="sb-item"><i class="fa-solid fa-comments"></i> Messages</a>
    <a href="{{ route('vendeur.notifications.index') }}" class="sb-item {{ ($section ?? '') === 'notifications' ? 'active' : '' }}"><i class="fa-regular fa-bell"></i> Notifications</a>
    <a href="{{ route('vendeur.boutique.edit') }}" class="sb-item"><i class="fa-solid fa-store"></i> Ma boutique</a>
    <a href="{{ route('vendeur.abonnement.index') }}" class="sb-item"><i class="fa-solid fa-crown"></i> Abonnement</a>
    <div class="sb-label">Compte</div>
    <div class="sb-bottom">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="sb-item sb-logout" style="width:100%;background:none;border:1px solid transparent;cursor:pointer;font-family:inherit"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</button>
      </form>
    </div>
  </aside>

  <main class="main">

    @if(session('success'))
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
    @endif
    @if(session('info'))
    <div class="alert" style="background:rgba(59,130,246,.1);border:1px solid rgba(59,130,246,.3);color:#93C5FD"><i class="fa-solid fa-circle-info"></i> {{ session('info') }}</div>
    @endif
    @php $u = auth()->user(); @endphp
    @if($u->sellerSubscriptionLocked())
    <div class="alert alert-error" style="border-color:rgba(245,158,11,.35);background:rgba(245,158,11,.08);color:#fbbf24">
      <i class="fa-solid fa-lock"></i> Compte limité : nouvelles commandes, messagerie et modifications catalogue sont suspendues jusqu’au passage à <strong>Pro</strong> ou <strong>Premium</strong>.
      <a href="{{ route('vendeur.abonnement.index') }}" style="color:#fff;text-decoration:underline;margin-left:8px">Voir les offres</a>
    </div>
    @elseif($u->hasActivePaidSubscription() && $u->sellerSubscriptionExpiringWithinDays(7))
    <div class="alert" style="background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.35);color:#fbbf24">
      <i class="fa-solid fa-clock"></i> Votre abonnement se termine bientôt ({{ $u->sellerSubscriptionDaysRemaining() }} jour(s)). <a href="{{ route('vendeur.abonnement.index') }}" style="color:#fff;text-decoration:underline">Renouveler</a>
    </div>
    @elseif(! $u->hasActivePaidSubscription() && $u->sellerMonthlyOrderCount() >= max(1, $u->sellerFreeMonthlyLimit() - 3))
    <div class="alert" style="background:rgba(255,107,53,.08);border:1px solid rgba(255,107,53,.25);color:var(--orange)">
      <i class="fa-solid fa-chart-simple"></i> Plan Free : {{ $u->sellerMonthlyOrderCount() }} / {{ $u->sellerFreeMonthlyLimit() }} commandes ce mois-ci.
      <a href="{{ route('vendeur.abonnement.index') }}" style="color:#fff;text-decoration:underline;margin-left:8px">Passer au Pro</a>
    </div>
    @endif
    @if(session('alerte_kyc') || auth()->user()->statut_kyc === 'en_attente')
    <div class="alert" style="background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.3);color:#f59e0b">
      <i class="fa-solid fa-hourglass-half"></i> Votre dossier KYC est en cours de verification. Vous pourrez vendre apres validation admin.
    </div>
    @endif
    @if(auth()->user()->statut_kyc === 'rejete')
    <div class="alert alert-error">
      <i class="fa-solid fa-triangle-exclamation"></i> Dossier KYC rejete. Motif: {{ auth()->user()->motif_rejet_kyc }}
      <a href="{{ route('vendeur.inscription.kyc') }}" style="margin-left:8px;color:#fff;text-decoration:underline">Resoumettre</a>
    </div>
    @endif

    {{-- ═══════════ SECTION : DASHBOARD ═══════════ --}}
    @if($section === 'dashboard')
    <div class="page-head">
      <div><div class="page-title">Vue d'ensemble</div><div class="page-sub">Suivez vos performances et gérez votre boutique en temps réel.</div></div>
      <a href="{{ route('vendeur.products.create') }}" class="btn-primary" style="text-decoration:none;display:inline-flex"><i class="fa-solid fa-plus"></i> Ajouter un produit</a>
    </div>

    <!-- KPIs -->
    <div class="kpi-grid">
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
        <div class="kpi-label">Ventes Totales</div>
        <div class="kpi-val">{{ money_fdj($totalSales) }}</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-bag-shopping"></i></div>
        <div class="kpi-label">Commandes</div>
        <div class="kpi-val">{{ $totalOrders }}</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-cubes"></i></div>
        <div class="kpi-label">Produits Actifs</div>
        <div class="kpi-val">{{ $activeProducts }}</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-regular fa-comment"></i></div>
        <div class="kpi-label">Avis Clients</div>
        <div class="kpi-val">{{ $avgRating }}/5</div>
      </div>
      @if(Auth::user()->sellerHasBasicStats())
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="kpi-label">CA ce mois-ci</div>
        <div class="kpi-val">{{ money_fdj($monthSales ?? 0) }}</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-list-ol"></i></div>
        <div class="kpi-label">Commandes (mois)</div>
        <div class="kpi-val">{{ $subscriptionUsed ?? 0 }}</div>
      </div>
      @endif
      @if(Auth::user()->sellerHasAdvancedStats())
      <div class="kpi-card">
        <div class="kpi-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
        <div class="kpi-label">Premium</div>
        <div class="kpi-val" style="font-size:16px;line-height:1.25">Visibilité &amp; stats avancées</div>
      </div>
      @endif
    </div>

    <!-- ORDERS + SHOP PANEL -->
    <div class="two-col">
      <div class="card">
        <div class="card-head">
          <div><div class="card-title">Commandes Récentes</div><div class="card-sub">Dernières transactions effectuées sur votre boutique.</div></div>
          <a href="{{ route('vendeur.orders') }}" class="card-action">Voir tout</a>
        </div>
        <div class="orders-list">
          @forelse($recentOrders as $order)
          <div class="order-item">
            <div class="order-avatar">{{ strtoupper(substr($order->client->nom ?? '?', 0, 1)) }}</div>
            <div>
              <div class="order-name">{{ $order->client->nom ?? 'Client supprimé' }}</div>
              <div class="order-id">CMD-{{ $order->id }} • {{ $order->date_commande?->format('d M Y') }}</div>
            </div>
            <div class="order-right">
              <div class="order-amount">{{ money_fdj($order->montant_total) }}</div>
              <span class="order-status {{ $order->statut }}">{{ str_replace('_', ' ', $order->statut) }}</span>
            </div>
          </div>
          @empty
          <div style="padding:32px;text-align:center;color:var(--muted)">Aucune commande pour le moment.</div>
          @endforelse
        </div>
      </div>

      <div class="shop-panel">
        <div class="shop-info-card">
          @php
            $sellerBoutiqueDash = $boutique ?? Auth::user()->boutique;
            $dashLogo = $sellerBoutiqueDash?->logoUrl();
          @endphp
          @if($dashLogo)
          <img src="{{ $dashLogo }}" alt="" class="sb-shop-logo" style="width:72px;height:72px;margin-bottom:12px">
          @endif
          <div class="shop-name-lg">{{ ($boutique ?? Auth::user()->boutique)?->nom ?? ($vendeurProfil->nom_boutique ?? 'Ma Boutique') }}</div>
          @if(Auth::user()->sellerShowsVerifiedBadge())
          <div class="shop-verified"><i class="fa-solid fa-circle-check"></i> Vendeur vérifié — {{ strtoupper(Auth::user()->abonnement_plan) }}</div>
          @else
          <div class="shop-verified" style="color:var(--muted)"><i class="fa-regular fa-circle"></i> Plan {{ strtoupper(Auth::user()->abonnement_plan ?? 'FREE') }}</div>
          @endif
          <div class="shop-stars-row"><span>★★★★★</span> ({{ $totalReviews }} avis)</div>
        </div>
        <div class="quick-actions">
          <div class="qa-title">Actions Rapides</div>
          <a href="{{ route('vendeur.products') }}" class="qa-item"><i class="fa-solid fa-box"></i> Gérer les produits</a>
          <a href="{{ route('vendeur.boutique.edit') }}" class="qa-item"><i class="fa-solid fa-pen-to-square"></i> Modifier ma boutique</a>
          <a href="{{ route('vendeur.orders') }}" class="qa-item"><i class="fa-solid fa-shopping-cart"></i> Voir les commandes</a>
          <form action="{{ route('logout') }}" method="POST" style="margin:0">
            @csrf
            <button type="submit" class="qa-item red" style="width:100%;background:none;border:none;cursor:pointer;font-family:inherit;font-size:13px"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</button>
          </form>
        </div>
        <div class="premium-banner">
          <i class="fa-solid fa-shield-halved"></i>
          @if(Auth::user()->hasActivePaidSubscription())
          <div class="premium-banner-title">Abonnement {{ strtoupper(Auth::user()->abonnement_plan) }} actif</div>
          <div class="premium-banner-sub">Expire le {{ Auth::user()->abonnement_expires_at?->format('d/m/Y') }}. <a href="{{ route('vendeur.abonnement.index') }}" style="color:#fff;font-weight:700">Gérer</a></div>
          @else
          <div class="premium-banner-title">Passez au Pro ou Premium</div>
          <div class="premium-banner-sub">Commandes illimitées, badge vérifié, statistiques et visibilité renforcée. <a href="{{ route('vendeur.abonnement.index') }}" style="color:#fff;font-weight:700">Découvrir</a></div>
          @endif
        </div>
      </div>
    </div>
    @endif

    {{-- ═══════════ SECTION : PRODUITS ═══════════ --}}
    @if($section === 'produits')
    <div class="page-head">
      <div>
        <div class="page-title">Mes Produits</div>
        <div class="page-sub">Gérez, modifiez et supprimez vos références catalogue. Chaque <strong>nouveau</strong> produit reste <strong>en attente de validation admin</strong> avant d’être visible et vendu.</div>
      </div>
      <a href="{{ route('vendeur.products.create') }}" class="btn-primary" style="text-decoration:none;display:inline-flex"><i class="fa-solid fa-plus"></i> Ajouter un produit</a>
    </div>

    <div class="card" style="margin-bottom:20px">
      <div class="card-head">
        <div><div class="card-title">Inventaire des Produits</div></div>
        <form action="{{ route('vendeur.products') }}" method="GET" class="search-wrap">
          <div class="search-wrap-inner">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input class="search-mini" type="text" name="q" value="{{ request('q') }}" placeholder="Chercher un produit…">
          </div>
        </form>
      </div>
      <div class="table-scroll">
      <table class="table">
        <thead>
          <tr>
            <th>Image</th><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Statut</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($produits as $produit)
          <tr>
            <td><img class="prod-thumb" src="{{ $produit->imageUrl() }}" alt="{{ $produit->nom }}"></td>
            <td><div class="prod-thumb-name">{{ $produit->nom }}</div></td>
            <td>{{ $produit->categorie->nom ?? '—' }}</td>
            <td>{{ money_fdj($produit->prix) }}</td>
            <td class="{{ $produit->stock == 0 ? 'text-danger' : '' }}">{{ $produit->stock }} pcs</td>
            <td>
              @if($produit->statut === 'actif')
              <span class="status-badge stock"><i class="fa-solid fa-circle" style="font-size:6px"></i> Publié · en stock</span>
              @elseif($produit->statut === 'rupture')
              <span class="status-badge rupture"><i class="fa-solid fa-circle" style="font-size:6px"></i> Publié · rupture</span>
              @elseif($produit->statut === 'en_attente_admin')
              <span class="status-badge en-validation"><i class="fa-regular fa-clock" style="font-size:9px"></i> Attente validation</span>
              @elseif($produit->statut === 'inactif')
              <span class="status-badge inactif"><i class="fa-solid fa-ban" style="font-size:9px"></i> Non publié</span>
              @else
              <span class="status-badge brouillon"><i class="fa-solid fa-circle" style="font-size:6px"></i> {{ $produit->statut }}</span>
              @endif
            </td>
            <td>
              <div class="table-actions">
                <button class="tbl-btn" onclick="openEditProduct({{ $produit->id }}, '{{ addslashes($produit->nom) }}', '{{ addslashes($produit->description) }}', {{ $produit->prix }}, {{ $produit->stock }}, {{ $produit->categorie_id ?? 'null' }})" title="Modifier"><i class="fa-solid fa-pen"></i></button>
                <form action="{{ route('vendeur.products.destroy', $produit) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer ce produit ?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="tbl-btn del" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:32px">Aucun produit. Ajoutez votre premier produit !</td></tr>
          @endforelse
        </tbody>
      </table>
      </div>
      @if(isset($produits) && $produits->hasPages())
      <div class="table-foot">
        <span>Page {{ $produits->currentPage() }} sur {{ $produits->lastPage() }} ({{ $produits->total() }} produits)</span>
        <div class="pag">
          @if($produits->onFirstPage())
            <span style="opacity:.5">Précédent</span>
          @else
            <a href="{{ $produits->previousPageUrl() }}">Précédent</a>
          @endif
          @for($i = 1; $i <= $produits->lastPage(); $i++)
            @if($i === $produits->currentPage())
              <span class="active">{{ $i }}</span>
            @else
              <a href="{{ $produits->url($i) }}">{{ $i }}</a>
            @endif
          @endfor
          @if($produits->hasMorePages())
            <a href="{{ $produits->nextPageUrl() }}">Suivant</a>
          @else
            <span style="opacity:.5">Suivant</span>
          @endif
        </div>
      </div>
      @endif
    </div>
    @endif

    {{-- ═══════════ SECTION : COMMANDES ═══════════ --}}
    @if($section === 'commandes')
    <div class="page-head">
      <div><div class="page-title">Commandes</div><div class="page-sub">Gérez les commandes contenant vos produits.</div></div>
    </div>

    <div class="card">
      <div class="table-scroll">
      <table class="table">
        <thead>
          <tr><th>Nº</th><th>Client</th><th>Produits</th><th>Montant</th><th>Statut</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
          <tr>
            <td style="font-family:'Space Grotesk',sans-serif;font-weight:600;color:var(--white)">CMD-{{ $order->id }}</td>
            <td>{{ $order->client->nom ?? 'Client supprimé' }}</td>
            <td style="min-width:220px">
              @forelse($order->details as $line)
                <div style="font-size:12px;line-height:1.45;margin-bottom:4px">
                  <span style="color:var(--white)">{{ $line->produit->nom ?? 'Produit supprimé' }}</span>
                  <span style="color:var(--muted)">x{{ $line->quantite }}</span>
                </div>
              @empty
                <span style="color:var(--muted)">—</span>
              @endforelse
            </td>
            <td style="font-weight:600">{{ money_fdj($order->montant_total) }}</td>
            <td><span class="order-status {{ $order->statut }}">{{ str_replace('_', ' ', $order->statut) }}</span></td>
            <td style="color:var(--muted)">{{ $order->date_commande?->format('d/m/Y') }}</td>
            <td>
              @if($order->statut === 'en_attente')
                <form action="{{ route('vendeur.orders.status', $order) }}" method="POST" style="display:flex;gap:5px;align-items:center">
                  @csrf
                  <input type="hidden" name="action" value="confirmer">
                  <button type="submit" class="tbl-btn" title="Confirmer la commande"><i class="fa-solid fa-check"></i></button>
                </form>
              @elseif(in_array($order->statut, ['confirmee', 'en_preparation', 'en_livraison']))
                <form action="{{ route('vendeur.orders.status', $order) }}" method="POST" style="display:flex;gap:5px;align-items:center">
                  @csrf
                  <input type="hidden" name="action" value="livrer">
                  <button type="submit" class="tbl-btn" title="Signaler la livraison"><i class="fa-solid fa-truck"></i></button>
                </form>
              @else
                <span style="font-size:12px;color:var(--muted)">Aucune action</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:32px">Aucune commande.</td></tr>
          @endforelse
        </tbody>
      </table>
      </div>
      @if(isset($orders) && $orders->hasPages())
      <div class="table-foot">
        <span>Page {{ $orders->currentPage() }} sur {{ $orders->lastPage() }}</span>
        <div class="pag">
          @if($orders->previousPageUrl())<a href="{{ $orders->previousPageUrl() }}">Précédent</a>@endif
          @if($orders->nextPageUrl())<a href="{{ $orders->nextPageUrl() }}">Suivant</a>@endif
        </div>
      </div>
      @endif
    </div>
    @endif

    {{-- ═══════════ SECTION : NOTIFICATIONS ═══════════ --}}
    @if(($section ?? '') === 'notifications' && isset($sellerNotifications))
    <div class="page-head">
      <div>
        <div class="page-title">Notifications</div>
        <div class="page-sub">Messages, validations et alertes catalogue (marquées comme lues lors de votre visite).</div>
      </div>
    </div>

    <div class="card" style="overflow:visible">
      <div style="padding:18px 20px;border-bottom:1px solid var(--border);font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:14px"><i class="fa-regular fa-bell" style="color:var(--orange);margin-right:8px"></i>Centre de notifications</div>
      <div style="padding:8px 0">
        @forelse($sellerNotifications as $n)
          @php
            $d = is_array($n->data) ? $n->data : (array) $n->data;
            $nType = class_basename($n->type);
          @endphp
          <div style="display:flex;justify-content:space-between;gap:14px;align-items:flex-start;padding:16px 20px;border-bottom:1px solid var(--border);transition:background var(--T)">
            <div style="flex:1;min-width:0">
              @if($nType === 'NewChatMessage')
                <div style="font-weight:700;font-size:13px;color:var(--white)">{{ $d['sender_name'] ?? 'Message' }}</div>
                <div style="color:var(--muted);font-size:13px;margin-top:4px;line-height:1.4">{{ $d['preview'] ?? '' }}</div>
                @isset($d['conversation_id'])
                  <a href="{{ route('vendeur.messages.show', $d['conversation_id']) }}" class="card-action" style="margin-top:10px;display:inline-flex;font-size:12px;text-decoration:none">Ouvrir la conversation <i class="fa-solid fa-chevron-right" style="margin-left:4px"></i></a>
                @endisset
              @elseif($nType === 'SellerProductValidated')
                <div style="font-weight:700;font-size:13px;color:var(--white)"><i class="fa-solid fa-circle-check" style="color:var(--success);margin-right:6px"></i> Produit validé</div>
                <div style="color:var(--muted);font-size:13px;margin-top:4px;line-height:1.4">{{ $d['preview'] ?? ($d['nom'] ?? 'Votre produit a été publié.') }}</div>
                @isset($d['produit_id'])
                  <a href="{{ route('public.products.show', $d['produit_id']) }}" class="card-action" style="margin-top:10px;display:inline-flex;font-size:12px;text-decoration:none" target="_blank" rel="noopener">Voir la fiche publique <i class="fa-solid fa-arrow-up-right-from-square" style="margin-left:4px;font-size:10px"></i></a>
                  <a href="{{ route('vendeur.products') }}" class="card-action" style="margin-top:10px;display:inline-flex;font-size:12px;text-decoration:none;margin-left:12px">Mes produits <i class="fa-solid fa-chevron-right" style="margin-left:4px"></i></a>
                @endisset
              @elseif($nType === 'SellerProductRejected')
                <div style="font-weight:700;font-size:13px;color:var(--white)"><i class="fa-solid fa-circle-xmark" style="color:var(--danger);margin-right:6px"></i> Produit non publié</div>
                <div style="color:var(--muted);font-size:13px;margin-top:4px;line-height:1.4">{{ $d['preview'] ?? 'Votre produit nécessite des modifications.' }}</div>
                <a href="{{ route('vendeur.products') }}" class="card-action" style="margin-top:10px;display:inline-flex;font-size:12px;text-decoration:none">Retour aux produits <i class="fa-solid fa-chevron-right" style="margin-left:4px"></i></a>
              @elseif(str_starts_with($nType, 'SellerSubscription'))
                <div style="font-weight:700;font-size:13px;color:var(--white)"><i class="fa-solid fa-crown" style="color:var(--orange);margin-right:6px"></i> {{ $d['title'] ?? 'Abonnement' }}</div>
                <div style="color:var(--muted);font-size:13px;margin-top:4px;line-height:1.4">{{ $d['body'] ?? '' }}</div>
                <a href="{{ route('vendeur.abonnement.index') }}" class="card-action" style="margin-top:10px;display:inline-flex;font-size:12px;text-decoration:none">Abonnement <i class="fa-solid fa-chevron-right" style="margin-left:4px"></i></a>
              @else
                <div style="font-weight:700;font-size:13px;color:var(--white)">Alerte</div>
                <div style="color:var(--muted);font-size:13px;margin-top:4px;line-height:1.4">{{ $d['preview'] ?? $d['message'] ?? 'Voir les détails dans votre espace.' }}</div>
              @endif
            </div>
            <small style="color:var(--muted);white-space:nowrap">{{ $n->created_at?->diffForHumans() }}</small>
          </div>
        @empty
          <div style="padding:40px;text-align:center;color:var(--muted);font-size:14px">
            <i class="fa-regular fa-bell-slash" style="font-size:28px;display:block;margin-bottom:10px;opacity:.5"></i>
            Aucune notification pour le moment.
          </div>
        @endforelse
      </div>
      @if($sellerNotifications->hasPages())
      <div class="table-foot">
        <span>Page {{ $sellerNotifications->currentPage() }} / {{ $sellerNotifications->lastPage() }}</span>
        <div class="pag">
          @if($sellerNotifications->previousPageUrl())<a href="{{ $sellerNotifications->previousPageUrl() }}">Précédent</a>@endif
          @if($sellerNotifications->nextPageUrl())<a href="{{ $sellerNotifications->nextPageUrl() }}">Suivant</a>@endif
        </div>
      </div>
      @endif
    </div>
    @endif

  </main>
</div>

<!-- MODAL : Modifier un produit -->
<div class="modal-overlay" id="editProductModal">
  <div class="modal">
    <div class="modal-title">Modifier le produit</div>
    <form id="editProductForm" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="form-group">
        <label>Nom du produit</label>
        <input type="text" name="nom" id="editProdNom" required>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" id="editProdDesc" required></textarea>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Prix (Fdj)</label>
          <input type="number" name="prix" id="editProdPrix" step="0.01" min="0" required>
        </div>
        <div class="form-group">
          <label>Stock</label>
          <input type="number" name="stock" id="editProdStock" min="0" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Catégorie</label>
          <select name="categorie_id" id="editProdCat" required @if(!empty($sellerCategoryId)) disabled @endif>
            <option value="">Sélectionner…</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
            @endforeach
          </select>
          @if(!empty($sellerCategoryId))
            <input type="hidden" name="categorie_id" value="{{ $sellerCategoryId }}">
          @endif
        </div>
        <div class="form-group">
          <label>Image principale (laisser vide pour conserver)</label>
          <input type="file" name="image_principale" accept="image/*">
        </div>
      </div>
      <div class="form-group">
        <label>Remplacer les images supplementaires</label>
        <input type="file" name="images_supplementaires[]" accept="image/*" multiple>
      </div>
      <div class="form-group">
        <label>Remplacer les videos supplementaires</label>
        <input type="file" name="videos_supplementaires[]" accept="video/mp4,video/webm,video/quicktime" multiple>
      </div>
      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Enregistrer</button>
        <button type="button" class="btn-primary btn-danger" onclick="document.getElementById('editProductModal').classList.remove('open')">Annuler</button>
      </div>
    </form>
  </div>
</div>

<a href="{{ route('vendeur.products.create') }}" class="fab" title="Nouveau produit" aria-label="Nouveau produit"><i class="fa-solid fa-plus"></i></a>

<footer>
  <span>© 2026 NexShop. Tous droits réservés.</span>
  <div><a href="#">Conditions d'utilisation</a><a href="#">Confidentialité</a><a href="#">Support</a></div>
</footer>

<script>
// Close modals on overlay click
document.querySelectorAll('.modal-overlay').forEach(m => {
  m.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('open'); });
});

function openEditProduct(id, nom, desc, prix, stock, catId) {
  document.getElementById('editProductForm').action = '/vendeur/products/' + id;
  document.getElementById('editProdNom').value = nom;
  document.getElementById('editProdDesc').value = desc;
  document.getElementById('editProdPrix').value = prix;
  document.getElementById('editProdStock').value = stock;
  document.getElementById('editProdCat').value = catId || '';
  document.getElementById('editProductModal').classList.add('open');
}
</script>
</body>
</html>
