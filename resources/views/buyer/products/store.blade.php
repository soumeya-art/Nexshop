@extends('buyer.layout')

@section('title', ($seller->boutique?->nom ?? $seller->nom) . ' - Boutique')

@push('styles')
<style>
.store-page{display:flex;flex-direction:column;gap:18px}
.store-top{border:1px solid var(--border);background:linear-gradient(120deg,#f7d3ea,#f4d9f8 40%,#fce4ee);border-radius:var(--radius);padding:18px}
.store-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
.store-brand{display:flex;align-items:center;gap:12px}
.store-logo{width:58px;height:58px;border-radius:8px;border:1px solid #d9bfd1;object-fit:cover}
.store-title{font-family:'Space Grotesk',sans-serif;font-size:26px;font-weight:800;color:#2a1d27}
.store-metrics{display:flex;gap:18px;flex-wrap:wrap}
.store-metric{font-size:12px;color:#422f3e}
.store-metric strong{font-size:20px;font-family:'Space Grotesk',sans-serif;color:#1d1119}
.store-banner{margin-top:12px;border-radius:12px;overflow:hidden;background:#f8e6f1;border:1px solid #e5ccdb}
.store-banner img{width:100%;height:200px;object-fit:cover;display:block}
.cat-strip{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}
.cat-item{background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:12px;text-align:center;text-decoration:none;color:inherit}
.cat-item.active{border-color:var(--orange);color:var(--orange)}
.mini-social{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px}
.social-card{background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:12px;text-align:center;color:var(--muted)}
.social-card.has-link{cursor:pointer;transition:border-color .2s,color .2s}
.social-card.has-link:hover{border-color:var(--orange);color:var(--orange)}
.social-card i{display:block;font-size:18px;margin-bottom:8px;color:var(--orange)}
.store-products{padding-top:4px}
.store-products .sec-title{font-size:19px}
@media(max-width:900px){.cat-strip,.mini-social{grid-template-columns:repeat(2,minmax(0,1fr))}}
</style>
@endpush

@section('content')
<main class="store-page">
  @php
    $socials = [
      ['icon' => 'fa-instagram', 'label' => 'Instagram', 'url' => $seller->boutique?->instagram_url],
      ['icon' => 'fa-snapchat', 'label' => 'Snapchat', 'url' => $seller->boutique?->snapchat_url],
      ['icon' => 'fa-tiktok', 'label' => 'TikTok', 'url' => $seller->boutique?->tiktok_url],
      ['icon' => 'fa-youtube', 'label' => 'YouTube', 'url' => $seller->boutique?->youtube_url],
    ];
  @endphp
  <section class="store-top">
    <div class="store-head">
      <div class="store-brand">
        <img class="store-logo" src="{{ $seller->boutique?->logoUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($seller->boutique?->nom ?? $seller->nom) . '&background=f8bfdc&color=2a1d27' }}" alt="Logo boutique">
        <div>
          <div class="store-title" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">{{ strtoupper($seller->boutique?->nom ?? $seller->nom) }}
            @if($seller->sellerShowsVerifiedBadge())
              <span style="font-size:11px;font-weight:800;background:rgba(255,107,53,.15);color:#FF6B35;padding:4px 10px;border-radius:50px;letter-spacing:.04em">VÉRIFIÉ NEXSHOP</span>
            @endif
          </div>
          <div style="font-size:13px;color:#533c4f">
            {{ $seller->boutique?->description ?? ('Seller: ' . $seller->nom . ' - vitrine publique des produits sans etapes KYC cote affichage.') }}
          </div>
        </div>
      </div>
      <form action="{{ route('buyer.sellers.follow', $seller) }}" method="post">
        @csrf
        <button class="btn-primary" type="submit">
          <i class="fa-solid fa-{{ $isFollowingSeller ? 'check' : 'plus' }}"></i>
          {{ $isFollowingSeller ? 'Suivi' : 'Suivre' }}
        </button>
      </form>
    </div>

    <div class="store-metrics" style="margin-top:12px">
      <div class="store-metric"><strong>{{ number_format($avgRating, 1) }}</strong><br>Evaluation</div>
      <div class="store-metric"><strong>{{ number_format($products->total()) }}</strong><br>Articles</div>
      <div class="store-metric"><strong>{{ number_format($sellerFavoritesCount) }}</strong><br>Favoris</div>
    </div>

    <div class="store-banner">
      <img src="{{ $seller->boutique?->banniereUrl() ?? asset('images/home_buyer.png') }}" alt="Bannière boutique">
    </div>
  </section>

  <section>
    <div class="sec-row">
      <div>
        <div class="sec-title">Acheter par categories</div>
        <div class="sec-sub">Filtrer les articles de cette boutique</div>
      </div>
    </div>
    <div class="cat-strip">
      <a class="cat-item {{ !request('categorie') ? 'active' : '' }}" href="{{ route('buyer.stores.show', $seller) }}">Tous</a>
      @foreach($categories as $cat)
        <a class="cat-item {{ request('categorie') == $cat->id ? 'active' : '' }}" href="{{ route('buyer.stores.show', ['seller' => $seller->id, 'categorie' => $cat->id]) }}">{{ $cat->nom }}</a>
      @endforeach
    </div>
  </section>

  <section>
    <div class="sec-title" style="text-align:center;margin-bottom:10px">Suivez-nous</div>
    <div class="mini-social">
      @foreach($socials as $social)
        @php
          $url = $social['url'];
          $display = 'Non renseigné';
          if (!empty($url)) {
              $display = preg_replace('#^https?://(www\.)?#', '', $url);
              $display = rtrim($display, '/');
          }
        @endphp
        @if(!empty($url))
          <a class="social-card has-link" href="{{ $url }}" target="_blank" rel="noopener noreferrer">
            <i class="fa-brands {{ $social['icon'] }}"></i>{{ $display }}
          </a>
        @else
          <div class="social-card">
            <i class="fa-brands {{ $social['icon'] }}"></i>{{ $display }}
          </div>
        @endif
      @endforeach
    </div>
  </section>

  <section class="store-products">
    <div class="sec-row">
      <div>
        <div class="sec-title"><i class="fa-solid fa-fire" style="color:var(--orange)"></i> Meilleures ventes</div>
        <div class="sec-sub">{{ $products->total() }} article(s) dans la boutique</div>
      </div>
    </div>

    <div class="prods-grid">
      @forelse($products as $p)
        @php $inFav = auth()->user()->favoris()->where('produit_id', $p->id)->exists(); $note = $p->noteMoyenne(); @endphp
        <div class="prod-card">
          <a href="{{ route('buyer.products.show', $p) }}" class="prod-img-wrap" style="display:block;position:relative">
            <img src="{{ $p->imageUrl() }}" alt="{{ $p->nom }}">
            <form action="{{ route('buyer.favorites.toggle', $p) }}" method="post" style="position:absolute;top:9px;right:9px" onclick="event.preventDefault();this.submit()">
              @csrf
              <button type="submit" class="prod-wish {{ $inFav ? 'in-fav' : '' }}"><i class="fa-{{ $inFav ? 'solid' : 'regular' }} fa-heart" @if($inFav) style="color:#ef4444" @endif></i></button>
            </form>
          </a>
          <div class="prod-body">
            <div class="prod-cat-lbl">{{ $p->categorie?->nom ?? 'Non catégorisé' }}</div>
            <a href="{{ route('buyer.products.show', $p) }}" class="prod-name">{{ $p->nom }}</a>
            <div><span class="prod-stars">★★★★★</span><span class="prod-rcount">({{ number_format($note, 1) }})</span></div>
            <div class="prod-foot">
              <div><span class="prod-price">{{ money_fdj($p->prix) }}</span></div>
              <div class="prod-btns">
                <a href="{{ route('buyer.products.show', $p) }}" class="btn-eye"><i class="fa-regular fa-eye"></i></a>
                <form action="{{ route('buyer.cart.add') }}" method="post" style="display:inline">
                  @csrf
                  <input type="hidden" name="produit_id" value="{{ $p->id }}">
                  <input type="hidden" name="quantite" value="1">
                  <button type="submit" class="btn-add"><i class="fa-solid fa-cart-plus"></i> Ajouter</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @empty
        <p style="grid-column:1/-1;color:var(--muted);padding:40px 0">Aucun produit pour cette boutique.</p>
      @endforelse
    </div>

    @if($products->hasPages())
      <div class="pagination">
        @foreach($products->getUrlRange(1, $products->lastPage()) as $num => $url)
          <a href="{{ $url }}" class="{{ $products->currentPage() == $num ? 'current' : '' }}">{{ $num }}</a>
        @endforeach
      </div>
    @endif
  </section>
</main>
@endsection
