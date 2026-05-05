@extends('buyer.layout')

@section('title', 'Politique de confidentialité')

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
  <h1 class="info-page-title">Politique de confidentialité</h1>
  <p class="info-page-sub">Comment NexShop protège vos données personnelles.</p>

  <div class="info-block">
    <h3><i class="fa-solid fa-database"></i> Données collectées</h3>
    <p>NexShop collecte les données nécessaires au fonctionnement de la plateforme :</p>
    <ul>
      <li>Nom, email et téléphone (pour votre compte)</li>
      <li>Adresse de livraison (pour vos commandes)</li>
      <li>Historique de commandes et favoris</li>
      <li>Photo de profil (optionnelle)</li>
    </ul>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-lock"></i> Utilisation des données</h3>
    <p>Vos données sont utilisées exclusivement pour :</p>
    <ul>
      <li>Gérer votre compte et vos commandes</li>
      <li>Vous contacter concernant vos achats</li>
      <li>Améliorer l'expérience de la plateforme</li>
      <li>Envoyer des notifications relatives à vos commandes</li>
    </ul>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-shield-halved"></i> Protection</h3>
    <p>NexShop protège vos données conformément à la législation djiboutienne. Vos mots de passe sont chiffrés. <strong>Aucune donnée n'est partagée avec des tiers</strong> sans votre consentement explicite.</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-trash-can"></i> Vos droits</h3>
    <p>Vous pouvez à tout moment :</p>
    <ul>
      <li>Modifier vos informations personnelles via votre profil</li>
      <li>Demander la suppression de votre compte en contactant le support</li>
      <li>Demander l'export de vos données personnelles</li>
    </ul>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-envelope"></i> Contact</h3>
    <p>Pour toute question relative à vos données, contactez-nous à <strong>nexshop.dj@gmail.com</strong> ou au <strong>+253 77 44 78 73</strong>.</p>
  </div>
</main>
@endsection
