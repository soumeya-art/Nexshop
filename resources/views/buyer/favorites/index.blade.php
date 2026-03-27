@extends('buyer.layout')

@section('title', 'Mes favoris')

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Mes favoris</div>
      <div class="sec-sub">{{ $favoris->count() }} produit(s) enregistré(s)</div>
    </div>
    <a href="{{ route('buyer.products.index') }}" class="sec-link">Voir les produits <i class="fa-solid fa-chevron-right"></i></a>
  </div>

  @if($favoris->isEmpty())
    <p style="color:var(--muted);padding:40px 0">Aucun produit dans vos favoris. <a href="{{ route('buyer.home') }}" style="color:var(--orange)">Explorer les produits</a></p>
  @else
    <div class="prods-grid">
      @foreach($favoris as $fav)
        @php $p = $fav->produit; $note = $p->noteMoyenne(); @endphp
        <div class="prod-card">
          <a href="{{ route('buyer.products.show', $p) }}" class="prod-img-wrap" style="display:block;position:relative">
            <img src="{{ $p->imageUrl() }}" alt="{{ $p->nom }}">
            <form action="{{ route('buyer.favorites.toggle', $p) }}" method="post" style="position:absolute;top:9px;right:9px" onclick="event.preventDefault();this.submit()">
              @csrf
              <button type="submit" class="prod-wish in-fav" title="Retirer des favoris"><i class="fa-solid fa-heart" style="color:#ef4444"></i></button>
            </form>
          </a>
          <div class="prod-body">
            <div class="prod-cat-lbl">{{ $p->categorie?->nom ?? 'Non catégorisé' }}</div>
            <a href="{{ route('buyer.products.show', $p) }}" class="prod-name">{{ $p->nom }}</a>
            <div><span class="prod-stars">★★★★★</span><span class="prod-rcount">({{ number_format($note, 1) }})</span></div>
            <div class="prod-foot">
              <div><span class="prod-price">{{ number_format($p->prix, 0, ',', ' ') }} €</span></div>
              <div class="prod-btns">
                <a href="{{ route('buyer.products.show', $p) }}" class="btn-eye"><i class="fa-regular fa-eye"></i></a>
                @if($p->stock > 0)
                  <form action="{{ route('buyer.cart.add') }}" method="post" style="display:inline">
                    @csrf
                    <input type="hidden" name="produit_id" value="{{ $p->id }}">
                    <input type="hidden" name="quantite" value="1">
                    <button type="submit" class="btn-add"><i class="fa-solid fa-cart-plus"></i> Ajouter</button>
                  </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</main>
@endsection
