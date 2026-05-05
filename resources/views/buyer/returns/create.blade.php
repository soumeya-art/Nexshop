@extends('buyer.layout')

@section('title', 'Demande de retour — Commande #'.$order->id)

@push('styles')
<style>
.ret-form-card{background:rgba(20,20,20,.85);backdrop-filter:blur(16px);border:1px solid var(--border);border-radius:var(--radius);padding:28px;margin-bottom:20px}
.ret-form-card h3{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--orange);margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)}
.ret-form{display:flex;flex-direction:column;gap:16px}
.ret-fg{display:flex;flex-direction:column;gap:6px}
.ret-fg label{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted)}
.ret-fg select,.ret-fg input,.ret-fg textarea{background:var(--bg3);border:1.5px solid var(--border);border-radius:var(--radius-xs);padding:11px 14px;color:var(--white);font-family:'Inter',sans-serif;font-size:14px;outline:none;transition:border-color var(--T);width:100%;resize:none}
.ret-fg select:focus,.ret-fg input:focus,.ret-fg textarea:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(255,107,53,.1)}
.ret-fg select option{background:var(--bg3);color:var(--white)}
.ret-info{font-size:13px;color:var(--muted);line-height:1.6;margin-bottom:6px}
.ret-info i{color:var(--orange);margin-right:4px}
</style>
@endpush

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Demande de retour</div>
      <div class="sec-sub">Commande #{{ $order->id }} — {{ $order->date_commande?->format('d/m/Y') }}</div>
    </div>
    <a href="{{ route('buyer.orders.show', $order) }}" class="sec-link"><i class="fa-solid fa-arrow-left"></i> Retour commande</a>
  </div>

  @if(session('error'))
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#EF4444;padding:12px 16px;border-radius:var(--radius-xs);margin-bottom:16px;font-size:13px"><i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}</div>
  @endif

  @if($errors->any())
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#EF4444;padding:12px 16px;border-radius:var(--radius-xs);margin-bottom:16px;font-size:13px">
      @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
    </div>
  @endif

  <div class="ret-form-card">
    <h3>Formulaire de retour</h3>
    <p class="ret-info"><i class="fa-solid fa-clock"></i> Vous disposez de <strong>5 jours</strong> après la livraison pour demander un retour.</p>
    <p class="ret-info"><i class="fa-solid fa-user-shield"></i> L'admin contactera le vendeur pour traiter votre demande.</p>

    <form action="{{ route('buyer.returns.store', $order) }}" method="POST" class="ret-form">
      @csrf

      <div class="ret-fg">
        <label for="produit_id">Produit à retourner</label>
        <select name="produit_id" id="produit_id" required>
          <option value="">— Choisir un produit —</option>
          @foreach($order->details as $d)
            <option value="{{ $d->produit_id }}" {{ old('produit_id') == $d->produit_id ? 'selected' : '' }}>
              {{ $d->produit->nom }} (x{{ $d->quantite }} — {{ money_fdj($d->prix_unitaire) }}/unité)
            </option>
          @endforeach
        </select>
      </div>

      <div class="ret-fg">
        <label for="quantite">Quantité à retourner</label>
        <input type="number" name="quantite" id="quantite" min="1" value="{{ old('quantite', 1) }}" required>
      </div>

      <div class="ret-fg">
        <label for="motif">Motif du retour</label>
        <select name="motif" id="motif" required>
          <option value="">— Choisir un motif —</option>
          <option value="Produit défectueux" {{ old('motif') == 'Produit défectueux' ? 'selected' : '' }}>Produit défectueux</option>
          <option value="Produit non conforme" {{ old('motif') == 'Produit non conforme' ? 'selected' : '' }}>Produit non conforme à la description</option>
          <option value="Erreur de commande" {{ old('motif') == 'Erreur de commande' ? 'selected' : '' }}>Erreur de commande</option>
          <option value="Taille incorrecte" {{ old('motif') == 'Taille incorrecte' ? 'selected' : '' }}>Taille incorrecte</option>
          <option value="Changement d'avis" {{ old('motif') == "Changement d'avis" ? 'selected' : '' }}>Changement d'avis</option>
          <option value="Autre" {{ old('motif') == 'Autre' ? 'selected' : '' }}>Autre</option>
        </select>
      </div>

      <div class="ret-fg">
        <label for="description">Description (optionnel)</label>
        <textarea name="description" id="description" rows="4" maxlength="2000" placeholder="Décrivez le problème en détail…">{{ old('description') }}</textarea>
      </div>

      <button type="submit" class="btn-primary" style="align-self:flex-start;margin-top:8px">
        <i class="fa-solid fa-paper-plane"></i> Envoyer la demande
      </button>
    </form>
  </div>
</main>
@endsection
