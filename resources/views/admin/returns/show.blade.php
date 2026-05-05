@extends('admin.returns.layout')

@section('returns-content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
  <div>
    <h1 class="page-title">Retour #{{ $retour->id }}</h1>
    <p class="page-sub">Demande de {{ $retour->client->nom ?? '—' }} — Commande #{{ $retour->commande_id }}</p>
  </div>
  <a href="{{ route('admin.returns.index') }}" class="btn-primary btn-sm" style="background:var(--bg3);box-shadow:none;border:1px solid var(--border)"><i class="fa-solid fa-arrow-left"></i> Liste des retours</a>
</div>

@if(session('success'))
  <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:24px">
  {{-- INFO RETOUR --}}
  <div class="card">
    <div class="card-head"><span class="card-title">Détail de la demande</span></div>
    <div class="card-body" style="font-size:13px;color:var(--text);line-height:1.8">
      <div><span style="color:var(--muted)">Statut :</span>
        @switch($retour->statut)
          @case('en_attente') <span style="color:#F59E0B;font-weight:700">En attente</span> @break
          @case('vendeur_contacte') <span style="color:#1E90FF;font-weight:700">Vendeur contacté</span> @break
          @case('acceptee') <span style="color:#22C55E;font-weight:700">Acceptée</span> @break
          @case('refusee') <span style="color:#EF4444;font-weight:700">Refusée</span> @break
        @endswitch
      </div>
      <div><span style="color:var(--muted)">Produit :</span> <strong>{{ $retour->produit->nom ?? '—' }}</strong></div>
      <div><span style="color:var(--muted)">Quantité :</span> {{ $retour->quantite }}</div>
      <div><span style="color:var(--muted)">Motif :</span> {{ $retour->motif }}</div>
      @if($retour->description)
        <div><span style="color:var(--muted)">Description :</span> {{ $retour->description }}</div>
      @endif
      <div><span style="color:var(--muted)">Date :</span> {{ $retour->created_at->format('d/m/Y à H:i') }}</div>
      @if($retour->note_admin)
        <div style="margin-top:10px;padding:10px;background:rgba(255,107,53,.06);border:1px solid rgba(255,107,53,.15);border-radius:8px">
          <span style="color:var(--orange);font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:.06em">Note admin</span><br>
          {{ $retour->note_admin }}
        </div>
      @endif
    </div>
  </div>

  {{-- INFO VENDEUR --}}
  <div class="card">
    <div class="card-head"><span class="card-title">Vendeur concerné</span></div>
    <div class="card-body" style="font-size:13px;color:var(--text);line-height:1.8">
      @php $vendeur = $retour->produit?->vendeur; @endphp
      @if($vendeur)
        <div><span style="color:var(--muted)">Nom :</span> <strong>{{ $vendeur->nom }}</strong></div>
        <div><span style="color:var(--muted)">Email :</span> {{ $vendeur->email }}</div>
        <div><span style="color:var(--muted)">Téléphone :</span> {{ $vendeur->telephone ?? '—' }}</div>
        @if($vendeur->boutique)
          <div><span style="color:var(--muted)">Boutique :</span> {{ $vendeur->boutique->nom }}</div>
        @endif
      @else
        <p style="color:var(--muted)">Vendeur introuvable.</p>
      @endif
    </div>
  </div>
</div>

{{-- ACTIONS ADMIN --}}
@if($retour->statut === 'en_attente' || $retour->statut === 'vendeur_contacte')
<div class="card" style="margin-bottom:18px">
  <div class="card-head"><span class="card-title">Actions</span></div>
  <div class="card-body">
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px">
      {{-- CONTACTER VENDEUR --}}
      @if($retour->statut === 'en_attente')
        <form action="{{ route('admin.returns.contact', $retour) }}" method="POST" style="display:flex;gap:8px;align-items:flex-end;flex:1;min-width:280px">
          @csrf
          <div style="flex:1">
            <label style="font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;display:block">Note pour le dossier (optionnel)</label>
            <textarea name="note_admin" rows="2" style="width:100%;background:var(--bg3);border:1px solid var(--border);border-radius:var(--radius-xs);padding:8px 12px;color:var(--white);font-family:'Inter',sans-serif;font-size:13px;outline:none;resize:none" placeholder="Ex : contacter le vendeur par téléphone au sujet du produit défectueux…">{{ $retour->note_admin }}</textarea>
          </div>
          <button type="submit" class="btn-primary" style="white-space:nowrap;flex-shrink:0"><i class="fa-solid fa-phone"></i> Contacter le vendeur</button>
        </form>
      @endif
    </div>

    <div style="display:flex;gap:10px;flex-wrap:wrap">
      {{-- ACCEPTER --}}
      <form action="{{ route('admin.returns.accept', $retour) }}" method="POST" onsubmit="return confirm('Accepter ce retour ? Le stock sera restauré.')">
        @csrf
        <button type="submit" class="btn-primary btn-success"><i class="fa-solid fa-check"></i> Accepter le retour</button>
      </form>

      {{-- REFUSER --}}
      <form action="{{ route('admin.returns.reject', $retour) }}" method="POST" onsubmit="return confirm('Refuser ce retour ?')">
        @csrf
        <input type="hidden" name="note_admin" value="{{ $retour->note_admin }}">
        <button type="submit" class="btn-primary btn-danger"><i class="fa-solid fa-xmark"></i> Refuser</button>
      </form>
    </div>
  </div>
</div>
@endif

{{-- ARTICLES DE LA COMMANDE --}}
<div class="card">
  <div class="card-head"><span class="card-title">Articles de la commande #{{ $retour->commande_id }}</span></div>
  <div class="card-body" style="padding:0">
    <table class="table">
      <thead><tr><th>Produit</th><th>Prix</th><th>Qté</th><th>Total</th></tr></thead>
      <tbody>
        @foreach($retour->commande->details as $d)
          <tr @if($d->produit_id === $retour->produit_id) style="background:rgba(255,107,53,.04)" @endif>
            <td>{{ $d->produit->nom ?? '—' }} @if($d->produit_id === $retour->produit_id) <span style="color:var(--orange);font-size:10px;font-weight:700">← RETOUR</span> @endif</td>
            <td>{{ money_fdj($d->prix_unitaire) }}</td>
            <td>{{ $d->quantite }}</td>
            <td>{{ money_fdj($d->prix_unitaire * $d->quantite) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
