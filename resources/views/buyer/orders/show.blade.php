@extends('buyer.layout')

@section('title', 'Commande #'.$order->id)

@push('styles')
<style>
.order-detail-card{background:rgba(20,20,20,.85);backdrop-filter:blur(16px);border:1px solid var(--border);border-radius:var(--radius);padding:28px;margin-bottom:24px}
.order-detail-card h3{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--orange);margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)}
.order-detail-card table{width:100%;border-collapse:collapse}
.order-detail-card th,.order-detail-card td{padding:12px 0;text-align:left;border-bottom:1px solid var(--border);font-size:14px}
.order-detail-card th{font-size:11px;text-transform:uppercase;color:var(--muted);letter-spacing:.06em}
.order-detail-card .total-row{font-size:18px;font-weight:800;color:var(--orange);margin-top:16px;text-align:right;padding-top:16px;border-top:1px solid var(--border)}
.statut-badge{padding:6px 12px;border-radius:50px;font-size:12px;font-weight:700;display:inline-block}
.statut-en_attente{background:rgba(245,158,11,.2);color:#F59E0B}
.statut-livree{background:rgba(34,197,94,.2);color:#22C55E}
.statut-confirmee,.statut-en_preparation{background:rgba(33,150,243,.2);color:#2196F3}
.statut-en_livraison{background:rgba(156,39,176,.2);color:#9C27B0}
.statut-annulee{background:rgba(239,68,68,.2);color:#EF4444}
</style>
@endpush

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Commande #{{ $order->id }}</div>
      <div class="sec-sub">Du {{ $order->date_commande?->format('d/m/Y à H:i') }} — <span class="statut-badge statut-{{ $order->statut }}">{{ $order->statut }}</span></div>
    </div>
    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
      @if($order->statut === 'en_attente')
        <form action="{{ route('buyer.orders.cancel', $order) }}" method="post" style="display:inline" onsubmit="return confirm('Annuler cette commande ?');">
          @csrf
          <button type="submit" class="btn-danger"><i class="fa-solid fa-xmark"></i> Annuler la commande</button>
        </form>
      @endif
      <a href="{{ route('buyer.orders.index') }}" class="sec-link"><i class="fa-solid fa-arrow-left"></i> Mes commandes</a>
    </div>
  </div>

  <div class="order-detail-card">
    <h3>Adresse de livraison</h3>
    <p style="color:var(--muted);font-size:14px;line-height:1.6">{{ $order->adresse_livraison }}</p>
    <p style="color:var(--muted);font-size:13px;margin-top:12px">Paiement : {{ $order->mode_paiement }} — {{ $order->statut_paiement }}</p>
  </div>

  <div class="order-detail-card">
    <h3>Détail des articles</h3>
    <table>
      <thead>
        <tr><th>Produit</th><th>Prix unit.</th><th>Qté</th><th>Total</th></tr>
      </thead>
      <tbody>
        @foreach($order->details as $d)
          <tr>
            <td><a href="{{ route('buyer.products.show', $d->produit) }}" style="color:var(--text)">{{ $d->produit->nom }}</a></td>
            <td>{{ number_format($d->prix_unitaire, 0, ',', ' ') }} €</td>
            <td>{{ $d->quantite }}</td>
            <td>{{ number_format($d->prix_unitaire * $d->quantite, 0, ',', ' ') }} €</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="total-row">Total : {{ number_format($order->montant_total, 0, ',', ' ') }} €</div>
  </div>
</main>
@endsection
