@extends('buyer.layout')

@section('title', 'CGU & CGV')

@push('styles')
<style>
.info-page{max-width:800px;margin:0 auto}
.info-page-title{font-family:'Space Grotesk',sans-serif;font-size:26px;font-weight:800;color:var(--white);margin-bottom:6px}
.info-page-sub{font-size:13px;color:var(--muted);margin-bottom:28px}
.info-block{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:18px}
.info-block h3{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;color:var(--white);margin-bottom:10px;display:flex;align-items:center;gap:10px}
.info-block h3 i{color:var(--orange);font-size:14px}
.info-block p{font-size:14px;color:var(--muted);line-height:1.75}
</style>
@endpush

@section('content')
<main class="info-page">
  <h1 class="info-page-title">Conditions Générales d'Utilisation & de Vente</h1>
  <p class="info-page-sub">Dernière mise à jour : mai 2026</p>

  <div class="info-block">
    <h3><i class="fa-solid fa-file-contract"></i> Objet</h3>
    <p>Les présentes CGU/CGV définissent les conditions d'utilisation de la plateforme NexShop et les modalités de vente entre vendeurs et acheteurs. En utilisant NexShop, vous acceptez l'intégralité de ces conditions.</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-cart-shopping"></i> Commandes</h3>
    <p>Toute commande passée sur NexShop est un engagement d'achat. Le paiement s'effectue en espèces à la livraison. La commande est confirmée dès que le vendeur l'accepte. Vous pouvez annuler une commande tant qu'elle est en statut « en attente ».</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-rotate-left"></i> Retours & remboursements</h3>
    <p>Le retour est possible dans un délai de <strong>5 jours</strong> après réception du produit. Le produit doit être dans son état d'origine. L'administrateur contacte le vendeur pour traiter la demande. En cas d'acceptation, le stock est restauré.</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-ban"></i> Responsabilité</h3>
    <p>NexShop agit en tant qu'intermédiaire entre vendeurs et acheteurs. Chaque vendeur est responsable de la qualité, la conformité et la description de ses produits. NexShop modère les avis et valide les produits avant publication.</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-user-slash"></i> Suspension de compte</h3>
    <p>NexShop se réserve le droit de suspendre tout compte en cas de non-respect des présentes conditions, de fraude, ou d'abus signalé. L'utilisateur sera notifié par email avec le motif de la suspension.</p>
  </div>

  <div class="info-block">
    <h3><i class="fa-solid fa-gavel"></i> Litiges</h3>
    <p>En cas de litige, contactez notre support à nexshop.dj@gmail.com. NexShop s'engage à résoudre tout différend dans un délai de 7 jours ouvrés en médiation avec le vendeur concerné.</p>
  </div>
</main>
@endsection
