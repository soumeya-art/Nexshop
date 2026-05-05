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
.delivery-zones{display:grid;gap:10px}
.delivery-zone{display:flex;gap:10px;align-items:flex-start;background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 12px;cursor:pointer}
.delivery-zone input{margin-top:2px}
.delivery-zone .dz-title{font-size:13px;font-weight:700;color:var(--text)}
.delivery-zone .dz-sub{font-size:12px;color:var(--muted)}
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
            <td>{{ money_fdj($item->produit->prix) }}</td>
            <td>
              <form action="{{ route('buyer.cart.update', $item) }}" method="post" class="cart-qty" style="display:inline-flex;align-items:center;gap:8px">
                @csrf
                <input type="number" name="quantite" value="{{ $item->quantite }}" min="1" max="{{ $item->produit->stock }}" onchange="this.form.submit()">
              </form>
            </td>
            <td>{{ money_fdj($item->produit->prix * $item->quantite) }}</td>
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
        @php
          $selectedZone = old('zone_livraison', 'djibouti_ville');
          $cityFee = (float) ($deliveryFees['city'] ?? 500);
          $regionFee = (float) ($deliveryFees['region'] ?? 1000);
          $freeThreshold = (float) ($deliveryFees['free_threshold'] ?? 10000);
          $initialDelivery = $total >= $freeThreshold ? 0 : ($selectedZone === 'region' ? $regionFee : $cityFee);
        @endphp
        <div class="cart-summary-row"><span>Sous-total</span><span>{{ money_fdj($total, 0) }}</span></div>
        <div class="cart-summary-row">
          <span>Frais de livraison</span>
          <span id="delivery-fee-label">{{ $initialDelivery > 0 ? money_fdj($initialDelivery, 0) : 'Gratuit' }}</span>
        </div>
        <div class="cart-summary-grand"><span>Total</span><span id="order-total-label">{{ money_fdj($total + $initialDelivery, 0) }}</span></div>
        <p style="font-size:13px;color:var(--muted);margin-top:12px;margin-bottom:20px">Paiement en espèces à la livraison.</p>
        <form action="{{ route('buyer.orders.store') }}" method="post" class="contact-form">
          @csrf
          <div class="form-group">
            <label>Zone de livraison</label>
            <div class="delivery-zones">
              <label class="delivery-zone">
                <input type="radio" name="zone_livraison" value="djibouti_ville" {{ $selectedZone === 'djibouti_ville' ? 'checked' : '' }}>
                <span>
                  <span class="dz-title">Djibouti-ville</span><br>
                  <span class="dz-sub">{{ $total >= $freeThreshold ? 'Gratuit dès '.money_fdj($freeThreshold, 0) : money_fdj($cityFee, 0) }}</span>
                </span>
              </label>
              <label class="delivery-zone">
                <input type="radio" name="zone_livraison" value="region" {{ $selectedZone === 'region' ? 'checked' : '' }}>
                <span>
                  <span class="dz-title">Région (hors ville)</span><br>
                  <span class="dz-sub">{{ $total >= $freeThreshold ? 'Gratuit dès '.money_fdj($freeThreshold, 0) : money_fdj($regionFee, 0) }}</span>
                </span>
              </label>
            </div>
          </div>
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

@push('scripts')
<script>
(function(){
  const subtotal = {{ (float) $total }};
  const cityFee = {{ (float) ($deliveryFees['city'] ?? 500) }};
  const regionFee = {{ (float) ($deliveryFees['region'] ?? 1000) }};
  const freeThreshold = {{ (float) ($deliveryFees['free_threshold'] ?? 10000) }};
  const feeLabel = document.getElementById('delivery-fee-label');
  const totalLabel = document.getElementById('order-total-label');

  function formatFdj(v){
    return new Intl.NumberFormat('fr-FR', {maximumFractionDigits: 0}).format(Math.round(v)) + ' Fdj';
  }

  function updateTotals(){
    const checked = document.querySelector('input[name="zone_livraison"]:checked');
    const zone = checked ? checked.value : 'djibouti_ville';
    const fee = subtotal >= freeThreshold ? 0 : (zone === 'region' ? regionFee : cityFee);
    feeLabel.textContent = fee > 0 ? formatFdj(fee) : 'Gratuit';
    totalLabel.textContent = formatFdj(subtotal + fee);
  }

  document.querySelectorAll('input[name="zone_livraison"]').forEach((el)=>{
    el.addEventListener('change', updateTotals);
  });
  updateTotals();
})();
</script>
@endpush
