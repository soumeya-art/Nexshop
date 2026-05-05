<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="messaging-heartbeat-url" content="{{ route('messaging.heartbeat') }}">
<meta name="messaging-unread-url" content="{{ route('messaging.unread') }}">
@include('partials.theme-init')
<title>Messages — NexShop</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>@include('messaging.partials.fullscreen-frame-css')</style>
@include('partials.theme-manager')
</head>
<body class="msg-chat-fullscreen nx-msg-mobile--buyer-index">
<header class="msg-backbar">
  <a href="{{ route('buyer.home') }}" class="btn-back-dashboard"><i class="fa-solid fa-arrow-left"></i> Explorer les produits</a>
  <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
  <div class="msg-backbar-aside msg-backbar-buyer-actions">
    <span class="nex-tag">Nex<span>Shop</span></span>
  </div>
</header>

<div class="msg-app-page nx-messaging nx-msg-full nx-messaging--edge">
  <div class="msg-layout">
    <div class="msg-list-col">
      <div class="msg-list-header">
        <label>Conversations</label>
        <div class="msg-search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" class="msg-search" id="nx-conv-filter" placeholder="Rechercher un vendeur…" autocomplete="off">
        </div>
      </div>
      <div class="msg-list">
        @forelse($conversations as $c)
          @php $other = $c->otherParty(auth()->user()); @endphp
          <a href="{{ route('buyer.messages.show', $c) }}" class="msg-list-item" data-filter-name="{{ mb_strtolower($other?->nom ?? '') }}">
            <div class="msg-avatar-wrap">
              <img class="msg-avatar" src="https://ui-avatars.com/api/?name={{ urlencode($other?->nom ?? '?') }}&background=FF6B35&color=fff&size=96" alt="">
            </div>
            <div class="msg-list-body">
              <div class="msg-list-name">{{ $other?->nom ?? 'Utilisateur' }}</div>
              <div class="msg-list-preview">
                @if($c->latestMessage?->attachment_path)
                  <span class="msg-list-photo-preview">
                    <img src="{{ $c->latestMessage->attachmentUrl() }}" alt="" width="40" height="40" loading="lazy" decoding="async">
                    <span class="msg-list-photo-label"><i class="fa-solid fa-camera" aria-hidden="true"></i> Photo</span>
                  </span>
                @else
                  {{ \Illuminate\Support\Str::limit($c->latestMessage?->body ?? 'Nouvelle conversation', 48) }}
                @endif
              </div>
            </div>
            <div class="msg-list-meta">
              @if($c->last_message_at)
                <span class="msg-list-time">{{ $c->last_message_at->diffForHumans(short: true) }}</span>
              @endif
              @if(($c->unread_count ?? 0) > 0)
                <span class="msg-unread-badge">{{ $c->unread_count > 9 ? '9+' : $c->unread_count }}</span>
              @endif
            </div>
          </a>
        @empty
          <div class="msg-pane-empty-inner">
            <i class="fa-regular fa-inbox"></i>
            <div class="msg-list-name" style="margin-top:8px">Aucune conversation</div>
            <p style="font-size:13px;color:var(--msg-muted);margin:8px auto 0;max-width:260px;line-height:1.45;text-align:center">Ouvrez une fiche produit et utilisez <strong style="color:var(--msg-orange)">Contacter le vendeur</strong>.</p>
          </div>
        @endforelse
      </div>
    </div>
    <div class="msg-pane-empty">
      <div class="msg-pane-empty-visual"><i class="fa-regular fa-comments"></i></div>
      <h3>Sélectionnez une conversation</h3>
      <p>Ou commencez depuis une boutique ou une fiche produit.</p>
    </div>
  </div>
</div>

@vite(['resources/js/app.js'])
<script>
(function(){
  var input = document.getElementById('nx-conv-filter');
  if (!input) return;
  input.addEventListener('input', function(){
    var q = (input.value || '').trim().toLowerCase();
    document.querySelectorAll('.msg-list-item[data-filter-name]').forEach(function(el){
      el.style.display = (!q || (el.getAttribute('data-filter-name') || '').includes(q)) ? '' : 'none';
    });
  });
})();
</script>
</body>
</html>
