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
.pf-overlay{position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:400;display:flex;align-items:center;justify-content:center;padding:20px;backdrop-filter:blur(4px)}
.pf-modal{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);max-width:480px;width:100%;padding:26px;box-shadow:0 24px 48px rgba(0,0,0,.5)}
.pf-modal h3{font-family:'Space Grotesk',sans-serif;font-size:1.1rem;margin:0 0 8px;color:var(--text)}
.pf-modal p{color:var(--muted);font-size:13px;line-height:1.55;margin:0 0 18px}
.pf-stars{display:flex;gap:6px;margin-bottom:14px}
.pf-stars button{border:none;background:transparent;color:var(--muted);font-size:22px;cursor:pointer;padding:0;line-height:1;transition:color .15s,color .15s}
.pf-stars button.is-on,.pf-stars button:hover{color:var(--orange)}
.pf-modal textarea{width:100%;min-height:100px;padding:12px;border-radius:var(--radius-xs);border:1px solid var(--border);background:var(--bg3);color:var(--text);font:inherit;font-size:14px;margin-bottom:14px;resize:vertical}
.pf-modal textarea:focus{outline:none;border-color:var(--orange)}
.pf-actions{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
.pf-actions .btn-primary{margin:0}
.pf-skip{background:transparent;border:1px solid var(--border);color:var(--muted);padding:10px 16px;border-radius:var(--radius-xs);font-size:13px;font-weight:600;cursor:pointer;font-family:inherit}
.pf-skip:hover{border-color:var(--orange);color:var(--orange)}
.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
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
      @if(in_array($order->statut, ['livree', 'confirmee']))
        <a href="{{ route('buyer.returns.create', $order) }}" class="btn-primary" style="background:var(--bg3);border:1px solid var(--border);box-shadow:none"><i class="fa-solid fa-rotate-left"></i> Demander un retour</a>
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
    @php
      $subtotal = $order->details->sum(fn ($d) => (float) $d->prix_unitaire * (int) $d->quantite);
      $deliveryFee = (float) ($order->frais_livraison ?? 0);
      $zoneLabel = ($order->zone_livraison ?? '') === 'region' ? 'Région (hors ville)' : 'Djibouti-ville';
    @endphp
    <table>
      <thead>
        <tr><th>Produit</th><th>Prix unit.</th><th>Qté</th><th>Total</th></tr>
      </thead>
      <tbody>
        @foreach($order->details as $d)
          <tr>
            <td><a href="{{ route('buyer.products.show', $d->produit) }}" style="color:var(--text)">{{ $d->produit->nom }}</a></td>
            <td>{{ money_fdj($d->prix_unitaire) }}</td>
            <td>{{ $d->quantite }}</td>
            <td>{{ money_fdj($d->prix_unitaire * $d->quantite) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div style="margin-top:14px;display:flex;flex-direction:column;gap:6px;font-size:13px;color:var(--muted)">
      <div style="display:flex;justify-content:space-between"><span>Sous-total</span><span>{{ money_fdj($subtotal) }}</span></div>
      <div style="display:flex;justify-content:space-between"><span>Frais de livraison ({{ $zoneLabel }})</span><span>{{ $deliveryFee > 0 ? money_fdj($deliveryFee) : 'Gratuit' }}</span></div>
    </div>
    <div class="total-row">Total : {{ money_fdj($order->montant_total) }}</div>
  </div>

  @if(!empty($showPlatformFeedbackModal))
    <div class="pf-overlay" id="pf-modal" role="dialog" aria-modal="true" aria-labelledby="pf-title">
      <div class="pf-modal">
        <h3 id="pf-title">Un avis sur NexShop ?</h3>
        <p>Vous venez de passer une commande. Dites-nous ce que vous pensez de la plateforme (navigation, commande, clarté…). Votre témoignage peut apparaître sur la page d’accueil. Un seul avis par compte.</p>
        <form action="{{ route('buyer.platform-feedback.store') }}" method="post" id="pf-form">
          @csrf
          <div class="pf-stars" id="pf-stars" role="group" aria-label="Note sur 5">
            @for($s = 1; $s <= 5; $s++)
              <button type="button" data-star="{{ $s }}" class="{{ $s <= 5 ? 'is-on' : '' }}" aria-pressed="{{ $s <= 5 ? 'true' : 'false' }}">★</button>
            @endfor
          </div>
          <input type="hidden" name="note" id="pf-note" value="5" required>
          <label for="pf-comment" class="sr-only">Commentaire</label>
          <textarea id="pf-comment" name="commentaire" required minlength="15" maxlength="2000" placeholder="Votre retour sur l’expérience NexShop (min. 15 caractères)"></textarea>
        </form>
        <div class="pf-actions">
          <button type="submit" form="pf-form" class="btn-primary">Envoyer mon avis</button>
          <form action="{{ route('buyer.platform-feedback.dismiss') }}" method="post" style="display:inline;margin:0">
            @csrf
            <input type="hidden" name="commande_id" value="{{ $order->id }}">
            <button type="submit" class="pf-skip">Plus tard</button>
          </form>
        </div>
      </div>
    </div>
  @endif
</main>
@endsection

@if(!empty($showPlatformFeedbackModal))
@push('scripts')
<script>
(function(){
  var modal = document.getElementById('pf-modal');
  if (!modal) return;
  var noteInput = document.getElementById('pf-note');
  var stars = modal.querySelectorAll('#pf-stars [data-star]');
  function setNote(n) {
    noteInput.value = String(n);
    stars.forEach(function (btn) {
      var s = parseInt(btn.getAttribute('data-star'), 10);
      var on = s <= n;
      btn.classList.toggle('is-on', on);
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  }
  stars.forEach(function (btn) {
    btn.addEventListener('click', function () {
      setNote(parseInt(btn.getAttribute('data-star'), 10));
    });
  });
  setNote(5);
})();
</script>
@endpush
@endif
