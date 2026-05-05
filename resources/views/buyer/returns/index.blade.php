@extends('buyer.layout')

@section('title', 'Mes retours')

@push('styles')
<style>
.returns-list{display:flex;flex-direction:column;gap:14px}
.return-card{background:rgba(20,20,20,.85);backdrop-filter:blur(16px);border:1px solid var(--border);border-radius:var(--radius);padding:22px;transition:border-color var(--T)}
.return-card:hover{border-color:rgba(255,107,53,.3)}
.return-head{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;margin-bottom:10px}
.return-head h3{font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:700;color:var(--white)}
.ret-badge{padding:5px 12px;border-radius:50px;font-size:10px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;font-family:'Space Grotesk',sans-serif}
.ret-en_attente{background:rgba(245,158,11,.15);color:#F59E0B;border:1px solid rgba(245,158,11,.25)}
.ret-vendeur_contacte{background:rgba(30,144,255,.15);color:#1E90FF;border:1px solid rgba(30,144,255,.25)}
.ret-acceptee{background:rgba(34,197,94,.15);color:#22C55E;border:1px solid rgba(34,197,94,.25)}
.ret-refusee{background:rgba(239,68,68,.15);color:#EF4444;border:1px solid rgba(239,68,68,.25)}
.return-meta{font-size:13px;color:var(--muted);line-height:1.6}
.return-meta strong{color:var(--text)}
.empty-returns{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-returns p{font-size:15px;margin-bottom:16px}
</style>
@endpush

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Mes demandes de retour</div>
      <div class="sec-sub">Suivez l'état de vos demandes de retour produit.</div>
    </div>
    <a href="{{ route('buyer.orders.index') }}" class="sec-link"><i class="fa-solid fa-arrow-left"></i> Mes commandes</a>
  </div>

  @if(session('success'))
    <div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22C55E;padding:12px 16px;border-radius:var(--radius-xs);margin-bottom:16px;font-size:13px"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#EF4444;padding:12px 16px;border-radius:var(--radius-xs);margin-bottom:16px;font-size:13px"><i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}</div>
  @endif

  @if($returns->isEmpty())
    <div class="empty-returns">
      <p>Aucune demande de retour pour le moment.</p>
      <a href="{{ route('buyer.orders.index') }}" class="btn-primary" style="display:inline-flex">Voir mes commandes</a>
    </div>
  @else
    <div class="returns-list">
      @foreach($returns as $ret)
        <div class="return-card">
          <div class="return-head">
            <h3><i class="fa-solid fa-rotate-left" style="color:var(--orange);margin-right:6px"></i> {{ $ret->produit->nom ?? 'Produit supprimé' }}</h3>
            <span class="ret-badge ret-{{ $ret->statut }}">
              @switch($ret->statut)
                @case('en_attente') En attente @break
                @case('vendeur_contacte') Vendeur contacté @break
                @case('acceptee') Acceptée @break
                @case('refusee') Refusée @break
              @endswitch
            </span>
          </div>
          <div class="return-meta">
            Commande <strong>#{{ $ret->commande_id }}</strong> — Qté : <strong>{{ $ret->quantite }}</strong><br>
            Motif : <strong>{{ $ret->motif }}</strong><br>
            @if($ret->description)
              Détail : {{ $ret->description }}<br>
            @endif
            @if($ret->note_admin)
              <span style="color:var(--orange)">Note admin : {{ $ret->note_admin }}</span><br>
            @endif
            <span style="font-size:11px;color:var(--muted2)">Demandé le {{ $ret->created_at->format('d/m/Y à H:i') }}</span>
          </div>
        </div>
      @endforeach
    </div>

    @if($returns->hasPages())
      <div style="margin-top:20px;display:flex;gap:6px;justify-content:center">
        @foreach($returns->getUrlRange(1, $returns->lastPage()) as $num => $url)
          <a href="{{ $url }}" style="padding:6px 12px;border-radius:8px;background:{{ $returns->currentPage() == $num ? 'var(--orange)' : 'var(--bg3)' }};color:{{ $returns->currentPage() == $num ? '#fff' : 'var(--muted)' }};border:1px solid var(--border);font-size:12px;text-decoration:none">{{ $num }}</a>
        @endforeach
      </div>
    @endif
  @endif
</main>
@endsection
