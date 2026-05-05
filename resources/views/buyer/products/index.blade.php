@extends('buyer.layout')

@section('title', 'Recherche produits')

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Recherche : {{ request('q') ? '"'.request('q').'"' : 'Tous les produits' }}</div>
      <div class="sec-sub">Filtrez par catégorie ci-dessous.</div>
    </div>
  </div>

  <div class="cat-bar">
    <span class="cat-label-txt"><i class="fa-solid fa-sliders"></i> Catégories</span>
    <a href="{{ route('buyer.products.index', request()->only('q')) }}" class="cat-chip {{ !request('categorie') ? 'active' : '' }}">Tous</a>
    @foreach($categories as $cat)
      <a href="{{ route('buyer.products.index', array_merge(request()->only('q'), ['categorie' => $cat->id])) }}" class="cat-chip {{ request('categorie') == $cat->id ? 'active' : '' }}">{{ $cat->nom }}</a>
    @endforeach
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
      <p style="grid-column:1/-1;color:var(--muted);padding:40px 0">Aucun produit trouvé.</p>
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
