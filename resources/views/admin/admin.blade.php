<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NexShop — Administration</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
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

/* SECURITY BANNER */
.sec-banner{background:linear-gradient(135deg,rgba(34,197,94,.12),rgba(34,197,94,.06));border:1px solid rgba(34,197,94,.2);border-radius:var(--radius-sm);padding:14px 20px;display:flex;align-items:center;gap:12px;position:fixed;bottom:24px;right:24px;z-index:200;max-width:360px;box-shadow:0 8px 32px rgba(0,0,0,.6)}
.sec-banner i{font-size:22px;color:var(--success)}
.sec-banner-title{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:800;color:var(--white)}
.sec-banner-sub{font-size:11px;color:var(--muted);margin-top:2px}

footer{border-top:1px solid var(--border);padding:14px 28px;display:flex;align-items:center;justify-content:space-between;font-size:12px;color:var(--muted);background:var(--bg2)}
footer a{color:var(--muted);margin-left:16px}footer a:hover{color:var(--orange)}
</style>
</head>
<body>

<nav class="navbar">
  <a href="#" class="nav-logo">Nex<span>Shop</span></a>
  <span class="admin-badge">ADMIN</span>
  <div class="nav-right">
    <div class="nav-icon"><i class="fa-regular fa-bell"></i><span class="nav-badge">5</span></div>
    <div class="nav-avatar"><img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&q=80" alt=""></div>
  </div>
</nav>

<div class="layout">
  <aside class="sidebar">
    <div class="sb-label">Administration</div>
    <div class="sb-item active"><i class="fa-solid fa-chart-line"></i> Statistiques</div>
    <div class="sb-item"><i class="fa-solid fa-users"></i> Utilisateurs</div>
    <div class="sb-item"><i class="fa-regular fa-comment"></i> Modération</div>
    <div class="sb-item"><i class="fa-solid fa-layer-group"></i> Catégories</div>
    <div class="sb-item"><i class="fa-solid fa-gear"></i> Paramètres</div>
    <div class="sb-bottom">
      <div class="sb-item sb-logout"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</div>
    </div>
  </aside>

  <main class="main">
    <!-- TOP TABS -->
    <div class="top-tabs">
      <div class="top-tab active"><i class="fa-solid fa-chart-bar"></i> Stats</div>
      <div class="top-tab"><i class="fa-solid fa-users"></i> Utilisateurs</div>
      <div class="top-tab"><i class="fa-regular fa-comment"></i> Modération</div>
      <div class="top-tab"><i class="fa-solid fa-layer-group"></i> Catégories</div>
    </div>

    <div class="page-title">Tableau de bord</div>
    <div class="page-sub">Aperçu global de la performance de NexShop.</div>

    <!-- KPIs -->
    <div class="kpi-grid">
      <div class="kpi-card">
        <div class="kpi-icon orange"><i class="fa-solid fa-chart-line"></i></div>
        <div class="kpi-label">Ventes Totales</div>
        <div class="kpi-val">124 500 €</div>
        <div class="kpi-trend up"><i class="fa-solid fa-arrow-up"></i> +12.5% par rapport au mois dernier</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon blue"><i class="fa-solid fa-users"></i></div>
        <div class="kpi-label">Utilisateurs Actifs</div>
        <div class="kpi-val">8 920</div>
        <div class="kpi-trend up"><i class="fa-solid fa-arrow-up"></i> +4.3% par rapport au mois dernier</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon yellow"><i class="fa-regular fa-comment"></i></div>
        <div class="kpi-label">Avis en attente</div>
        <div class="kpi-val">42</div>
        <div class="kpi-trend down"><i class="fa-solid fa-arrow-down"></i> -18.2% par rapport au mois dernier</div>
      </div>
      <div class="kpi-card">
        <div class="kpi-icon green"><i class="fa-solid fa-layer-group"></i></div>
        <div class="kpi-label">Catégories</div>
        <div class="kpi-val">18</div>
        <div class="kpi-trend up"><i class="fa-solid fa-minus"></i> 0% par rapport au mois dernier</div>
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
            <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:var(--muted)"><span style="width:10px;height:10px;border-radius:50%;background:#EF4444;display:inline-block"></span>Électronique</span>
            <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:var(--muted)"><span style="width:10px;height:10px;border-radius:50%;background:#1E90FF;display:inline-block"></span>Mode</span>
            <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:var(--muted)"><span style="width:10px;height:10px;border-radius:50%;background:#1C7C54;display:inline-block"></span>Maison</span>
            <span style="display:flex;align-items:center;gap:5px;font-size:11px;color:var(--muted)"><span style="width:10px;height:10px;border-radius:50%;background:#E8B84B;display:inline-block"></span>Beauté</span>
          </div>
        </div>
      </div>
    </div>

</main>
</div>

<div class="sec-banner">
  <i class="fa-solid fa-shield-halved"></i>
  <div>
    <div class="sec-banner-title">Système sécurisé</div>
    <div class="sec-banner-sub">Dernière vérification : il y a 5 minutes. Aucune intrusion détectée.</div>
  </div>
</div>

<footer>
  <span>© 2026 NexShop. Tous droits réservés.</span>
  <div><a href="#">Conditions d'utilisation</a><a href="#">Confidentialité</a><a href="#">Support</a></div>
</footer>

<script>
// Line chart
const lCtx = document.getElementById('lineChart').getContext('2d');
new Chart(lCtx, {
  type: 'line',
  data: {
    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
    datasets: [{
      data: [3800, 3000, 2000, 2700, 2800, 3200, 3800],
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
const dCtx = document.getElementById('donutChart').getContext('2d');
new Chart(dCtx, {
  type: 'doughnut',
  data: {
    labels: ['Électronique', 'Mode', 'Maison', 'Beauté'],
    datasets: [{
      data: [38, 27, 20, 15],
      backgroundColor: ['#EF4444', '#1E90FF', '#1C7C54', '#E8B84B'],
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

document.querySelectorAll('.sb-item').forEach(i=>i.addEventListener('click',()=>{document.querySelectorAll('.sb-item').forEach(x=>x.classList.remove('active'));i.classList.add('active');}));
document.querySelectorAll('.top-tab').forEach(t=>t.addEventListener('click',()=>{document.querySelectorAll('.top-tab').forEach(x=>x.classList.remove('active'));t.classList.add('active');}));
</script>
</body>
</html>
