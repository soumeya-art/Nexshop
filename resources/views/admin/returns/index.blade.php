@extends('admin.returns.layout')

@section('returns-content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
  <div>
    <h1 class="page-title">Demandes de retour</h1>
    <p class="page-sub">Gérez les demandes de retour des acheteurs — contactez le vendeur concerné.</p>
  </div>
  @if($pendingCount > 0)
    <span style="background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.25);color:#F59E0B;padding:6px 14px;border-radius:50px;font-size:12px;font-weight:700;font-family:'Space Grotesk',sans-serif">{{ $pendingCount }} en attente</span>
  @endif
</div>

@if(session('success'))
  <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
@endif

@if($returns->isEmpty())
  <div style="text-align:center;padding:60px 20px;color:var(--muted)">
    <i class="fa-solid fa-rotate-left" style="font-size:40px;opacity:.3;margin-bottom:16px;display:block"></i>
    <p>Aucune demande de retour pour le moment.</p>
  </div>
@else
  <div class="card">
    <div class="card-body" style="padding:0">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Client</th>
            <th>Produit</th>
            <th>Vendeur</th>
            <th>Motif</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($returns as $r)
            <tr>
              <td>{{ $r->id }}</td>
              <td>{{ $r->client->nom ?? '—' }}</td>
              <td>{{ Str::limit($r->produit->nom ?? '—', 30) }}</td>
              <td>{{ $r->produit?->vendeur?->nom ?? '—' }}</td>
              <td>{{ Str::limit($r->motif, 25) }}</td>
              <td>
                @switch($r->statut)
                  @case('en_attente') <span class="status-badge" style="background:rgba(245,158,11,.1);color:#F59E0B;border:1px solid rgba(245,158,11,.2)">En attente</span> @break
                  @case('vendeur_contacte') <span class="status-badge" style="background:rgba(30,144,255,.1);color:#1E90FF;border:1px solid rgba(30,144,255,.2)">Vendeur contacté</span> @break
                  @case('acceptee') <span class="status-badge actif">Acceptée</span> @break
                  @case('refusee') <span class="status-badge banni">Refusée</span> @break
                @endswitch
              </td>
              <td style="font-size:11px;color:var(--muted)">{{ $r->created_at->format('d/m/Y') }}</td>
              <td>
                <a href="{{ route('admin.returns.show', $r) }}" class="tbl-btn" title="Voir"><i class="fa-solid fa-eye"></i></a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @if($returns->hasPages())
      <div class="table-foot">
        <span>{{ $returns->total() }} demande(s)</span>
        <div class="pag">
          @foreach($returns->getUrlRange(1, $returns->lastPage()) as $num => $url)
            <a href="{{ $url }}" class="{{ $returns->currentPage() == $num ? '' : '' }}" @if($returns->currentPage() == $num) style="background:var(--orange);border-color:var(--orange);color:#fff" @endif>{{ $num }}</a>
          @endforeach
        </div>
      </div>
    @endif
  </div>
@endif
@endsection
