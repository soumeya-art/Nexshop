<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('partials.theme-init')
<title>Ma boutique — NexShop Vendeur</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
:root{
  --bout-bg:#0b0b0c;
  --bout-bg2:#121214;
  --bout-bg3:#1a1a1e;
  --bout-border:rgba(255,255,255,.09);
  --bout-orange:#FF6B35;
  --bout-text:#f4f4f5;
  --bout-muted:#94a3b8;
  --bout-muted2:#64748b;
  --bout-success:#22C55E;
  --bout-danger:#EF4444;
  --bout-radius:16px;
  --bout-radius-sm:12px;
}
*{box-sizing:border-box}
body{margin:0;background:var(--bout-bg);color:var(--bout-text);font-family:'Inter',system-ui,sans-serif;min-height:100vh;line-height:1.45}

.top{
  display:flex;align-items:center;flex-wrap:wrap;gap:14px 20px;
  padding:14px 22px 16px;
  background:linear-gradient(180deg,rgba(18,18,20,.98) 0%,rgba(12,12,14,.96) 100%);
  border-bottom:1px solid var(--bout-border);
  position:sticky;top:0;z-index:40;
  box-shadow:0 8px 32px rgba(0,0,0,.35), inset 0 -1px 0 rgba(255,107,53,.12);
}
.top-brand{display:flex;align-items:center;gap:14px;flex-wrap:wrap}
.brand-link{display:inline-flex;align-items:center;gap:12px;text-decoration:none;color:inherit;transition:opacity .2s}
.brand-link:hover{opacity:.92}
.top-brand-mark{
  width:44px;height:44px;border-radius:13px;
  background:linear-gradient(145deg,rgba(255,107,53,.45),rgba(255,107,53,.12));
  border:1px solid rgba(255,107,53,.4);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:18px;flex-shrink:0;
  box-shadow:0 4px 16px rgba(255,107,53,.2);
}
.top-brand-text{display:flex;flex-direction:column;gap:2px;line-height:1.05}
.top-brand-word{font-family:'Space Grotesk',sans-serif;font-size:1.5rem;font-weight:800;letter-spacing:-0.03em;display:flex;align-items:baseline;gap:0}
.top-brand-nex{color:#fff}
.top-brand-shop{color:var(--bout-orange)}
.top-brand-tag{
  font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;
  letter-spacing:.08em;text-transform:uppercase;
  padding:5px 11px;border-radius:999px;
  background:rgba(255,107,53,.12);color:var(--bout-orange);
  border:1px solid rgba(255,107,53,.28);
}
.top-nav{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-left:auto}
.top-nav a.link{
  display:inline-flex;align-items:center;gap:8px;
  color:var(--bout-muted);text-decoration:none;font-size:13px;font-weight:600;
  padding:9px 14px;border-radius:11px;border:1px solid var(--bout-border);
  background:rgba(255,255,255,.04);transition:border-color .2s,color .2s,background .2s;
  white-space:nowrap;font-family:'Space Grotesk',sans-serif;
}
.top-nav a.link:hover{color:var(--bout-orange);border-color:rgba(255,107,53,.35);background:rgba(255,107,53,.08)}
.top-nav a.link i{font-size:13px;opacity:.85}
.top-nav .theme-toggle{margin-right:4px}

.page{
  max-width:760px;margin:0 auto;
  padding:28px 22px 40px;
  background:
    radial-gradient(ellipse 90% 50% at 50% -20%,rgba(255,107,53,.06),transparent 55%),
    linear-gradient(180deg,var(--bout-bg) 0%,#080809 100%);
  min-height:calc(100vh - 88px);
}
.page-eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;
  letter-spacing:.12em;text-transform:uppercase;color:var(--bout-orange);
  margin-bottom:10px;
}
.page-eyebrow i{font-size:12px;opacity:.9}
.page-title{font-family:'Space Grotesk',sans-serif;font-size:clamp(1.45rem,4vw,1.85rem);font-weight:800;margin:0 0 8px;letter-spacing:-.02em;color:#fff}
.page-sub{font-size:14px;color:var(--bout-muted2);margin:0 0 26px;max-width:52ch;line-height:1.55}

.card{
  background:linear-gradient(165deg,var(--bout-bg2) 0%,#101012 100%);
  border:1px solid var(--bout-border);
  border-radius:var(--bout-radius);
  padding:26px 24px 28px;
  box-shadow:0 4px 40px rgba(0,0,0,.4),0 0 0 1px rgba(255,255,255,.03) inset;
}
.form-group{display:flex;flex-direction:column;gap:8px;margin-bottom:20px}
.form-group label{
  font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--bout-muted2);
  text-transform:uppercase;letter-spacing:.08em;
}
.form-group input,.form-group textarea{
  background:var(--bout-bg3);border:1px solid var(--bout-border);
  border-radius:var(--bout-radius-sm);padding:12px 14px;color:var(--bout-text);
  font-size:15px;font-family:inherit;transition:border-color .2s,box-shadow .2s;
}
.form-group input:focus,.form-group textarea:focus{
  outline:none;border-color:rgba(255,107,53,.45);
  box-shadow:0 0 0 3px rgba(255,107,53,.1);
}
.form-group textarea{min-height:110px;resize:vertical;line-height:1.5}
.form-group input[type="file"]{
  padding:10px 12px;font-size:13px;cursor:pointer;
  background:rgba(0,0,0,.25);
}
.hint{font-size:12px;color:var(--bout-muted);line-height:1.45}
.preview-row{display:flex;gap:14px;flex-wrap:wrap;align-items:flex-start;margin-top:10px}
.preview-img{max-height:120px;border-radius:var(--bout-radius-sm);border:1px solid var(--bout-border);object-fit:cover;box-shadow:0 4px 16px rgba(0,0,0,.35)}
.btn-submit{
  margin-top:12px;width:100%;display:inline-flex;align-items:center;justify-content:center;gap:10px;
  background:linear-gradient(160deg,#ff7a47 0%,var(--bout-orange) 45%,#e85a28 100%);
  color:#fff;border:none;padding:14px 22px;border-radius:var(--bout-radius-sm);
  font-weight:800;font-family:'Space Grotesk',sans-serif;font-size:15px;cursor:pointer;
  box-shadow:0 6px 22px rgba(255,107,53,.35);transition:transform .15s,box-shadow .2s;
}
.btn-submit:hover{transform:translateY(-1px);box-shadow:0 8px 28px rgba(255,107,53,.42)}
.btn-submit:active{transform:translateY(0)}
.alert{padding:14px 16px;border-radius:var(--bout-radius-sm);margin-bottom:20px;font-size:14px;display:flex;align-items:flex-start;gap:10px}
.alert-success{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.35);color:var(--bout-success)}
.alert-error{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.35);color:var(--bout-danger)}
.readonly{
  padding:12px 14px;background:rgba(0,0,0,.28);border-radius:var(--bout-radius-sm);
  font-size:14px;color:var(--bout-muted);border:1px solid var(--bout-border);
}

@media(max-width:900px){
  .top{padding:12px 16px 14px;padding-top:calc(12px + env(safe-area-inset-top,0px))}
  .top-nav{width:100%;margin-left:0;overflow-x:auto;-webkit-overflow-scrolling:touch;flex-wrap:nowrap;padding-bottom:4px;gap:10px}
  .top-nav::-webkit-scrollbar{height:4px}
  .top-nav::-webkit-scrollbar-thumb{background:rgba(255,107,53,.35);border-radius:4px}
}
@media(max-width:640px){
  .page{padding:22px 16px 32px;padding-bottom:calc(28px + env(safe-area-inset-bottom,0px))}
  .card{padding:18px 16px 22px}
  .preview-img,.preview-img[style]{max-width:100%!important;height:auto!important}
}
@media(max-width:400px){
  .form-group input,.form-group textarea{font-size:16px}
  .top-brand-word{font-size:1.25rem}
}
</style>
@include('partials.theme-manager')
</head>
<body class="seller-boutique-page">
<header class="top">
  <div class="top-brand">
    <a href="{{ route('vendeur.home') }}" class="brand-link" title="NexShop — Tableau de bord vendeur">
      <span class="top-brand-mark" aria-hidden="true"><i class="fa-solid fa-store"></i></span>
      <span class="top-brand-text">
        <span class="top-brand-word"><span class="top-brand-nex">Nex</span><span class="top-brand-shop">Shop</span></span>
      </span>
    </a>
    <span class="top-brand-tag">Espace vendeur</span>
  </div>
  <nav class="top-nav" aria-label="Navigation vendeur">
    <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
    <a href="{{ route('vendeur.home') }}" class="link"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
    <a href="{{ route('vendeur.products') }}" class="link"><i class="fa-solid fa-box-open"></i> Produits</a>
    <a href="{{ route('vendeur.messages.index') }}" class="link"><i class="fa-solid fa-comments"></i> Messages</a>
  </nav>
</header>

<div class="page">
  <p class="page-eyebrow"><i class="fa-solid fa-bag-shopping"></i> NexShop · Votre vitrine</p>
  <h1 class="page-title">Ma boutique</h1>
  <p class="page-sub">Nom, description, logo et bannière : tout ce que les acheteurs voient sur votre page boutique NexShop.</p>

  @if(session('success'))
    <div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
  @endif

  <div class="card">
    <form action="{{ route('vendeur.boutique.update') }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="nom">Nom de la boutique</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom', $boutique->nom) }}" required maxlength="100">
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" required minlength="10" maxlength="2000">{{ old('description', $boutique->description) }}</textarea>
        <span class="hint">Présentez votre univers, vos engagements, vos délais…</span>
      </div>

      <div class="form-group">
        <label>Catégorie principale</label>
        <div class="readonly">{{ $categorieLabel ?? $boutique->categorie }}</div>
        <span class="hint">Liée aux produits que vous pouvez vendre ; modifiable uniquement via l’administration si besoin.</span>
      </div>

      <div class="form-group">
        <label for="ville">Ville</label>
        <input type="text" id="ville" name="ville" value="{{ old('ville', $boutique->ville) }}" maxlength="100">
      </div>

      <div class="form-group">
        <label for="telephone_boutique">Téléphone boutique</label>
        <input type="text" id="telephone_boutique" name="telephone_boutique" value="{{ old('telephone_boutique', $boutique->telephone_boutique) }}" maxlength="25">
      </div>

      <div class="form-group">
        <label for="instagram_url">Instagram</label>
        <input type="text" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $boutique->instagram_url) }}" maxlength="255" placeholder="@votreboutique ou URL complète">
      </div>

      <div class="form-group">
        <label for="snapchat_url">Snapchat</label>
        <input type="text" id="snapchat_url" name="snapchat_url" value="{{ old('snapchat_url', $boutique->snapchat_url) }}" maxlength="255" placeholder="votrecompte ou URL complète">
      </div>

      <div class="form-group">
        <label for="tiktok_url">TikTok</label>
        <input type="text" id="tiktok_url" name="tiktok_url" value="{{ old('tiktok_url', $boutique->tiktok_url) }}" maxlength="255" placeholder="@votreboutique ou URL complète">
      </div>

      <div class="form-group">
        <label for="youtube_url">YouTube</label>
        <input type="text" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $boutique->youtube_url) }}" maxlength="255" placeholder="@votrechaine ou URL complète">
        <span class="hint">Les comptes saisis ici seront affichés en public sur votre page boutique.</span>
      </div>

      <div class="form-group">
        <label for="logo">Logo (carré recommandé, max 2 Mo)</label>
        <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp,image/gif">
        @if($boutique->logoUrl())
          <div class="preview-row">
            <span class="hint">Actuel :</span>
            <img class="preview-img" src="{{ $boutique->logoUrl() }}" alt="Logo">
          </div>
        @endif
      </div>

      <div class="form-group">
        <label for="banniere">Image de couverture / bannière (max 4 Mo)</label>
        <input type="file" id="banniere" name="banniere" accept="image/jpeg,image/png,image/webp,image/gif">
        @if($boutique->banniereUrl())
          <div class="preview-row">
            <span class="hint">Actuelle :</span>
            <img class="preview-img" style="max-height:140px;width:min(100%,380px)" src="{{ $boutique->banniereUrl() }}" alt="Bannière">
          </div>
        @endif
      </div>

      <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications</button>
    </form>
  </div>
</div>
</body>
</html>
