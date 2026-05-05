<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>NexShop — Administration</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@if($section === 'stats')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
@endif
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
.nav-logo{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white)}
.nav-logo span{color:var(--orange)}
.admin-badge{background:rgba(255,107,53,.12);border:1px solid rgba(255,107,53,.25);color:var(--orange);font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;padding:3px 10px;border-radius:50px;letter-spacing:.05em}
.nav-right{margin-left:auto;display:flex;align-items:center;gap:8px}
.nav-icon{width:36px;height:36px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:14px;cursor:pointer;transition:all var(--T);position:relative}
.nav-icon:hover{border-color:var(--orange);color:var(--orange)}
.nav-badge{position:absolute;top:-4px;right:-4px;width:16px;height:16px;border-radius:50%;background:var(--orange);color:#fff;font-size:9px;font-weight:800;font-family:'Space Grotesk',sans-serif;display:flex;align-items:center;justify-content:center;border:2px solid var(--bg)}
.nav-avatar{width:34px;height:34px;border-radius:50%;border:2px solid var(--orange);overflow:hidden;cursor:pointer}
.nav-avatar img{width:100%;height:100%;object-fit:cover}
.nav-user-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;color:var(--text)}

/* LAYOUT */
.layout{display:flex;flex:1}
.sidebar{width:210px;flex-shrink:0;background:var(--bg2);border-right:1px solid var(--border);padding:16px 10px;display:flex;flex-direction:column;gap:2px;position:sticky;top:60px;height:calc(100vh - 60px);overflow-y:auto}
.sb-label{font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted2);padding:12px 10px 5px}
.sb-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:var(--radius-xs);color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;transition:all var(--T);border:1px solid transparent}
.sb-item:hover{background:var(--bg3);color:var(--text)}
.sb-item.active{background:rgba(255,107,53,.1);color:var(--orange);border-color:rgba(255,107,53,.15)}
.sb-item i{width:15px;text-align:center;font-size:13px}
.sb-bottom{margin-top:auto}
.sb-logout{color:var(--danger) !important}

/* MAIN */
.main{flex:1;padding:24px 28px;overflow-y:auto;min-width:0}

/* TOP TABS */
.top-tabs{display:flex;gap:2px;border-bottom:1px solid var(--border);margin-bottom:24px}
.top-tab{padding:10px 18px;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;transition:all var(--T);border-bottom:2px solid transparent;display:flex;align-items:center;gap:7px;margin-bottom:-1px}
.top-tab:hover{color:var(--text)}
.top-tab.active{color:var(--orange);border-bottom-color:var(--orange)}

.page-title{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--white);margin-bottom:3px}
.page-sub{font-size:12px;color:var(--muted);margin-bottom:22px}

/* KPIs */
.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
.kpi-card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:20px;position:relative;overflow:hidden;transition:border-color var(--T)}
.kpi-card:hover{border-color:rgba(255,107,53,.2)}
.kpi-label{font-size:11px;color:var(--muted);font-weight:500;margin-bottom:8px;text-transform:uppercase;letter-spacing:.07em;font-family:'Space Grotesk',sans-serif}
.kpi-val{font-family:'Space Grotesk',sans-serif;font-size:26px;font-weight:800;color:var(--white);margin-bottom:6px}
.kpi-trend{font-size:11px;display:flex;align-items:center;gap:4px}
.kpi-trend.up{color:var(--success)}
.kpi-trend.down{color:var(--danger)}
.kpi-icon{position:absolute;top:18px;right:18px;width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:17px}
.kpi-icon.orange{background:rgba(255,107,53,.1);color:var(--orange)}
.kpi-icon.blue{background:rgba(30,144,255,.1);color:var(--blue)}
.kpi-icon.green{background:rgba(34,197,94,.1);color:var(--success)}
.kpi-icon.yellow{background:rgba(245,158,11,.1);color:var(--warning)}

/* CHARTS ROW */
.charts-row{display:grid;grid-template-columns:1fr 340px;gap:18px;margin-bottom:24px}
.card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.card-head{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
.card-title{font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:800;color:var(--white)}
.card-sub{font-size:11px;color:var(--muted);margin-top:2px}
.card-body{padding:20px}
canvas{max-width:100%}

/* TABLE */
.table{width:100%;border-collapse:collapse}
.table th{padding:11px 16px;text-align:left;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--muted);letter-spacing:.07em;text-transform:uppercase;border-bottom:1px solid var(--border);background:var(--bg3)}
.table td{padding:12px 16px;font-size:13px;border-bottom:1px solid var(--border);vertical-align:middle}
.table tr:last-child td{border-bottom:none}
.table tr:hover td{background:rgba(255,255,255,.02)}
.status-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:50px;font-size:10px;font-weight:700;font-family:'Space Grotesk',sans-serif}
.status-badge.actif{background:rgba(34,197,94,.1);color:var(--success);border:1px solid rgba(34,197,94,.2)}
.status-badge.inactif{background:rgba(156,163,175,.1);color:#9ca3af;border:1px solid rgba(156,163,175,.2)}
.status-badge.banni{background:rgba(239,68,68,.1);color:var(--danger);border:1px solid rgba(239,68,68,.2)}
.table-actions{display:flex;gap:5px}
.tbl-btn{width:28px;height:28px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:11px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all var(--T)}
.tbl-btn:hover{border-color:var(--orange);color:var(--orange)}
.tbl-btn.del:hover{border-color:var(--danger);color:var(--danger)}
.table-foot{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid var(--border)}
.table-foot span{font-size:12px;color:var(--muted)}
.pag{display:flex;gap:4px}
.pag a,.pag span{height:28px;padding:0 10px;border-radius:var(--radius-xs);background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:12px;cursor:pointer;transition:all var(--T);display:flex;align-items:center;text-decoration:none}
.pag a:hover,.pag span.active{background:var(--orange);border-color:var(--orange);color:#fff}

/* ALERT */
.alert{padding:12px 16px;border-radius:var(--radius-xs);margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px}
.alert-success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:var(--success)}
.alert-error{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:var(--danger)}

/* SEARCH */
.search-mini{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:7px 12px 7px 32px;color:var(--white);font-size:12px;outline:none;width:200px;font-family:'Inter',sans-serif}
.search-mini::placeholder{color:var(--muted)}
.search-wrap-inner{position:relative;display:inline-block}
.search-wrap-inner i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:11px}

/* FORM */
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px}
.form-group{display:flex;flex-direction:column;gap:5px;margin-bottom:12px}
.form-group label{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em}
.form-group input,.form-group textarea,.form-group select{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:9px 12px;color:var(--white);font-size:13px;outline:none;font-family:'Inter',sans-serif}
.form-group input:focus,.form-group textarea:focus,.form-group select:focus{border-color:var(--orange)}
.btn-primary{display:inline-flex;align-items:center;gap:8px;background:var(--orange);color:#fff;border:none;padding:9px 18px;border-radius:var(--radius-xs);font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:all var(--T);box-shadow:0 4px 14px rgba(255,107,53,.3)}
.btn-primary:hover{background:var(--orange2)}
.btn-sm{padding:6px 12px;font-size:11px}
.btn-danger{background:var(--danger);box-shadow:0 4px 14px rgba(239,68,68,.3)}
.btn-danger:hover{background:#DC2626}
.btn-success{background:var(--success);box-shadow:0 4px 14px rgba(34,197,94,.3)}
.btn-success:hover{background:#16A34A}

/* MODERATION */
.review-card{background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius);padding:16px;margin-bottom:12px}
.review-header{display:flex;align-items:center;gap:10px;margin-bottom:10px}
.review-author{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:var(--white)}
.review-product{font-size:11px;color:var(--muted)}
.review-stars{color:#FCD34D;font-size:12px}
.review-text{font-size:13px;color:var(--text);line-height:1.6;margin-bottom:12px}
.review-actions{display:flex;gap:8px}

/* SECURITY BANNER */
.sec-banner{background:linear-gradient(135deg,rgba(34,197,94,.12),rgba(34,197,94,.06));border:1px solid rgba(34,197,94,.2);border-radius:var(--radius-sm);padding:14px 20px;display:flex;align-items:center;gap:12px;position:fixed;bottom:24px;right:24px;z-index:200;max-width:360px;box-shadow:0 8px 32px rgba(0,0,0,.6)}
.sec-banner i{font-size:22px;color:var(--success)}
.sec-banner-title{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:800;color:var(--white)}
.sec-banner-sub{font-size:11px;color:var(--muted);margin-top:2px}

footer{border-top:1px solid var(--border);padding:14px 28px;display:flex;align-items:center;justify-content:space-between;font-size:12px;color:var(--muted);background:var(--bg2)}
footer a{color:var(--muted);margin-left:16px}footer a:hover{color:var(--orange)}

/* MODAL */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:300;align-items:center;justify-content:center}
.modal-overlay.open{display:flex}
.modal{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:24px;max-width:480px;width:90%;max-height:80vh;overflow-y:auto}
.modal-title{font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:800;color:var(--white);margin-bottom:16px}
</style>
</head>
<body>

<nav class="navbar">
  <a href="{{ route('admin.home') }}" class="nav-logo">Nex<span>Shop</span></a>
  <span class="admin-badge">ADMIN</span>
  <div class="nav-right">
    <div class="nav-icon"><i class="fa-regular fa-bell"></i><span class="nav-badge">{{ $pendingReviews }}</span></div>
    <span class="nav-user-name">{{ Auth::user()->nom }}</span>
  </div>
</nav>

<div class="layout">
  <aside class="sidebar">
    <div class="sb-label">Administration</div>
    <a href="{{ route('admin.home') }}" class="sb-item {{ $section === 'stats' ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> Statistiques</a>
    <a href="{{ route('admin.users') }}" class="sb-item {{ $section === 'users' ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Utilisateurs</a>
    <a href="{{ route('admin.moderation') }}" class="sb-item {{ $section === 'moderation' ? 'active' : '' }}"><i class="fa-regular fa-comment"></i> Modération</a>
    <a href="{{ route('admin.categories') }}" class="sb-item {{ $section === 'categories' ? 'active' : '' }}"><i class="fa-solid fa-layer-group"></i> Catégories</a>
    <div class="sb-bottom">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="sb-item sb-logout" style="width:100%;background:none;border:1px solid transparent;cursor:pointer;font-family:inherit"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</button>
      </form>
    </div>
  </aside>

  <main class="main">
    <!-- TOP TABS -->
    <div class="top-tabs">
      <a href="{{ route('admin.home') }}" class="top-tab {{ $section === 'stats' ? 'active' : '' }}"><i class="fa-solid fa-chart-bar"></i> Stats</a>
      <a href="{{ route('admin.users') }}" class="top-tab {{ $section === 'users' ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Utilisateurs</a>
      <a href="{{ route('admin.moderation') }}" class="top-tab {{ $section === 'moderation' ? 'active' : '' }}"><i class="fa-regular fa-comment"></i> Modération</a>
      <a href="{{ route('admin.categories') }}" class="top-tab {{ $section === 'categories' ? 'active' : '' }}"><i class="fa-solid fa-layer-group"></i> Catégories</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
    @endif

    {{-- ═══════════ SECTION : STATISTIQUES ═══════════ --}}
    @if($section === 'stats')
    <div class="page-title">Tableau de bord</div>
    <div class="page-sub">Aperçu global de la performance de NexShop.</div>

    <!-- KPIs -->
    <div class="kpi-grid">
      <div class="kpi-card">
        <div class="kpi-icon orange"><i class="fa-solid fa-chart-line"></i></div>
        <div class="kpi-label">Ventes Totales</div>
        <div class="kpi-val">{{ number_format($totalSales, 0, ',', ' ') }} DA</div>
        <div class="kpi-trend {{ $salesTrend >= 0 ? 'up' : 'down' }}">
          <i class="fa-solid fa-arrow-{{ $salesTrend >= 0 ? 'up' : 'down' }}"></i> {{ $salesTrend >= 0 ? '+' : '' }}{{ $salesTrend }}% par rapport au mois dernier
        </div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon blue"><i class="fa-solid fa-users"></i></div>
        <div class="kpi-label">Utilisateurs Actifs</div>
        <div class="kpi-val">{{ number_format($activeUsers, 0, ',', ' ') }}</div>
        <div class="kpi-trend {{ $usersTrend >= 0 ? 'up' : 'down' }}">
          <i class="fa-solid fa-arrow-{{ $usersTrend >= 0 ? 'up' : 'down' }}"></i> {{ $usersTrend >= 0 ? '+' : '' }}{{ $usersTrend }}% par rapport au mois dernier
        </div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon yellow"><i class="fa-regular fa-comment"></i></div>
        <div class="kpi-label">Avis en attente</div>
        <div class="kpi-val">{{ $pendingReviews }}</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon green"><i class="fa-solid fa-layer-group"></i></div>
        <div class="kpi-label">Catégories</div>
        <div class="kpi-val">{{ $categoriesCount }}</div>
      </div>
    </div>

    <!-- CHARTS -->
    <div class="charts-row">
      <div class="card">
        <div class="card-head">
          <div>
            <div class="card-title">Flux de Transactions</div>
            <div class="card-sub">Volume des transactions quotidiennes sur les 7 derniers jours.</div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="lineChart" height="200"></canvas>
        </div>
      </div>
      <div class="card">
        <div class="card-head">
          <div>
            <div class="card-title">Répartition par Catégorie</div>
            <div class="card-sub">Part des ventes par secteur.</div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="donutChart" height="220"></canvas>
          <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:16px">
            @foreach($donutLabels as $i => $label)
            @php $colors = ['#EF4444','#1E90FF','#1C7C54','#E8B84B','#A855F7']; @endphp
            <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:var(--muted)">
              <span style="width:10px;height:10px;border-radius:50%;background:{{ $colors[$i % count($colors)] }};display:inline-block"></span>{{ $label }}
            </span>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    @endif

    {{-- ═══════════ SECTION : UTILISATEURS ═══════════ --}}
    @if($section === 'users')
    <div class="page-title">Gestion des utilisateurs</div>
    <div class="page-sub">Gérez, filtrez et modérez les comptes utilisateurs.</div>

    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px">
      <form action="{{ route('admin.users') }}" method="GET" style="display:flex;gap:10px;flex:1">
        <div class="search-wrap-inner">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input class="search-mini" type="text" name="q" value="{{ request('q') }}" placeholder="Chercher un utilisateur…">
        </div>
        <select name="role" style="background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:7px 12px;color:var(--white);font-size:12px;outline:none;font-family:'Inter',sans-serif">
          <option value="">Tous les rôles</option>
          <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
          <option value="vendeur" {{ request('role') === 'vendeur' ? 'selected' : '' }}>Vendeur</option>
          <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <button type="submit" class="btn-primary btn-sm"><i class="fa-solid fa-search"></i> Filtrer</button>
      </form>
    </div>

    <div class="card">
      <table class="table">
        <thead>
          <tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Inscription</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($users as $user)
          <tr>
            <td style="font-family:'Space Grotesk',sans-serif;font-weight:600;color:var(--white)">{{ $user->nom }}</td>
            <td>{{ $user->email }}</td>
            <td><span style="text-transform:capitalize">{{ $user->type_compte }}</span></td>
            <td>
              <span class="status-badge {{ $user->statut }}">
                <i class="fa-solid fa-circle" style="font-size:6px"></i> {{ $user->statut }}
              </span>
            </td>
            <td style="color:var(--muted)">{{ $user->created_at?->format('d/m/Y') ?? '—' }}</td>
            <td>
              @if($user->id !== Auth::id())
              <form action="{{ route('admin.users.toggleBan', $user) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="tbl-btn {{ $user->statut === 'banni' ? '' : 'del' }}" title="{{ $user->statut === 'banni' ? 'Réactiver' : 'Bannir' }}">
                  <i class="fa-solid {{ $user->statut === 'banni' ? 'fa-user-check' : 'fa-user-slash' }}"></i>
                </button>
              </form>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:32px">Aucun utilisateur trouvé.</td></tr>
          @endforelse
        </tbody>
      </table>
      @if($users->hasPages())
      <div class="table-foot">
        <span>Page {{ $users->currentPage() }} sur {{ $users->lastPage() }}</span>
        <div class="pag">
          @if($users->onFirstPage())
            <span style="opacity:.5">Précédent</span>
          @else
            <a href="{{ $users->previousPageUrl() }}">Précédent</a>
          @endif
          @for($i = 1; $i <= $users->lastPage(); $i++)
            @if($i === $users->currentPage())
              <span class="active">{{ $i }}</span>
            @else
              <a href="{{ $users->url($i) }}">{{ $i }}</a>
            @endif
          @endfor
          @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}">Suivant</a>
          @else
            <span style="opacity:.5">Suivant</span>
          @endif
        </div>
      </div>
      @endif
    </div>
    @endif

    {{-- ═══════════ SECTION : MODÉRATION ═══════════ --}}
    @if($section === 'moderation')
    <div class="page-title">Modération des avis</div>
    <div class="page-sub">Approuvez ou refusez les avis clients en attente de validation.</div>

    @forelse($avis as $review)
    <div class="review-card">
      <div class="review-header">
        <div>
          <div class="review-author">{{ $review->client->nom ?? 'Utilisateur supprimé' }}</div>
          <div class="review-product">Sur : {{ $review->produit->nom ?? 'Produit supprimé' }} • {{ $review->date_avis?->format('d/m/Y') }}</div>
        </div>
        <div class="review-stars" style="margin-left:auto">
          @for($i = 1; $i <= 5; $i++)
            @if($i <= $review->note) ★ @else ☆ @endif
          @endfor
        </div>
      </div>
      <div class="review-text">{{ $review->commentaire ?? 'Aucun commentaire.' }}</div>
      <div class="review-actions">
        <form action="{{ route('admin.moderation.approve', $review) }}" method="POST" style="display:inline">
          @csrf
          <button type="submit" class="btn-primary btn-success btn-sm"><i class="fa-solid fa-check"></i> Approuver</button>
        </form>
        <form action="{{ route('admin.moderation.reject', $review) }}" method="POST" style="display:inline">
          @csrf
          <button type="submit" class="btn-primary btn-danger btn-sm"><i class="fa-solid fa-times"></i> Refuser</button>
        </form>
      </div>
    </div>
    @empty
    <div class="card" style="padding:40px;text-align:center">
      <i class="fa-solid fa-check-circle" style="font-size:40px;color:var(--success);margin-bottom:12px"></i>
      <div style="font-family:'Space Grotesk',sans-serif;font-size:16px;font-weight:700;color:var(--white);margin-bottom:4px">Aucun avis en attente</div>
      <div style="font-size:13px;color:var(--muted)">Tous les avis ont été modérés.</div>
    </div>
    @endforelse

    @if(isset($avis) && $avis->hasPages())
    <div style="display:flex;justify-content:center;margin-top:20px">
      <div class="pag">
        @if($avis->previousPageUrl())<a href="{{ $avis->previousPageUrl() }}">Précédent</a>@endif
        @if($avis->nextPageUrl())<a href="{{ $avis->nextPageUrl() }}">Suivant</a>@endif
      </div>
    </div>
    @endif
    @endif

    {{-- ═══════════ SECTION : CATÉGORIES ═══════════ --}}
    @if($section === 'categories')
    <div class="page-title">Gestion des catégories</div>
    <div class="page-sub">Créez, modifiez et supprimez les catégories du catalogue.</div>

    <!-- Formulaire d'ajout -->
    <div class="card" style="margin-bottom:20px">
      <div class="card-head"><div class="card-title">Ajouter une catégorie</div></div>
      <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label>Nom</label>
              <input type="text" name="nom" placeholder="Ex: Électronique" required>
            </div>
            <div class="form-group">
              <label>Icône (classe FontAwesome)</label>
              <input type="text" name="icone" placeholder="Ex: fa-solid fa-laptop">
            </div>
          </div>
          <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" placeholder="Description courte…">
          </div>
          <button type="submit" class="btn-primary"><i class="fa-solid fa-plus"></i> Ajouter</button>
        </form>
      </div>
    </div>

    <!-- Liste des catégories -->
    <div class="card">
      <table class="table">
        <thead>
          <tr><th>Icône</th><th>Nom</th><th>Description</th><th>Produits</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($categories as $cat)
          <tr>
            <td><i class="{{ $cat->icone ?? 'fa-solid fa-tag' }}" style="color:var(--orange);font-size:16px"></i></td>
            <td style="font-family:'Space Grotesk',sans-serif;font-weight:600;color:var(--white)">{{ $cat->nom }}</td>
            <td style="color:var(--muted)">{{ $cat->description ?? '—' }}</td>
            <td>{{ $cat->produits_count ?? 0 }}</td>
            <td>
              <div class="table-actions">
                <button class="tbl-btn" onclick="openEditCat({{ $cat->id }}, '{{ addslashes($cat->nom) }}', '{{ addslashes($cat->description ?? '') }}', '{{ addslashes($cat->icone ?? '') }}')" title="Modifier"><i class="fa-solid fa-pen"></i></button>
                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer cette catégorie ?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="tbl-btn del" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:32px">Aucune catégorie.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Modal édition catégorie -->
    <div class="modal-overlay" id="editCatModal">
      <div class="modal">
        <div class="modal-title">Modifier la catégorie</div>
        <form id="editCatForm" method="POST">
          @csrf @method('PUT')
          <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" id="editCatNom" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" id="editCatDesc">
          </div>
          <div class="form-group">
            <label>Icône</label>
            <input type="text" name="icone" id="editCatIcone">
          </div>
          <div style="display:flex;gap:10px;margin-top:16px">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Enregistrer</button>
            <button type="button" class="btn-primary btn-danger" onclick="document.getElementById('editCatModal').classList.remove('open')">Annuler</button>
          </div>
        </form>
      </div>
    </div>
    @endif

</main>
</div>

<div class="sec-banner">
  <i class="fa-solid fa-shield-halved"></i>
  <div>
    <div class="sec-banner-title">Système sécurisé</div>
    <div class="sec-banner-sub">Connecté en tant qu'admin : {{ Auth::user()->nom }}</div>
  </div>
</div>

<footer>
  <span>© 2026 NexShop. Tous droits réservés.</span>
  <div><a href="#">Conditions d'utilisation</a><a href="#">Confidentialité</a><a href="#">Support</a></div>
</footer>

@if($section === 'stats')
<script>
// Line chart
const lCtx = document.getElementById('lineChart').getContext('2d');
new Chart(lCtx, {
  type: 'line',
  data: {
    labels: @json($chartLabels),
    datasets: [{
      data: @json($chartData),
      borderColor: '#FF6B35',
      backgroundColor: 'rgba(255,107,53,.08)',
      borderWidth: 2.5,
      pointBackgroundColor: '#FF6B35',
      pointRadius: 4,
      pointHoverRadius: 6,
      fill: true,
      tension: 0.45
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      x: { grid: { color: 'rgba(255,255,255,.04)' }, ticks: { color: '#777', font: { size: 11 } } },
      y: { grid: { color: 'rgba(255,255,255,.04)' }, ticks: { color: '#777', font: { size: 11 } }, beginAtZero: true }
    }
  }
});

// Donut chart
const donutColors = ['#EF4444', '#1E90FF', '#1C7C54', '#E8B84B', '#A855F7'];
const dCtx = document.getElementById('donutChart').getContext('2d');
new Chart(dCtx, {
  type: 'doughnut',
  data: {
    labels: @json($donutLabels),
    datasets: [{
      data: @json($donutData),
      backgroundColor: donutColors.slice(0, @json(count($donutLabels))),
      borderWidth: 0,
      hoverOffset: 6
    }]
  },
  options: {
    responsive: true,
    cutout: '65%',
    plugins: { legend: { display: false } }
  }
});
</script>
@endif

@if($section === 'categories')
<script>
function openEditCat(id, nom, desc, icone) {
  document.getElementById('editCatForm').action = '/admin/categories/' + id;
  document.getElementById('editCatNom').value = nom;
  document.getElementById('editCatDesc').value = desc;
  document.getElementById('editCatIcone').value = icone;
  document.getElementById('editCatModal').classList.add('open');
}
document.getElementById('editCatModal').addEventListener('click', function(e) {
  if (e.target === this) this.classList.remove('open');
});
</script>
@endif

</body>
</html>
