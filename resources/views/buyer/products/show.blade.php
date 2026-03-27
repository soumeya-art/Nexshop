@extends('buyer.layout')

@section('title', $product->nom)

@push('styles')
<style>
.prod-detail{display:grid;grid-template-columns:1fr 1fr;gap:32px;align-items:start}
@media(max-width:768px){.prod-detail{grid-template-columns:1fr}}
.prod-detail-img{border-radius:var(--radius);overflow:hidden;background:var(--bg3);aspect-ratio:1}
.prod-detail-img img{width:100%;height:100%;object-fit:cover}
.prod-detail-info .prod-name{font-size:22px;margin-bottom:12px}
.prod-detail-info .prod-price{font-size:24px;margin:16px 0}
.rating-form{margin:20px 0;padding:20px;background:var(--bg2);border-radius:var(--radius);border:1px solid var(--border)}
.review-list{margin-top:24px}
.review-item{padding:16px;background:var(--bg2);border-radius:var(--radius-sm);margin-bottom:12px;border:1px solid var(--border)}
.review-item .stars{color:#FCD34D;font-size:1.1em}
.prod-rating-display .prod-stars{color:#FCD34D;font-size:1.1em}
.rating-select{font-size:1.2em;letter-spacing:.15em}
</style>
@endpush

@section('content')
<main>
  <div class="prod-detail">
    <div class="prod-detail-img">
      <img src="{{ $product->imageUrl() }}" alt="{{ $product->nom }}">
    </div>
    <div class="prod-detail-info">
      <div class="prod-cat-lbl">{{ $product->categorie?->nom ?? 'Non catégorisé' }}</div>
      <h1 class="prod-name">{{ $product->nom }}</h1>
      @php $noteMoy = $product->noteMoyenne(); $noteInt = (int) round($noteMoy); @endphp
      <div class="prod-rating-display">
        <span class="prod-stars" aria-label="{{ number_format($noteMoy, 1) }} sur 5">{{ str_repeat('★', $noteInt) }}{{ str_repeat('☆', 5 - $noteInt) }}</span>
        <span class="prod-rcount">({{ number_format($noteMoy, 1) }}) — {{ $product->avis->count() }} avis</span>
      </div>
      <div class="prod-price">{{ number_format($product->prix, 0, ',', ' ') }} €</div>
      <p style="color:var(--muted);font-size:14px;line-height:1.6;margin-bottom:20px">{{ $product->description }}</p>
      <p style="font-size:13px;color:var(--muted)">Stock : {{ $product->stock }} disponible(s)</p>

      <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:24px">
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
            <input type="hidden" name="quantite" value="1">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-cart-plus"></i> Ajouter au panier</button>
          </form>
        @else
          <span style="color:var(--muted)">Rupture de stock</span>
        @endif
      </div>

      {{-- Formulaire avis / note --}}
      <div class="rating-form">
        <h3 style="font-size:16px;margin-bottom:12px">Laisser un avis / Noter le produit</h3>
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
      </div>
    </div>
  </div>

  <div class="review-list">
    <h3 style="font-size:17px;margin-bottom:16px">Avis des clients</h3>
    @forelse($product->avis as $avis)
      <div class="review-item">
        <div class="stars">{{ str_repeat('★', (int)$avis->note) }}{{ str_repeat('☆', 5 - (int)$avis->note) }}</div>
        @if($avis->commentaire)<p style="margin:8px 0;font-size:14px">{{ $avis->commentaire }}</p>@endif
        <small style="color:var(--muted)">{{ $avis->date_avis?->format('d/m/Y') }}</small>
      </div>
    @empty
      <p style="color:var(--muted)">Aucun avis pour le moment.</p>
    @endforelse
  </div>
</main>
@endsection
