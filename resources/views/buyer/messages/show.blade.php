<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="messaging-heartbeat-url" content="{{ route('messaging.heartbeat') }}">
<meta name="messaging-unread-url" content="{{ route('messaging.unread') }}">
@include('partials.theme-init')
<title>Discussion avec {{ $other?->nom }} — NexShop</title>
@php
  $__lastListedMsgBuyer = collect($messages)->last();
  $__preloadMessagingImgBuyer = $__lastListedMsgBuyer && $__lastListedMsgBuyer->attachment_path
    ? $__lastListedMsgBuyer->attachmentUrl()
    : null;
@endphp
@if($__preloadMessagingImgBuyer)<link rel="preload" href="{{ $__preloadMessagingImgBuyer }}" as="image" fetchpriority="high">@endif
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>@include('messaging.partials.fullscreen-frame-css')</style>
@include('partials.theme-manager')
</head>
<body class="msg-chat-fullscreen nx-msg-mobile--buyer-chat">
<header class="msg-backbar">
  <a href="{{ route('buyer.home') }}" class="btn-back-dashboard"><i class="fa-solid fa-arrow-left"></i> Explorer les produits</a>
  <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
  <div class="msg-backbar-aside msg-backbar-buyer-actions">
    <a href="{{ route('buyer.messages.index') }}"><i class="fa-solid fa-comments"></i> Conversations</a>
    <a href="{{ route('buyer.stores.show', $other->id) }}"><i class="fa-solid fa-store"></i> Boutique</a>
  </div>
</header>

@php $__msgListCount = isset($messages) ? count($messages) : 0; @endphp
<div class="msg-app-page nx-messaging nx-msg-full nx-messaging--edge">
  <div class="msg-layout">
    <div class="msg-list-col">
      <div class="msg-list-header">
        <label>Conversations</label>
        <div class="msg-search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" class="msg-search" id="nx-conv-filter" placeholder="Rechercher…" autocomplete="off">
        </div>
      </div>
      <div class="msg-list">
        @foreach($conversations as $c)
          @php $o = $c->otherParty(auth()->user()); @endphp
          <a href="{{ route('buyer.messages.show', $c) }}" class="msg-list-item {{ $c->id === $conversation->id ? 'active' : '' }}" data-filter-name="{{ mb_strtolower($o?->nom ?? '') }}">
            <div class="msg-avatar-wrap">
              <img class="msg-avatar" src="https://ui-avatars.com/api/?name={{ urlencode($o?->nom ?? '?') }}&background=FF6B35&color=fff&size=96" alt="">
            </div>
            <div class="msg-list-body">
              <div class="msg-list-name">{{ $o?->nom }}</div>
              <div class="msg-list-preview">
                @if($c->latestMessage?->attachment_path)
                  <span class="msg-list-photo-preview">
                    <img src="{{ $c->latestMessage->attachmentUrl() }}" alt="" width="40" height="40" loading="lazy" decoding="async">
                    <span class="msg-list-photo-label"><i class="fa-solid fa-camera" aria-hidden="true"></i> Photo</span>
                  </span>
                @else
                  {{ \Illuminate\Support\Str::limit($c->latestMessage?->body ?? '…', 40) }}
                @endif
              </div>
            </div>
            <div class="msg-list-meta">
              @if($c->last_message_at)
                <span class="msg-list-time">{{ $c->last_message_at->diffForHumans(short: true) }}</span>
              @endif
              @if(($c->unread_count ?? 0) > 0 && $c->id !== $conversation->id)
                <span class="msg-unread-badge">{{ $c->unread_count > 9 ? '9+' : $c->unread_count }}</span>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    </div>

    <div class="msg-thread">
      <div class="msg-thread-head">
        <a href="{{ route('buyer.messages.index') }}" class="msg-thread-mobile-back" aria-label="Retour aux conversations"><i class="fa-solid fa-arrow-left"></i></a>
        <div class="msg-avatar-wrap">
          <img class="msg-avatar" src="https://ui-avatars.com/api/?name={{ urlencode($other?->nom ?? '?') }}&background=FF6B35&color=fff&size=96" alt="">
        </div>
        <div style="flex:1;min-width:0">
          <h2>{{ $other?->nom }}</h2>
          <div class="msg-thread-meta">
            <span id="chat-online-status" class="online-dot {{ $other?->isOnline() ? 'is-online' : '' }}"></span>
            <span>{{ $other?->isOnline() ? 'En ligne' : 'Hors ligne' }}</span>
          </div>
        </div>
      </div>

      <div id="chat-messages" class="msg-scroll">
        @foreach($messages as $m)
          @php
            $mine = $m->sender_id === auth()->id();
            $hasAtt = (bool) $m->attachment_path;
            $hasBody = filled($m->body);
            $imgDefer = $hasAtt && ($__msgListCount > 6 && $loop->iteration <= $__msgListCount - 6);
            $bubbleExtra = '';
            if ($hasAtt && ! $hasBody) {
                $bubbleExtra = ' msg-bubble--media-only';
            } elseif ($hasAtt && $hasBody) {
                $bubbleExtra = ' msg-bubble--caption-media';
            }
          @endphp
          <div id="msg-{{ $m->id }}" class="msg-row {{ $mine ? 'msg-mine' : 'msg-theirs' }}">
            <div class="msg-bubble{{ $bubbleExtra }}">
              @if($hasBody)<p>{{ $m->body }}</p>@endif
              @if($hasAtt)
                <a href="{{ $m->attachmentUrl() }}" target="_blank" rel="noopener noreferrer" class="msg-media{{ $hasBody ? ' msg-media--bare' : '' }}" title="Ouvrir l’image en grand">
                  <img class="msg-attachment" src="{{ $m->attachmentUrl() }}" alt=""
                    decoding="async"
                    loading="{{ $imgDefer ? 'lazy' : 'eager' }}"
                    @if($hasAtt && $loop->last) fetchpriority="high" @endif>
                  @if(! $hasBody)
                    <div class="msg-media-meta">
                      <span class="msg-time">{{ $m->created_at->format('H:i') }}</span>
                      @if($mine)
                        <span class="msg-read">
                          @if($m->read_at)
                            <i class="fa-solid fa-check-double" style="color:#87cff8"></i>
                          @else
                            <i class="fa-solid fa-check"></i>
                          @endif
                        </span>
                      @endif
                    </div>
                  @endif
                </a>
              @endif
              @if(! $hasAtt || $hasBody)
                <div class="msg-meta">
                  <span class="msg-time">{{ $m->created_at->format('H:i') }}</span>
                  @if($mine)
                    <span class="msg-read">
                      @if($m->read_at)
                        <i class="fa-solid fa-check-double" style="color:#5DB7FF"></i>
                      @else
                        <i class="fa-solid fa-check"></i>
                      @endif
                    </span>
                  @endif
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
      <div id="chat-typing" class="msg-typing" style="display:none"></div>

      <div class="msg-form-wrap">
        <div id="nx-chat-attach-preview" class="nx-chat-attach-preview" hidden></div>
        <form id="chat-form" action="{{ route('buyer.messages.send', $conversation) }}" method="post" enctype="multipart/form-data" class="msg-form">
          @csrf
          <label class="btn-attach" for="nx-chat-file" title="Ajouter une image"><i class="fa-solid fa-image"></i></label>
          <input id="nx-chat-file" class="nx-msg-file-input" type="file" name="attachment" accept="image/jpeg,image/png,image/gif,image/webp">
          <textarea id="chat-input" name="body" rows="1" placeholder="Écrivez un message ou envoyez une image…"></textarea>
          <button type="submit" class="btn-send"><i class="fa-solid fa-paper-plane"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>

@php
  $messagingConfig = [
    'conversationId' => $conversation->id,
    'currentUserId' => auth()->id(),
    'currentUserName' => auth()->user()->nom,
    'otherUserId' => $other->id,
    'markReadUrl' => route('buyer.messages.read', $conversation),
  ];
@endphp
<script>
window.NEXSHOP_MESSAGING = @json($messagingConfig);
document.getElementById('chat-messages')?.scrollTo(0, 999999);
</script>
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
