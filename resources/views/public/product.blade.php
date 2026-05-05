<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $product->nom }} — NexShop</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
:root{
  --bg:#0D0D0D;--bg2:#141414;--bg3:#1C1C1C;
  --border:rgba(255,255,255,.07);--border2:rgba(255,255,255,.12);
  --orange:#FF6B35;--orange2:#FF8C5A;
  --blue:#1E90FF;--white:#FFFFFF;--text:#F0F0F0;--muted:#777;
  --success:#22C55E;--danger:#EF4444;
}
body{margin:0;background:var(--bg);color:var(--text);font-family:'Inter',sans-serif;font-size:14px}
.pub-nav{display:flex;align-items:center;gap:16px;padding:14px 22px;background:rgba(13,13,13,.96);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:50}
.pub-nav a{color:var(--text);text-decoration:none;font-weight:600;font-family:'Space Grotesk',sans-serif}
.pub-nav a:hover{color:var(--orange)}
.pub-nav .logo{font-size:20px;font-weight:800}
.pub-nav .logo span{color:var(--orange)}
.pub-main{max-width:1100px;margin:0 auto;padding:28px 20px 48px}
.pd-page{display:flex;flex-direction:column;gap:24px}
.pd-main{display:grid;grid-template-columns:minmax(0,1.15fr) minmax(0,.85fr);gap:18px;align-items:start}
.pd-gallery{display:grid;grid-template-columns:70px 1fr;gap:10px}
.pd-thumbs{display:flex;flex-direction:column;gap:8px;max-height:620px;overflow:auto}
.pd-thumb{width:70px;height:70px;border:1px solid var(--border);border-radius:6px;background:var(--bg3);padding:0;overflow:hidden;cursor:pointer}
.pd-thumb.active{border-color:var(--orange)}
.pd-thumb img{width:100%;height:100%;object-fit:cover}
.pd-image{border:1px solid var(--border);border-radius:6px;background:var(--bg2);overflow:hidden;aspect-ratio:1 / 1}
.pd-image img{width:100%;height:100%;object-fit:cover}
.pd-right{position:sticky;top:72px;background:var(--bg2);border:1px solid var(--border);border-radius:8px;padding:14px}
.pd-title{font-size:15px;line-height:1.45;margin:4px 0 8px;font-weight:700;font-family:'Space Grotesk',sans-serif}
.pd-rating{display:flex;gap:8px;align-items:center;font-size:12px;color:var(--muted);margin-bottom:8px}
.pd-stars{color:#FCD34D;font-size:12px}
.pd-price{font-size:28px;font-weight:800;color:var(--orange);font-family:'Space Grotesk',sans-serif;margin:8px 0 12px}
.pd-bullets{font-size:12px;color:var(--muted);display:grid;gap:6px;margin-bottom:10px}
.pd-actions{display:grid;gap:8px}
.pd-actions form{margin:0}
.pd-qty{display:flex;align-items:center;gap:10px;margin:12px 0}
.pd-qty input{width:82px;background:var(--bg3);border:1px solid var(--border2);border-radius:6px;color:var(--text);padding:7px 8px}
.btn-primary{display:inline-flex;align-items:center;gap:8px;background:var(--orange);color:#fff;padding:10px 20px;border-radius:8px;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;text-decoration:none;justify-content:center}
.btn-primary:hover{background:var(--orange2);color:#fff}
.btn-secondary{display:inline-flex;align-items:center;gap:8px;background:var(--bg3);color:var(--text);padding:10px 20px;border-radius:8px;border:1px solid var(--border);font-size:13px;cursor:pointer;text-decoration:none;justify-content:center}
.btn-secondary:hover{border-color:var(--orange);color:var(--orange)}
.pd-section{background:var(--bg2);border:1px solid var(--border);border-radius:8px;padding:16px}
.pd-review-item{padding:10px;border:1px solid var(--border);border-radius:6px;background:var(--bg3);margin-bottom:8px}
.pd-related-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}
.prod-img-wrap{position:relative;height:170px;overflow:hidden;background:var(--bg3);border-radius:6px 6px 0 0}
.prod-img-wrap img{width:100%;height:100%;object-fit:cover}
.prod-card{background:var(--bg2);border:1px solid var(--border);border-radius:8px;overflow:hidden}
.prod-body{padding:12px}
.prod-cat-lbl{font-size:9px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--orange);font-family:'Space Grotesk',sans-serif;margin-bottom:3px}
.prod-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:var(--white);margin-bottom:5px;line-height:1.3;text-decoration:none;display:block}
.prod-foot{display:flex;align-items:center;justify-content:space-between;margin-top:10px}
.prod-price{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:800;color:var(--orange)}
.btn-eye{width:30px;height:30px;border-radius:7px;background:var(--bg3);border:1px solid var(--border);color:var(--muted);font-size:12px;display:flex;align-items:center;justify-content:center;text-decoration:none;color:inherit}
.btn-eye:hover{border-color:var(--orange);color:var(--orange)}
.sec-title{font-family:'Space Grotesk',sans-serif;font-size:17px;font-weight:800;color:var(--white)}
.sec-sub{font-size:12px;color:var(--muted);margin-top:2px}
.form-group{margin-bottom:12px}
.form-group label{display:block;font-size:12px;margin-bottom:4px;color:var(--muted)}
.form-group textarea,.form-group select{width:100%;background:var(--bg3);border:1px solid var(--border2);border-radius:6px;color:var(--text);padding:8px}
.pd-shop-actions{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:12px}
.pub-alert{max-width:1100px;margin:0 auto;padding:12px 20px 0}
.pub-alert-inner{padding:12px 16px;border-radius:8px;font-size:13px;border:1px solid rgba(239,68,68,.4);background:rgba(239,68,68,.12);color:#F87171}
@media(max-width:980px){.pd-main{grid-template-columns:1fr}.pd-right{position:static}.pd-related-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:680px){.pd-gallery{grid-template-columns:1fr}.pd-thumbs{flex-direction:row;max-height:none}.pd-related-grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<nav class="pub-nav">
  <a href="{{ route('home') }}" class="logo">Nex<span>Shop</span></a>
  <a href="{{ route('home') }}"><i class="fa-solid fa-arrow-left"></i> Accueil</a>
  @auth
    @if(auth()->user()->type_compte === 'client')
      <a href="{{ route('buyer.home') }}" style="margin-left:auto">Mon espace</a>
    @elseif(auth()->user()->type_compte === 'vendeur')
      <a href="{{ route('vendeur.home') }}" style="margin-left:auto">Espace vendeur</a>
    @elseif(auth()->user()->type_compte === 'admin')
      <a href="{{ route('admin.home') }}" style="margin-left:auto">Admin</a>
    @endif
  @else
    <a href="{{ route('login') }}" style="margin-left:auto">Connexion</a>
    <a href="{{ route('register') }}">S'inscrire</a>
  @endauth
</nav>

  @if(session('error'))
  <div class="pub-alert"><div class="pub-alert-inner"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div></div>
  @endif

<main class="pub-main pd-page">
  @php
    $gallery = collect([$product->image_principale, ...($product->images_supplementaires ?? [])])
      ->filter()
      ->map(fn ($img) => str_starts_with($img, 'http') ? $img : asset($img))
      ->unique()
      ->values();
    if ($gallery->isEmpty()) {
        $gallery = collect([$product->imageUrl()]);
    }
    $videos = collect($product->videos_supplementaires ?? [])
      ->filter()
      ->map(fn ($video) => str_starts_with($video, 'http') ? $video : asset($video))
      ->values();
    $noteMoy = $product->noteMoyenne();
    $noteInt = (int) round($noteMoy);
  @endphp

  <div class="pd-main">
    <div>
      <div class="pd-gallery">
        <div class="pd-thumbs">
          @foreach($gallery as $img)
            <button type="button" class="pd-thumb {{ $loop->first ? 'active' : '' }}" data-gallery-thumb data-src="{{ $img }}">
              <img src="{{ $img }}" alt="{{ $product->nom }} miniature {{ $loop->iteration }}">
            </button>
          @endforeach
        </div>
        <div class="pd-image">
          <img src="{{ $gallery->first() }}" alt="{{ $product->nom }}" data-gallery-main>
        </div>
      </div>
      @if($videos->isNotEmpty())
        <div class="pd-section" style="margin-top:10px">
          <h3 style="font-size:14px;margin-bottom:10px">Vidéos du produit</h3>
          <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px">
            @foreach($videos as $video)
              <video controls preload="metadata" style="width:100%;border:1px solid var(--border);border-radius:6px;background:#000">
                <source src="{{ $video }}">
              </video>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    <aside class="pd-right">
      <div class="prod-cat-lbl">{{ $product->categorie?->nom ?? 'Catégorie' }}</div>
      <h1 class="pd-title">{{ $product->nom }}</h1>
      <div class="pd-rating">
        <span class="pd-stars">{{ str_repeat('★', $noteInt) }}{{ str_repeat('☆', 5 - $noteInt) }}</span>
        <span>{{ number_format($noteMoy, 1) }} • {{ $product->avis->count() }} avis</span>
      </div>
      <div class="pd-price">{{ money_fdj($product->prix) }}</div>
      <div class="pd-bullets">
        <div>Vendeur : <strong>{{ $product->vendeur?->nom ?? 'NexShop' }}</strong></div>
        <div>Disponibilité : <strong>{{ $product->stock > 0 ? 'En stock' : 'Rupture' }}</strong></div>
        <div>Stock restant : <strong>{{ $product->stock }}</strong></div>
      </div>

      <div class="pd-actions">
        @if($isClient)
          <form action="{{ route('buyer.favorites.toggle', $product) }}" method="post">
            @csrf
            <button type="submit" class="btn-secondary" style="width:100%">
              <i class="fa-{{ $inFavorites ? 'solid' : 'regular' }} fa-heart" @if($inFavorites) style="color:#ef4444" @endif></i>
              {{ $inFavorites ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
            </button>
          </form>
          @if($product->stock > 0)
            <form action="{{ route('buyer.cart.add') }}" method="post">
              @csrf
              <input type="hidden" name="produit_id" value="{{ $product->id }}">
              <div class="pd-qty">
                <label for="qty-{{ $product->id }}">Qté</label>
                <input id="qty-{{ $product->id }}" type="number" name="quantite" min="1" max="{{ max(1, $product->stock) }}" value="1">
              </div>
              <button type="submit" class="btn-primary" style="width:100%"><i class="fa-solid fa-cart-plus"></i> Acheter</button>
            </form>
          @else
            <span style="color:var(--danger);font-size:13px">Rupture de stock</span>
          @endif
        @else
          <p style="font-size:13px;color:var(--muted);margin:0 0 10px">Connectez-vous avec un compte acheteur pour ajouter au panier et aux favoris.</p>
          <a href="{{ route('login') }}" class="btn-primary" style="width:100%">Connexion</a>
          <a href="{{ route('register') }}" class="btn-secondary" style="width:100%">Créer un compte</a>
        @endif
      </div>
    </aside>
  </div>

  <section class="pd-section">
    <h3 class="sec-title" style="margin-bottom:10px">Détails</h3>
    <p style="font-size:13px;color:var(--muted);line-height:1.65;margin:0">{{ $product->description ?: 'Aucune description fournie pour ce produit.' }}</p>
  </section>

  @if($isClient)
    <section class="pd-section">
      <h3 class="sec-title" style="margin-bottom:12px">Laisser un avis</h3>
      <form action="{{ route('buyer.products.review', $product) }}" method="post">
        @csrf
        <div class="form-group">
          <label>Note (1 à 5)</label>
          <select name="note" required class="rating-select">
            @for($i = 1; $i <= 5; $i++)
              <option value="{{ $i }}" {{ ($userReview->note ?? 0) == $i ? 'selected' : '' }}>{{ str_repeat('★', $i) }}{{ str_repeat('☆', 5 - $i) }}</option>
            @endfor
          </select>
        </div>
        <div class="form-group">
          <label>Commentaire (optionnel)</label>
          <textarea name="commentaire" rows="3" placeholder="Votre avis…">{{ old('commentaire', $userReview->commentaire ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn-primary">Envoyer mon avis</button>
      </form>
    </section>
  @endif

  <section class="pd-section">
    <h3 class="sec-title" style="margin-bottom:12px">Commentaires ({{ $product->avis->count() }})</h3>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px">
      <strong style="font-size:28px;font-family:'Space Grotesk',sans-serif">{{ number_format($noteMoy, 2) }}</strong>
      <span class="pd-stars" style="font-size:15px">{{ str_repeat('★', $noteInt) }}{{ str_repeat('☆', 5 - $noteInt) }}</span>
    </div>
    @forelse($product->avis as $avis)
      <div class="pd-review-item">
        <div class="pd-stars">{{ str_repeat('★', (int) $avis->note) }}{{ str_repeat('☆', 5 - (int) $avis->note) }}</div>
        @if($avis->commentaire)<p style="margin:6px 0 0;font-size:13px">{{ $avis->commentaire }}</p>@endif
      </div>
    @empty
      <p style="color:var(--muted)">Aucun avis pour le moment.</p>
    @endforelse
  </section>

  <section class="pd-section">
    <h3 class="sec-title" style="margin-bottom:14px">À propos de la boutique</h3>
    <div style="display:flex;gap:12px;align-items:flex-start;margin-bottom:12px">
      <img style="width:58px;height:58px;border-radius:8px;border:1px solid var(--border2);object-fit:cover" src="{{ $product->vendeur?->boutique?->logoUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($product->vendeur?->boutique?->nom ?? $product->vendeur?->nom ?? 'Boutique') . '&background=111827&color=fff' }}" alt="Logo boutique">
      <div style="flex:1">
        <h4 style="font-size:20px;line-height:1.1;margin:0 0 6px;font-family:'Space Grotesk',sans-serif;display:flex;align-items:center;gap:8px;flex-wrap:wrap">{{ $product->vendeur?->boutique?->nom ?? $product->vendeur?->nom ?? 'Boutique NexShop' }}
          @if($product->vendeur?->sellerShowsVerifiedBadge())
            <span style="font-size:10px;font-weight:800;background:rgba(255,107,53,.15);color:#FF6B35;padding:3px 8px;border-radius:50px">VÉRIFIÉ</span>
          @endif
        </h4>
        <div style="color:var(--muted);font-size:13px;line-height:1.5">
          {{ $product->vendeur?->boutique?->description ?: 'Boutique spécialisée avec une sélection produits tendance.' }}
        </div>
      </div>
    </div>
    <div style="display:flex;gap:18px;flex-wrap:wrap;margin:10px 0 12px">
      <div><strong>{{ number_format($sellerRating, 1) }}</strong><br><span style="font-size:12px;color:var(--muted)">Évaluation</span></div>
      <div><strong>{{ number_format($sellerProductCount) }}</strong><br><span style="font-size:12px;color:var(--muted)">Articles</span></div>
      <div><strong>{{ number_format($sellerFavoritesCount) }}</strong><br><span style="font-size:12px;color:var(--muted)">Favoris</span></div>
    </div>
    <div class="pd-shop-actions">
      @if($isClient)
        <a href="{{ route('buyer.stores.show', $product->vendeur_id) }}" class="btn-secondary">Tous les articles</a>
        <form action="{{ route('buyer.sellers.follow', $product->vendeur_id) }}" method="post">
          @csrf
          <button type="submit" class="btn-primary" style="width:100%">
            <i class="fa-solid fa-{{ $isFollowingSeller ? 'check' : 'plus' }}"></i>
            {{ $isFollowingSeller ? 'Suivi' : 'Suivre' }}
          </button>
        </form>
        @if($product->vendeur && $product->vendeur->sellerAcceptsNewOrders())
        <a href="{{ route('buyer.messages.start', $product->vendeur) }}" class="btn-secondary" style="grid-column:1/-1;justify-content:center"><i class="fa-regular fa-comment-dots"></i> Contacter le vendeur</a>
        @elseif($product->vendeur && ! $product->vendeur->sellerAcceptsNewOrders())
        <p style="grid-column:1/-1;font-size:12px;color:var(--muted);text-align:center;margin:0">Messagerie indisponible pour cette boutique (limite ou abonnement).</p>
        @endif
      @else
        <a href="{{ route('login') }}" class="btn-secondary" style="grid-column:1/-1">Connexion pour voir la boutique</a>
      @endif
    </div>
  </section>

  @if($relatedProducts->isNotEmpty())
    <section class="pd-section">
      <h3 class="sec-title">Articles similaires</h3>
      <p class="sec-sub">Produits de la même catégorie ou du même vendeur</p>
      <div class="pd-related-grid" style="margin-top:14px">
        @foreach($relatedProducts as $p)
          <article class="prod-card">
            <a href="{{ route('public.products.show', $p) }}" class="prod-img-wrap">
              <img src="{{ $p->imageUrl() }}" alt="{{ $p->nom }}">
            </a>
            <div class="prod-body">
              <div class="prod-cat-lbl">{{ $p->categorie?->nom ?? 'Produit' }}</div>
              <a href="{{ route('public.products.show', $p) }}" class="prod-name">{{ $p->nom }}</a>
              <div class="prod-foot">
                <span class="prod-price">{{ money_fdj($p->prix) }}</span>
                <a href="{{ route('public.products.show', $p) }}" class="btn-eye"><i class="fa-regular fa-eye"></i></a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @endif
</main>

<script>
document.querySelectorAll('[data-gallery-thumb]').forEach((thumb) => {
  thumb.addEventListener('click', () => {
    const main = document.querySelector('[data-gallery-main]');
    if (!main) return;
    main.src = thumb.dataset.src;
    document.querySelectorAll('[data-gallery-thumb]').forEach((btn) => btn.classList.remove('active'));
    thumb.classList.add('active');
  });
});
</script>
</body>
</html>
