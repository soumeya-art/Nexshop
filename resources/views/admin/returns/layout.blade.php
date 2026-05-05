<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('partials.theme-init')
<title>NexShop — Retours</title>
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

.navbar{height:60px;background:rgba(13,13,13,.96);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 24px;position:sticky;top:0;z-index:100;backdrop-filter:blur(20px);gap:20px}
.nav-logo{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white)}
.nav-logo span{color:var(--orange)}
.admin-badge{background:rgba(255,107,53,.12);border:1px solid rgba(255,107,53,.25);color:var(--orange);font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;padding:3px 10px;border-radius:50px;letter-spacing:.05em}
.nav-right{margin-left:auto;display:flex;align-items:center;gap:8px}
.nav-logout-btn{display:inline-flex;align-items:center;gap:7px;padding:8px 14px;border-radius:var(--radius-xs);border:1px solid var(--border);background:var(--bg3);color:var(--muted);font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all var(--T)}
.nav-logout-btn:hover{border-color:var(--danger);color:var(--danger);background:rgba(239,68,68,.1)}

.layout{display:flex;flex:1}
.sidebar{width:210px;flex-shrink:0;background:var(--bg2);border-right:1px solid var(--border);padding:16px 10px;display:flex;flex-direction:column;gap:2px;position:sticky;top:60px;height:calc(100vh - 60px);overflow-y:auto}
.sb-label{font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted2);padding:12px 10px 5px}
.sb-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:var(--radius-xs);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;transition:all var(--T);border:1px solid transparent}
.sb-item:hover{background:var(--bg3);color:var(--text)}
.sb-item.active{background:rgba(255,107,53,.1);color:var(--orange);border-color:rgba(255,107,53,.15)}
.sb-item i{width:15px;text-align:center;font-size:13px}
.sb-bottom{margin-top:auto}
.sb-logout{color:var(--danger) !important}

.main{flex:1;padding:24px 28px;overflow-y:auto;min-width:0}

.page-title{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white);margin-bottom:3px}
.page-sub{font-size:12px;color:var(--muted);margin-bottom:4px}

.card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:18px}
.card-head{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
.card-title{font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:800;color:var(--white)}
.card-body{padding:20px}

.table{width:100%;border-collapse:collapse}
.table th{padding:11px 16px;text-align:left;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--muted);letter-spacing:.07em;text-transform:uppercase;border-bottom:1px solid var(--border);background:var(--bg3)}
.table td{padding:12px 16px;font-size:13px;border-bottom:1px solid var(--border);vertical-align:middle}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:rgba(255,255,255,.02)}
.status-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:50px;font-size:10px;font-weight:700;font-family:'Space Grotesk',sans-serif}
.status-badge.actif{background:rgba(34,197,94,.1);color:var(--success);border:1px solid rgba(34,197,94,.2)}
.status-badge.inactif{background:rgba(156,163,175,.1);color:#9ca3af;border:1px solid rgba(156,163,175,.2)}
.status-badge.banni{background:rgba(239,68,68,.1);color:var(--danger);border:1px solid rgba(239,68,68,.2)}
.tbl-btn{width:28px;height:28px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:11px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all var(--T)}
.tbl-btn:hover{border-color:var(--orange);color:var(--orange)}
.table-foot{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid var(--border)}
.table-foot span{font-size:12px;color:var(--muted)}
.pag{display:flex;gap:4px}
.pag a{height:28px;padding:0 10px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:12px;cursor:pointer;transition:all var(--T);display:flex;align-items:center;text-decoration:none}
.pag a:hover{background:var(--orange);border-color:var(--orange);color:#fff}

.alert{padding:12px 16px;border-radius:var(--radius-xs);margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px}
.alert-success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:var(--success)}

.btn-primary{display:inline-flex;align-items:center;gap:8px;background:var(--orange);color:#fff;border:none;padding:9px 18px;border-radius:var(--radius-xs);font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:all var(--T);box-shadow:0 4px 14px rgba(255,107,53,.3)}
.btn-primary:hover{background:var(--orange2)}
.btn-sm{padding:6px 12px;font-size:11px}
.btn-danger{background:var(--danger);box-shadow:0 4px 14px rgba(239,68,68,.3)}
.btn-danger:hover{background:#DC2626}
.btn-success{background:var(--success);box-shadow:0 4px 14px rgba(34,197,94,.3)}
.btn-success:hover{background:#16A34A}

@media(max-width:768px){
  .sidebar{display:none}
  .main{padding:18px 14px}
}
</style>
@include('partials.theme-manager')
</head>
<body>

@php
  $__pendingKycVendeurs = \App\Models\User::where('type_compte', 'vendeur')->where('statut_kyc', 'en_attente')->count();
  $__pendingReturns = \App\Models\DemandeRetour::where('statut', 'en_attente')->count();
  $__unreadContact = \App\Models\ContactMessage::where('lu', false)->count();
@endphp

<nav class="navbar">
  <a href="{{ route('admin.home') }}" class="nav-logo">Nex<span>Shop</span></a>
  <span class="admin-badge">ADMIN</span>
  <div class="nav-right">
    <span style="font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;color:var(--text)">{{ Auth::user()->nom }}</span>
    <a href="{{ route('logout') }}" class="nav-logout-btn"><i class="fa-solid fa-right-from-bracket"></i><span>Déconnexion</span></a>
  </div>
</nav>

<div class="layout">
  <aside class="sidebar">
    <div class="sb-label">Administration</div>
    <a href="{{ route('admin.home') }}" class="sb-item"><i class="fa-solid fa-chart-line"></i> Statistiques</a>
    <a href="{{ route('admin.users') }}" class="sb-item"><i class="fa-solid fa-users"></i> Utilisateurs</a>
    <a href="{{ route('admin.moderation') }}" class="sb-item"><i class="fa-regular fa-comment"></i> Modération avis</a>
    <a href="{{ route('admin.produits.moderation') }}" class="sb-item"><i class="fa-solid fa-shirt"></i> Produits à valider</a>
    <a href="{{ route('admin.kyc.index') }}" class="sb-item"><i class="fa-solid fa-id-card-clip"></i> Inscriptions vendeurs</a>
    <a href="{{ route('admin.categories') }}" class="sb-item"><i class="fa-solid fa-layer-group"></i> Catégories</a>
    <a href="{{ route('admin.subscriptions.index') }}" class="sb-item"><i class="fa-solid fa-crown"></i> Abonnements</a>
    <a href="{{ route('admin.contact-messages.index') }}" class="sb-item"><i class="fa-solid fa-envelope"></i> Messages contact @if($__unreadContact > 0)<span style="margin-left:auto;font-size:10px;font-weight:800;color:var(--orange)">{{ $__unreadContact }}</span>@endif</a>
    <a href="{{ route('admin.returns.index') }}" class="sb-item {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}"><i class="fa-solid fa-rotate-left"></i> Retours @if($__pendingReturns > 0)<span style="margin-left:auto;font-size:10px;font-weight:800;color:var(--orange)">{{ $__pendingReturns }}</span>@endif</a>
    <div class="sb-bottom">
      <a href="{{ route('logout') }}" class="sb-item sb-logout"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>
    </div>
  </aside>

  <main class="main">
    @yield('returns-content')
  </main>
</div>
</body>
</html>
