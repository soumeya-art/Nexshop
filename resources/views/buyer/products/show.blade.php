@extends('buyer.layout')

@section('title', $product->nom)

@push('styles')
<style>
.pd-page{display:flex;flex-direction:column;gap:24px}
.pd-main{display:grid;grid-template-columns:minmax(0,1.15fr) minmax(0,.85fr);gap:18px;align-items:start}
.pd-gallery{display:grid;grid-template-columns:70px 1fr;gap:10px}
.pd-thumbs{display:flex;flex-direction:column;gap:8px;max-height:620px;overflow:auto}
.pd-thumb{width:70px;height:70px;border:1px solid var(--border);border-radius:6px;background:var(--bg3);padding:0;overflow:hidden;cursor:pointer}
.pd-thumb.active{border-color:var(--orange)}
.pd-thumb img{width:100%;height:100%;object-fit:cover}
.pd-image{border:1px solid var(--border);border-radius:6px;background:var(--bg2);overflow:hidden;aspect-ratio:1 / 1}
.pd-image img{width:100%;height:100%;object-fit:cover}
.pd-right{position:sticky;top:86px;background:var(--bg2);border:1px solid var(--border);border-radius:6px;padding:14px}
.pd-title{font-size:15px;line-height:1.45;margin:4px 0 8px;font-weight:700}
.pd-rating{display:flex;gap:8px;align-items:center;font-size:12px;color:var(--muted);margin-bottom:8px}
.pd-stars{color:#FCD34D;font-size:12px}
.pd-price{font-size:28px;font-weight:800;color:var(--orange);font-family:'Space Grotesk',sans-serif;margin:8px 0 12px}
.pd-bullets{font-size:12px;color:var(--muted);display:grid;gap:6px;margin-bottom:10px}
.pd-swatches{display:flex;gap:7px;flex-wrap:wrap;margin:10px 0}
.pd-swatch{width:18px;height:18px;border-radius:50%;border:1px solid #ffffff4f}
.pd-qty{display:flex;align-items:center;gap:10px;margin:12px 0}
.pd-qty input{width:82px;background:var(--bg3);border:1px solid var(--border2);border-radius:6px;color:var(--text);padding:7px 8px}
.pd-actions{display:grid;gap:8px}
.pd-actions form{margin:0}
.pd-actions .btn-primary,.pd-actions .btn-secondary{width:100%;justify-content:center;border-radius:4px}
.pd-trust{margin-top:10px;border:1px solid var(--border);border-radius:6px;padding:10px;background:var(--bg3);font-size:12px;color:var(--muted);display:grid;gap:6px}
.pd-section{background:var(--bg2);border:1px solid var(--border);border-radius:8px;padding:16px}
.pd-tabs{display:flex;gap:14px;font-size:13px;border-bottom:1px solid var(--border);padding-bottom:8px;margin-bottom:14px}
.pd-tabs strong{color:var(--text)}
.pd-desc{font-size:13px;color:var(--muted);line-height:1.65}
.pd-review-item{padding:10px;border:1px solid var(--border);border-radius:6px;background:var(--bg3);margin-bottom:8px}
.pd-related-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:10px}
.pd-related-grid .prod-img-wrap{height:170px}
.pd-shop-actions{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:12px}
.pd-feedback-row{display:grid;grid-template-columns:minmax(0,1fr) 320px;gap:14px;align-items:start}
.pd-shop-compact .pd-shop-title{font-size:15px;margin-bottom:10px}
.pd-shop-compact .pd-shop-head{display:flex;gap:10px;align-items:flex-start;margin-bottom:10px}
.pd-shop-compact .pd-shop-head img{width:44px;height:44px;border-radius:8px;border:1px solid var(--border2);object-fit:cover}
.pd-shop-compact .pd-shop-name{font-size:15px;line-height:1.2;margin:0 0 4px;font-family:'Space Grotesk',sans-serif;display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.pd-shop-compact .pd-shop-desc{color:var(--muted);font-size:12px;line-height:1.45}
.pd-shop-compact .pd-shop-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px;margin:10px 0}
.pd-shop-compact .pd-shop-stats strong{display:block;font-size:14px}
.pd-shop-compact .pd-shop-stats span{font-size:11px;color:var(--muted)}
.pd-shop-compact .pd-shop-badges{display:flex;gap:8px;flex-wrap:wrap;color:var(--muted);font-size:11px;margin-bottom:8px}
.pd-shop-compact .pd-shop-actions{display:grid;grid-template-columns:1fr;gap:8px;margin-top:8px}
.pd-shop-compact .pd-shop-actions .btn-primary,.pd-shop-compact .pd-shop-actions .btn-secondary{width:100%;justify-content:center}
.pd-review-placeholder{min-height:250px}
@media(max-width:1200px){.pd-related-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
@media(max-width:980px){.pd-main{grid-template-columns:1fr}.pd-right{position:static}.pd-related-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.pd-feedback-row{grid-template-columns:1fr}}
@media(max-width:680px){.pd-gallery{grid-template-columns:1fr}.pd-thumbs{flex-direction:row;max-height:none}.pd-related-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<main class="pd-page">
  @php
    $gallery = collect([$product->image_principale, ...($product->images_supplementaires ?? [])])
      ->filter()
      ->map(function ($img) {
          return str_starts_with($img, 'http') ? $img : asset($img);
      })
      ->unique()
      ->values();

    if ($gallery->isEmpty()) {
      $gallery = collect([$product->imageUrl()]);
    }

    $videos = collect($product->videos_supplementaires ?? [])
      ->filter()
      ->map(function ($video) {
          return str_starts_with($video, 'http') ? $video : asset($video);
      })
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
          <h3 style="font-size:14px;margin-bottom:10px">Videos du produit</h3>
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
      <div class="prod-cat-lbl">{{ $product->categorie?->nom ?? 'Categorie' }}</div>
      <h1 class="pd-title">{{ $product->nom }}</h1>
      <div class="pd-rating">
        <span class="pd-stars">{{ str_repeat('★', $noteInt) }}{{ str_repeat('☆', 5 - $noteInt) }}</span>
        <span>{{ number_format($noteMoy, 1) }} • {{ $product->avis->count() }} avis</span>
      </div>
      <div class="pd-price">{{ money_fdj($product->prix) }}</div>

      <div class="pd-bullets">
        <div>Vendeur: <strong>{{ $product->vendeur?->nom ?? 'NexShop' }}</strong></div>
        <div>Disponibilite: <strong>{{ $product->stock > 0 ? 'En stock' : 'Rupture' }}</strong></div>
        <div>Stock restant: <strong>{{ $product->stock }}</strong></div>
      </div>

      <div class="pd-swatches" title="Teintes">
        <span class="pd-swatch" style="background:#8c4a3f"></span>
        <span class="pd-swatch" style="background:#b96553"></span>
        <span class="pd-swatch" style="background:#d28673"></span>
        <span class="pd-swatch" style="background:#7f3f35"></span>
        <span class="pd-swatch" style="background:#a84e45"></span>
      </div>

      <div class="pd-actions">
        <form action="{{ route('buyer.favorites.toggle', $product) }}" method="post" style="display:inline">
          @csrf
          <button type="submit" class="btn-secondary">
            <i class="fa-{{ $inFavorites ? 'solid' : 'regular' }} fa-heart" @if($inFavorites) style="color:#ef4444" @endif></i>
            {{ $inFavorites ? 'Retirer des favoris' : 'Ajouter aux favoris' }}
          </button>
        </form>
        @if($product->stock > 0)
          <form action="{{ route('buyer.cart.add') }}" method="post" style="display:inline">
            @csrf
            <input type="hidden" name="produit_id" value="{{ $product->id }}">
            <div class="pd-qty">
              <label for="qty-{{ $product->id }}" class="meta-label" style="min-width:42px">Qte</label>
              <input id="qty-{{ $product->id }}" type="number" name="quantite" min="1" max="{{ max(1, $product->stock) }}" value="1">
            </div>
            <button type="submit" class="btn-primary"><i class="fa-solid fa-cart-plus"></i> Acheter</button>
          </form>
        @else
          <span style="color:var(--danger);font-size:13px">Rupture de stock</span>
        @endif
      </div>

      <div class="pd-trust">
        <div><i class="fa-solid fa-truck-fast"></i> Livraison rapide</div>
        <div><i class="fa-solid fa-rotate-left"></i> Retour sous 5 jours</div>
        <div><i class="fa-solid fa-shield-halved"></i> Paiement securise</div>
      </div>
    </aside>
  </div>

  <section class="pd-section">
    <div class="pd-tabs">
      <strong>Details</strong>
      <span style="color:var(--muted)">Avis</span>
      <span style="color:var(--muted)">A propos du magasin</span>
    </div>
    <p class="pd-desc">{{ $product->description ?: 'Aucune description fournie pour ce produit.' }}</p>
  </section>

  @php
    $hasReview = !empty($userReview);
  @endphp
  <div class="pd-feedback-row">
    <section class="pd-section">
      <h3 style="font-size:17px;margin-bottom:12px">Laisser un avis / Noter le produit</h3>
      @if($hasReview)
        <div class="pd-review-placeholder"></div>
      @else
        <form action="{{ route('buyer.products.review', $product) }}" method="post">
          @csrf
          <div class="form-group">
            <label>Note (1 à 5)</label>
            <select name="note" required class="rating-select">
              @for($i=1;$i<=5;$i++)
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
      @endif
    </section>

    <section class="pd-section pd-shop-compact">
      <h3 class="pd-shop-title">A propos de la boutique</h3>
      <div class="pd-shop-head">
        <img src="{{ $product->vendeur?->boutique?->logoUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($product->vendeur?->boutique?->nom ?? $product->vendeur?->nom ?? 'Boutique') . '&background=111827&color=fff' }}" alt="Logo boutique">
        <div style="flex:1;min-width:0">
          <h4 class="pd-shop-name">{{ $product->vendeur?->boutique?->nom ?? $product->vendeur?->nom ?? 'Boutique NexShop' }}
            @if($product->vendeur?->sellerShowsVerifiedBadge())
              <span style="font-size:9px;font-weight:800;background:rgba(255,107,53,.15);color:#FF6B35;padding:2px 7px;border-radius:50px">VERIFIE</span>
            @endif
          </h4>
          <div class="pd-shop-desc">{{ $product->vendeur?->boutique?->description ?: 'Boutique specialisee avec une selection produits tendance.' }}</div>
        </div>
      </div>

      <div class="pd-shop-stats">
        <div><strong>{{ number_format($sellerRating, 1) }}</strong><span>Evaluation</span></div>
        <div><strong>{{ number_format($sellerProductCount) }}</strong><span>Articles</span></div>
        <div><strong>{{ number_format($sellerFavoritesCount) }}</strong><span>Favoris</span></div>
      </div>

      <div class="pd-shop-badges">
        <span><i class="fa-solid fa-fire" style="color:#FF6B35"></i> Vente active</span>
        <span><i class="fa-solid fa-user-plus" style="color:#FF6B35"></i> Populaire</span>
      </div>

      <div class="pd-shop-actions">
        <a href="{{ route('buyer.stores.show', $product->vendeur_id) }}" class="btn-secondary">Tous les articles</a>
        <form action="{{ route('buyer.sellers.follow', $product->vendeur_id) }}" method="post">
          @csrf
          <button type="submit" class="btn-primary">
            <i class="fa-solid fa-{{ $isFollowingSeller ? 'check' : 'plus' }}"></i>
            {{ $isFollowingSeller ? 'Suivi' : 'Suivre' }}
          </button>
        </form>
        @if($product->vendeur && $product->vendeur->sellerAcceptsNewOrders())
          <a href="{{ route('buyer.messages.start', $product->vendeur) }}" class="btn-secondary"><i class="fa-regular fa-comment-dots"></i> Contacter le vendeur</a>
        @elseif($product->vendeur && ! $product->vendeur->sellerAcceptsNewOrders())
          <p style="font-size:12px;color:var(--muted);text-align:center;margin:0">Messagerie indisponible (limite ou abonnement).</p>
        @endif
      </div>
    </section>
  </div>

  <section class="pd-section">
    <h3 style="font-size:17px;margin-bottom:14px">Commentaires des clients ({{ $product->avis->count() }})</h3>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px">
      <strong style="font-size:32px;font-family:'Space Grotesk',sans-serif">{{ number_format($noteMoy, 2) }}</strong>
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

  @if($relatedProducts->isNotEmpty())
    <section class="pd-section">
      <div class="sec-row" style="margin-bottom:14px">
        <div>
          <h3 class="sec-title">Articles similaires</h3>
          <p class="sec-sub">Produits de la meme categorie ou du meme vendeur</p>
        </div>
      </div>
      <div class="pd-related-grid">
        @foreach($relatedProducts as $p)
          <article class="prod-card">
            <a href="{{ route('buyer.products.show', $p) }}" class="prod-img-wrap">
              <img src="{{ $p->imageUrl() }}" alt="{{ $p->nom }}">
            </a>
            <div class="prod-body">
              <div class="prod-cat-lbl">{{ $p->categorie?->nom ?? 'Produit' }}</div>
              <a href="{{ route('buyer.products.show', $p) }}" class="prod-name">{{ $p->nom }}</a>
              <div class="prod-foot">
                <div>
                  <span class="prod-price">{{ money_fdj($p->prix) }}</span>
                </div>
                <a href="{{ route('buyer.products.show', $p) }}" class="btn-eye"><i class="fa-regular fa-eye"></i></a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @endif
</main>
@endsection

@push('scripts')
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
@endpush
