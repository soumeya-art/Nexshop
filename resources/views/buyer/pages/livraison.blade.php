@extends('buyer.layout')

@section('title', 'Politique de livraison')

@push('styles')
<style>
.info-page{max-width:800px;margin:0 auto}
.info-page-title{font-family:'Space Grotesk',sans-serif;font-size:26px;font-weight:800;color:var(--white);margin-bottom:6px}
.info-page-sub{font-size:13px;color:var(--muted);margin-bottom:28px}
.info-block{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:18px}
.info-block h3{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;color:var(--white);margin-bottom:10px;display:flex;align-items:center;gap:10px}
.info-block h3 i{color:var(--orange);font-size:14px}
.info-block p,.info-block li{font-size:14px;color:var(--muted);line-height:1.75}
.info-block ul{padding-left:20px;margin-top:8px}
.info-block ul li{margin-bottom:6px}
</style>
@endpush

@section('content')
<main class="info-page">
  <h1 class="info-page-title">Politique de livraison</h1>
  <p class="info-page-sub">Tout savoir sur la livraison de vos commandes NexShop.</p>

  <div class="info-block">
    <h3><i class="fa-solid fa-truck-fast"></i> Délais de livraison</h3>
    <p>Toutes les commandes passées sur NexShop sont livrées sous <strong>24 heures</strong> dans Djibouti-ville. Pour les zones périphériques, un délai de 48 à 72 heures peut s'appliquer.</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-money-bill-wave"></i> Frais de livraison</h3>
    <p>La livraison est <strong>gratuite</strong> pour toute commande d'un montant supérieur ou égal à <strong>10 000 Fdj</strong>. En dessous de ce montant, les frais sont de <strong>500 Fdj</strong> pour Djibouti-ville et <strong>1 000 Fdj</strong> pour les régions (hors ville).</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-hand-holding-dollar"></i> Paiement</h3>
    <p>Le paiement s'effectue <strong>en espèces à la livraison</strong>. Aucun prépaiement en ligne n'est requis. Vous payez uniquement quand vous recevez votre commande.</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-circle-info"></i> Bon à savoir</h3>
    <ul>
      <li>Vous serez contacté par téléphone avant la livraison.</li>
      <li>Vérifiez votre commande en présence du livreur.</li>
      <li>En cas de problème, vous disposez de 5 jours pour demander un retour.</li>
      <li>Les commandes annulées avant l'envoi sont intégralement remboursées (stock restauré).</li>
    </ul>
  </div>
</main>
@endsection
