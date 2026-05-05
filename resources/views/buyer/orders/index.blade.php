@extends('buyer.layout')

@section('title', 'Mes commandes')

@push('styles')
<style>
.orders-list{display:flex;flex-direction:column;gap:16px}
.order-card{background:rgba(20,20,20,.85);backdrop-filter:blur(16px);border:1px solid var(--border);border-radius:var(--radius);padding:24px;transition:border-color var(--T);display:block;text-decoration:none;color:inherit}
.order-card:hover{border-color:rgba(255,107,53,.4)}
.order-card h3{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;margin-bottom:10px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px}
.order-card .statut{padding:6px 12px;border-radius:50px;font-size:11px;font-weight:700;letter-spacing:.05em;text-transform:uppercase}
.statut-en_attente{background:rgba(245,158,11,.2);color:#F59E0B}
.statut-confirmee,.statut-en_preparation{background:rgba(33,150,243,.2);color:#2196F3}
.statut-en_livraison{background:rgba(156,39,176,.2);color:#9C27B0}
.statut-livree{background:rgba(34,197,94,.2);color:#22C55E}
.statut-annulee{background:rgba(239,68,68,.2);color:#EF4444}
.order-card .detail{font-size:14px;color:var(--muted)}
.empty-orders{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-orders p{font-size:16px;margin-bottom:16px}
</style>
@endpush

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Mes commandes</div>
      <div class="sec-sub">Consultez l'état de vos commandes.</div>
    </div>
    <a href="{{ route('buyer.products.index') }}" class="sec-link">Voir les produits <i class="fa-solid fa-chevron-right"></i></a>
  </div>

  @if($orders->isEmpty())
    <div class="empty-orders">
      <p>Vous n'avez pas encore passé de commande.</p>
      <a href="{{ route('buyer.home') }}" class="btn-primary">Découvrir les produits</a>
    </div>
  @else
    <div class="orders-list">
      @foreach($orders as $order)
        <a href="{{ route('buyer.orders.show', $order) }}" class="order-card">
          <h3>
            <span>Commande #{{ $order->id }} — {{ $order->date_commande?->format('d/m/Y H:i') }}</span>
            <span class="statut statut-{{ $order->statut }}">{{ $order->statut }}</span>
          </h3>
          <div class="detail">{{ money_fdj($order->montant_total) }} — {{ $order->details->count() }} article(s)</div>
        </a>
      @endforeach
    </div>

    @if($orders->hasPages())
      <div class="pagination">
        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $num => $url)
          <a href="{{ $url }}" class="{{ $orders->currentPage() == $num ? 'current' : '' }}">{{ $num }}</a>
        @endforeach
      </div>
    @endif
  @endif
</main>
@endsection
