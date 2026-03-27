@extends('buyer.layout')

@section('title', 'Explorer')

@section('content')
<main>
  <div class="hero">
    <img class="hero-img" src="{{ asset('images\home_buyer.png')}}" alt="">
    <div class="hero-content">
      <div class="hero-tag"><i class="fa-solid fa-bolt"></i> Nouvelle Collection</div>
      <div class="hero-title">Préparez votre été<br>avec <span>style.</span></div>
      <a href="{{ route('buyer.products.index') }}" class="hero-btn"><i class="fa-solid fa-arrow-right"></i> Voir les produits</a>
    </div>
  </div>

  <div class="cat-bar">
    <span class="cat-label-txt"><i class="fa-solid fa-sliders"></i> Catégories</span>
    <a href="{{ route('buyer.home') }}" class="cat-chip {{ !request('categorie') ? 'active' : '' }}">Tous</a>
    @foreach($categories as $cat)
      <a href="{{ route('buyer.home', ['categorie' => $cat->id]) }}" class="cat-chip {{ request('categorie') == $cat->id ? 'active' : '' }}">{{ $cat->nom }}</a>
    @endforeach
  </div>

  <div class="sec-row">
    <div>
      <div class="sec-title">Sélection du moment</div>
      <div class="sec-sub">Basé sur vos préférences et les tendances actuelles.</div>
    </div>
    <span class="sec-link">{{ $products->total() }} produit(s) <i class="fa-solid fa-chevron-right"></i></span>
  </div>

  <div class="prods-grid" id="grid">
    @forelse($products as $p)
      @php
        $inFav = auth()->user()->favoris()->where('produit_id', $p->id)->exists();
        $note = $p->noteMoyenne();
      @endphp
      <div class="prod-card" data-cat="{{ $p->categorie?->nom ?? '' }}">
        <a href="{{ route('buyer.products.show', $p) }}" class="prod-img-wrap" style="display:block;position:relative">
          <img src="{{ $p->imageUrl() }}" alt="{{ $p->nom }}">
          <form action="{{ route('buyer.favorites.toggle', $p) }}" method="post" style="position:absolute;top:9px;right:9px" onclick="event.preventDefault();this.submit()">
            @csrf
            <button type="submit" class="prod-wish {{ $inFav ? 'in-fav' : '' }}" title="{{ $inFav ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
              <i class="fa-{{ $inFav ? 'solid' : 'regular' }} fa-heart" @if($inFav) style="color:#ef4444" @endif></i>
            </button>
          </form>
        </a>
        <div class="prod-body">
          <div class="prod-cat-lbl">{{ $p->categorie?->nom ?? 'Non catégorisé' }}</div>
          <a href="{{ route('buyer.products.show', $p) }}" class="prod-name">{{ $p->nom }}</a>
          <div>
            <span class="prod-stars">@for($i=1;$i<=5;$i++)★@endfor</span>
            <span class="prod-rcount">({{ number_format($note, 1) }})</span>
          </div>
          <div class="prod-foot">
            <div><span class="prod-price">{{ number_format($p->prix, 0, ',', ' ') }} €</span></div>
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
      <p style="grid-column:1/-1;color:var(--muted);padding:40px 0">Aucun produit pour le moment.</p>
    @endforelse
  </div>

  @if($products->hasPages())
    <div class="pagination">
      @foreach($products->getUrlRange(1, $products->lastPage()) as $num => $url)
        <a href="{{ $url }}" class="{{ $products->currentPage() == $num ? 'current' : '' }}">{{ $num }}</a>
      @endforeach
    </div>
  @endif
</main>
@endsection
