@extends('buyer.layout')

@section('title', 'Mon panier')

@push('styles')
<style>
.cart-table{width:100%;border-collapse:collapse}
.cart-table th,.cart-table td{padding:14px;text-align:left;border-bottom:1px solid var(--border)}
.cart-table th{font-size:11px;text-transform:uppercase;color:var(--muted);font-weight:600;letter-spacing:.08em}
.cart-table img{width:60px;height:60px;object-fit:cover;border-radius:var(--radius-sm)}
.cart-qty input{width:54px;text-align:center;padding:8px;background:var(--bg3);border:1.5px solid var(--border);border-radius:var(--radius-sm);color:var(--white);font-size:14px}
.cart-total-wrap{margin-top:32px;max-width:400px;margin-left:auto}
.cart-summary-row{display:flex;justify-content:space-between;margin-bottom:10px;font-size:14px;color:var(--text)}
.cart-summary-grand{display:flex;justify-content:space-between;font-size:18px;font-weight:800;color:var(--orange);margin-top:14px;padding-top:14px;border-top:1px solid var(--border)}
.empty-cart{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-cart p{font-size:16px;margin-bottom:16px}
</style>
@endpush

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Mon panier</div>
      <div class="sec-sub">{{ $items->count() }} article(s)</div>
    </div>
    <a href="{{ route('buyer.products.index') }}" class="sec-link">Continuer mes achats <i class="fa-solid fa-chevron-right"></i></a>
  </div>

  @if($items->isEmpty())
    <div class="empty-cart">
      <p>Votre panier est vide.</p>
      <a href="{{ route('buyer.home') }}" class="btn-primary">Voir les produits</a>
    </div>
  @else
    <table class="cart-table">
      <thead>
        <tr>
          <th>Produit</th>
          <th>Prix unitaire</th>
          <th>Quantité</th>
          <th>Total</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
          <tr>
            <td>
              <a href="{{ route('buyer.products.show', $item->produit) }}" style="display:flex;align-items:center;gap:12px;color:inherit">
                <img src="{{ $item->produit->imageUrl() }}" alt="">
                <span>{{ $item->produit->nom }}</span>
              </a>
            </td>
            <td>{{ number_format($item->produit->prix, 0, ',', ' ') }} €</td>
            <td>
              <form action="{{ route('buyer.cart.update', $item) }}" method="post" class="cart-qty" style="display:inline-flex;align-items:center;gap:8px">
                @csrf
                <input type="number" name="quantite" value="{{ $item->quantite }}" min="1" max="{{ $item->produit->stock }}" onchange="this.form.submit()">
              </form>
            </td>
            <td>{{ number_format($item->produit->prix * $item->quantite, 0, ',', ' ') }} €</td>
            <td>
              <form action="{{ route('buyer.cart.remove', $item) }}" method="post" style="display:inline" onsubmit="return confirm('Retirer cet article ?')">
                @csrf
                <button type="submit" class="btn-danger"><i class="fa-solid fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="cart-total-wrap">
      <div class="contact-form-wrap">
        <div class="cart-summary-row"><span>Sous-total</span><span>{{ number_format($total, 2, ',', ' ') }} €</span></div>
        <div class="cart-summary-grand"><span>Total</span><span>{{ number_format($total, 2, ',', ' ') }} €</span></div>
        <p style="font-size:13px;color:var(--muted);margin-top:12px;margin-bottom:20px">Paiement en espèces à la livraison.</p>
        <form action="{{ route('buyer.orders.store') }}" method="post" class="contact-form">
          @csrf
          <div class="form-group">
            <label>Adresse de livraison</label>
            <input type="text" name="adresse_livraison" value="{{ old('adresse_livraison', auth()->user()->adresse) }}" placeholder="Adresse complète pour la livraison" required>
          </div>
          <button type="submit" class="btn-primary" style="width:100%;justify-content:center"><i class="fa-solid fa-credit-card"></i> Passer la commande</button>
        </form>
      </div>
    </div>
  @endif
</main>
@endsection
