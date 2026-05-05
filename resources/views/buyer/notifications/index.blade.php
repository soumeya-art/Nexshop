@extends('buyer.layout')

@section('title', 'Notifications')

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Mes notifications</div>
      <div class="sec-sub">Nouveaux produits des vendeurs suivis et alertes messages</div>
    </div>
  </div>

  @if($chatNotifications->isNotEmpty())
  <div class="sec-title" style="font-size:15px;margin-bottom:10px">Messages</div>
  <div style="display:grid;gap:12px;margin-bottom:28px">
    @foreach($chatNotifications as $cn)
      @php $d = $cn->data; @endphp
      <article style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:14px">
        <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start">
          <div>
            <div style="font-weight:700"><i class="fa-regular fa-comment-dots" style="color:var(--orange);margin-right:6px"></i>{{ $d['sender_name'] ?? 'Message' }}</div>
            <div style="color:var(--muted);font-size:13px;margin-top:4px">{{ $d['preview'] ?? '' }}</div>
            @isset($d['conversation_id'])
              <a href="{{ route('buyer.messages.show', $d['conversation_id']) }}" class="sec-link" style="margin-top:8px;display:inline-flex">Ouvrir la conversation <i class="fa-solid fa-chevron-right"></i></a>
            @endisset
          </div>
          <small style="color:var(--muted)">{{ $cn->created_at?->diffForHumans() }}</small>
        </div>
      </article>
    @endforeach
  </div>
  @endif

  <div class="sec-title" style="font-size:15px;margin-bottom:10px">Produits &amp; boutiques suivis</div>
  <div style="display:grid;gap:12px">
    @forelse($notifications as $n)
      <article style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:14px">
        <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start">
          <div>
            <div style="font-weight:700">{{ $n->titre }}</div>
            <div style="color:var(--muted);font-size:13px;margin-top:4px">{{ $n->message }}</div>
            @if($n->produit)
              <a href="{{ route('buyer.products.show', $n->produit) }}" class="sec-link" style="margin-top:8px;display:inline-flex">Voir le produit <i class="fa-solid fa-chevron-right"></i></a>
            @endif
          </div>
          <small style="color:var(--muted)">{{ $n->created_at?->diffForHumans() }}</small>
        </div>
      </article>
    @empty
      <p style="color:var(--muted)">Aucune notification pour le moment.</p>
    @endforelse
  </div>

  @if($notifications->hasPages())
    <div class="pagination">
      @foreach($notifications->getUrlRange(1, $notifications->lastPage()) as $num => $url)
        <a href="{{ $url }}" class="{{ $notifications->currentPage() == $num ? 'current' : '' }}">{{ $num }}</a>
      @endforeach
    </div>
  @endif
</main>
@endsection
