@extends('buyer.layout')

@section('title', 'À propos')

@push('styles')
<style>
.info-page{max-width:800px;margin:0 auto}
.info-page-title{font-family:'Space Grotesk',sans-serif;font-size:26px;font-weight:800;color:var(--white);margin-bottom:6px}
.info-page-sub{font-size:13px;color:var(--muted);margin-bottom:28px}
.info-block{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:18px}
.info-block h3{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;color:var(--white);margin-bottom:10px;display:flex;align-items:center;gap:10px}
.info-block h3 i{color:var(--orange);font-size:14px}
.info-block p{font-size:14px;color:var(--muted);line-height:1.75}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
@media(max-width:640px){.info-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<main class="info-page">
  <h1 class="info-page-title">À propos de NexShop</h1>
  <p class="info-page-sub">Découvrez notre plateforme et notre mission.</p>

  <div class="info-block">
    <h3><i class="fa-solid fa-store"></i> Qui sommes-nous ?</h3>
    <p><strong>NexShop</strong> est la première marketplace 100 % djiboutienne qui connecte vendeurs locaux et acheteurs. Notre objectif : rendre le commerce en ligne accessible, fiable et rapide pour tout Djibouti.</p>
  </div>

  <div class="info-grid">
    <div class="info-block">
      <h3><i class="fa-solid fa-bullseye"></i> Notre mission</h3>
      <p>Démocratiser le e-commerce à Djibouti en proposant une plateforme sécurisée, simple et adaptée aux réalités locales. Paiement en espèces, livraison rapide.</p>
    </div>
    <div class="info-block">
      <h3><i class="fa-solid fa-shield-halved"></i> Confiance</h3>
      <p>Tous les vendeurs sont vérifiés (KYC). Chaque produit est validé avant publication pour garantir la qualité à nos clients.</p>
    </div>
    <div class="info-block">
      <h3><i class="fa-solid fa-truck-fast"></i> Livraison</h3>
      <p>Livraison partout à Djibouti en 24h. Gratuite dès 10 000 Fdj. Paiement en espèces à la réception de votre commande.</p>
    </div>
    <div class="info-block">
      <h3><i class="fa-solid fa-rotate-left"></i> Retours</h3>
      <p>Retour possible sous 5 jours après réception. L'administrateur contacte le vendeur pour traiter chaque demande de retour.</p>
    </div>
  </div>
</main>
@endsection
