<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('partials.theme-init')
<title>Nouveau produit — NexShop Vendeur</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
:root {
  --bg: #0c0c0e;
  --surface: #16161a;
  --surface2: #1e1e24;
  --border: rgba(255,255,255,.09);
  --border2: rgba(255,255,255,.14);
  --orange: #FF6B35;
  --orange-soft: rgba(255,107,53,.12);
  --text: #f4f4f5;
  --muted: #9ca3af;
  --muted2: #71717a;
  --danger: #ef4444;
  --radius: 16px;
  --radius-sm: 12px;
}
*,*::before,*::after{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,system-ui,sans-serif;min-height:100vh;line-height:1.5}
.topbar{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:14px 22px;background:rgba(14,14,16,.92);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:20;backdrop-filter:blur(14px)}
.topbar a{color:var(--muted);text-decoration:none;font-size:13px;font-weight:500;display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:10px;transition:color .15s,background .15s}
.topbar a:hover{color:var(--text);background:rgba(255,255,255,.05)}
.topbar .brand{font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:800;color:var(--text);letter-spacing:-.03em}
.topbar .brand span{color:var(--orange)}
.wrap{max-width:860px;margin:0 auto;padding:28px 22px 56px}
.hero{margin-bottom:26px}
.hero .tag{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:999px;background:var(--orange-soft);border:1px solid rgba(255,107,53,.25);color:var(--orange);font-size:12px;font-weight:600;font-family:'Space Grotesk',sans-serif}
.hero h1{font-family:'Space Grotesk',sans-serif;font-size:1.65rem;font-weight:800;margin:14px 0 6px;letter-spacing:-.02em;line-height:1.2}
.hero p{margin:0;color:var(--muted);font-size:14px;max-width:540px}
.alert-error{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.28);color:#fecaca;border-radius:var(--radius-sm);padding:12px 14px;margin-bottom:20px;font-size:14px}
.alert-error ul{margin:8px 0 0 18px;padding:0}
.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:18px;box-shadow:0 8px 40px rgba(0,0,0,.35)}
.card-hd{display:flex;align-items:flex-start;gap:12px;padding:18px 22px;border-bottom:1px solid var(--border);background:linear-gradient(180deg,var(--surface2) 0%,var(--surface) 100%)}
.card-hd i{width:38px;height:38px;border-radius:11px;background:var(--orange-soft);border:1px solid rgba(255,107,53,.25);color:var(--orange);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.card-hd h2{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:800;margin:0 0 2px}
.card-hd small{display:block;color:var(--muted2);font-size:12px;line-height:1.4}
.card-bd{padding:20px 22px 22px}
.lbl{display:block;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted2);margin-bottom:7px}
.lbl .opt{font-weight:500;text-transform:none;letter-spacing:0;color:var(--muted)}
.inp,.sel,.txa{width:100%;background:rgba(0,0,0,.35);border:1px solid var(--border);border-radius:var(--radius-sm);padding:11px 13px;color:var(--text);font-size:14px;font-family:inherit;outline:none;transition:border-color .18s,box-shadow .18s}
.inp:focus,.sel:focus,.txa:focus{border-color:rgba(255,107,53,.42);box-shadow:0 0 0 3px rgba(255,107,53,.09)}
.txa{resize:vertical;min-height:110px;line-height:1.45}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:680px){.grid2{grid-template-columns:1fr}}
.field{margin-bottom:16px}
.field:last-child{margin-bottom:0}
.hint{font-size:11px;color:var(--muted2);margin-top:6px;line-height:1.35}
.files-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
@media(max-width:620px){.files-grid{grid-template-columns:1fr}}
.files-grid-videos{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
@media(max-width:720px){.files-grid-videos{grid-template-columns:1fr}}
.file-slot{position:relative;border:1px dashed var(--border2);border-radius:var(--radius-sm);padding:12px 12px 10px;background:rgba(0,0,0,.22);transition:border-color .18s,background .18s}
.file-slot:hover{border-color:rgba(255,107,53,.35);background:rgba(255,107,53,.04)}
.file-slot input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.file-slot-lbl{display:flex;align-items:flex-start;gap:10px;pointer-events:none}
.file-slot-lbl i{color:var(--orange);font-size:18px;margin-top:1px;opacity:.85}
.file-slot-t{font-size:12px;font-weight:600;color:var(--text);line-height:1.3}
.file-slot-t span{display:block;font-weight:400;font-size:11px;color:var(--muted);margin-top:2px}
.hero-main{background:linear-gradient(145deg,rgba(255,107,53,.15) 0%,rgba(255,107,53,.02) 55%,transparent 100%);border:1px solid rgba(255,107,53,.2)}
.actions{display:flex;flex-wrap:wrap;gap:11px;padding-top:8px}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;padding:12px 22px;border-radius:var(--radius-sm);font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:700;border:none;cursor:pointer;transition:transform .12s,box-shadow .2s}
.btn-prim{background:linear-gradient(165deg,#FF7A47,var(--orange));color:#fff;box-shadow:0 4px 20px rgba(255,107,53,.35)}
.btn-prim:hover{transform:translateY(-1px);box-shadow:0 6px 26px rgba(255,107,53,.42)}
.btn-ghost{background:transparent;border:1px solid var(--border);color:var(--muted);text-decoration:none}
.btn-ghost:hover{color:var(--text);border-color:var(--border2)}
@media(max-width:540px){
.topbar{padding:10px 12px;padding-top:calc(10px + env(safe-area-inset-top,0px));flex-wrap:wrap}
.topbar span[style]{display:none!important}
.wrap{padding:18px 14px calc(44px + env(safe-area-inset-bottom,0px))}
.hero h1{font-size:1.4rem;line-height:1.2;margin-bottom:8px}
.topbar .brand{font-size:16px;margin:0 auto;order:-1;width:100%;text-align:center}
.topbar>a:first-child{order:1}
.hero .tag{font-size:11px;padding:5px 10px}
.actions .btn{padding:11px 18px;width:100%;justify-content:center}
.actions .btn-ghost{text-align:center}
}
@media(max-width:380px){
.card-bd,.card-hd{padding-left:14px;padding-right:14px}
}
</style>
@include('partials.theme-manager')
</head>
<body class="seller-product-create">
<header class="topbar">
  <a href="{{ route('vendeur.products') }}"><i class="fa-solid fa-arrow-left"></i> Mes produits</a>
  <a href="{{ route('vendeur.home') }}" class="brand">nex<span>shop</span></a>
  <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
</header>

<div class="wrap">
  <div class="hero">
    <span class="tag"><i class="fa-solid fa-layer-group"></i> Catalogue</span>
    <h1>Nouveau produit</h1>
    <p>Renseignez les informations essentielles, les visuels et les vidéos pour mettre votre article en valeur. Après envoi, le produit sera <strong>en attente de validation</strong> par un administrateur ; vous recevrez une notification lorsqu’il sera publié.</p>
  </div>

  @if($errors->any())
    <div class="alert-error"><strong>Corrigez les erreurs ci-dessous.</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
  @endif

  <form action="{{ route('vendeur.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="card">
      <div class="card-hd">
        <i class="fa-solid fa-align-left"></i>
        <div>
          <h2>Informations</h2>
          <small>Nom visible par les acheteurs et description détaillée.</small>
        </div>
      </div>
      <div class="card-bd">
        <div class="field">
          <label class="lbl" for="nom">Nom du produit</label>
          <input class="inp" id="nom" name="nom" value="{{ old('nom') }}" placeholder="Ex.: Sac bandoulière cuir" maxlength="200" required>
        </div>
        <div class="field">
          <label class="lbl" for="description">Description</label>
          <textarea class="txa" id="description" name="description" maxlength="2000" required placeholder="Matériaux, dimensions, entretien…">{{ old('description') }}</textarea>
        </div>
        <div class="grid2">
          <div class="field">
            <label class="lbl" for="categorie_id">Catégorie</label>
            <select class="sel" id="categorie_id" name="categorie_id" required @if(!empty($sellerCategoryId)) disabled @endif>
              <option value="">Choisir…</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected((string) old('categorie_id') === (string) $cat->id)>{{ $cat->nom }}</option>
              @endforeach
            </select>
            @if(!empty($sellerCategoryId))
              <input type="hidden" name="categorie_id" value="{{ $sellerCategoryId }}">
              <p class="hint">Votre boutique est liée à une seule catégorie (inscription).</p>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-hd">
        <i class="fa-solid fa-tags"></i>
        <div>
          <h2>Prix &amp; stock</h2>
          <small>Quantité disponible et prix de vente.</small>
        </div>
      </div>
      <div class="card-bd">
        <div class="grid2">
          <div class="field">
            <label class="lbl" for="prix">Prix (Fdj)</label>
            <input class="inp" id="prix" name="prix" type="number" step="0.01" min="0" value="{{ old('prix') }}" placeholder="0.00" required>
          </div>
          <div class="field">
            <label class="lbl" for="stock">Stock</label>
            <input class="inp" id="stock" name="stock" type="number" min="0" value="{{ old('stock','0') }}" required>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-hd hero-main">
        <i class="fa-solid fa-image"></i>
        <div>
          <h2>Photos <span class="opt">(5 au total)</span></h2>
          <small>1 image principale + 4 images complémentaires · JPG, PNG ou WebP · 10 Mo max chacune.</small>
        </div>
      </div>
      <div class="card-bd">
        <div class="field">
          <label class="lbl">Image principale <span class="opt">— couverture catalogue</span></label>
          <div class="file-slot" style="padding:16px">
            <input type="file" name="image_principale" accept="image/jpeg,image/png,image/webp,image/jpg">
            <div class="file-slot-lbl">
              <i class="fa-regular fa-image"></i>
              <div class="file-slot-t">Cliquez ou glissez la photo principale<span>Recommandé : carré ou 4:5, bonne luminosité</span></div>
            </div>
          </div>
        </div>
        <p class="lbl" style="margin-top:4px">Images supplémentaires <span class="opt">— jusqu’à 4</span></p>
        <div class="files-grid">
          @for($i = 1; $i <= 4; $i++)
          <div class="file-slot">
            <input type="file" name="images_supplementaires[]" accept="image/jpeg,image/png,image/webp,image/jpg">
            <div class="file-slot-lbl">
              <i class="fa-regular fa-images"></i>
              <div class="file-slot-t">Image {{ $i + 1 }}<span>Détail, porté, packaging…</span></div>
            </div>
          </div>
          @endfor
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-hd">
        <i class="fa-solid fa-clapperboard"></i>
        <div>
          <h2>Vidéos <span class="opt">(3 emplacements)</span></h2>
          <small>MP4, WebM ou MOV · 100 Mo max par fichier.</small>
        </div>
      </div>
      <div class="card-bd">
        <div class="files-grid-videos">
          @for($v = 1; $v <= 3; $v++)
          <div class="file-slot">
            <input type="file" name="videos_supplementaires[]" accept="video/mp4,video/webm,video/quicktime">
            <div class="file-slot-lbl">
              <i class="fa-solid fa-film"></i>
              <div class="file-slot-t">Vidéo {{ $v }}<span>Démo ou vue 360° · optionnel</span></div>
            </div>
          </div>
          @endfor
        </div>
      </div>
    </div>

    <div class="actions">
      <button type="submit" class="btn btn-prim"><i class="fa-solid fa-circle-check"></i> Publier le produit</button>
      <a href="{{ route('vendeur.products') }}" class="btn btn-ghost">Annuler</a>
    </div>
  </form>
</div>
</body>
</html>
