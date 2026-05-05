{{-- Styles messagerie (inclure dans une balise <style>) — enveloppe .nx-messaging --}}
.nx-messaging {
  --msg-surface: #131316;
  --msg-elevated: #1a1a1f;
  --msg-elevated-2: #222228;
  --msg-border: rgba(255,255,255,.085);
  --msg-border-strong: rgba(255,255,255,.12);
  --msg-orange: #FF6B35;
  --msg-orange-soft: rgba(255,107,53,.12);
  --msg-text: #F4F4F5;
  --msg-muted: #9ca3af;
  --msg-muted2: #6b7280;
  --msg-success: #22C55E;
  --msg-radius: 18px;
  --msg-radius-sm: 12px;
  --msg-shadow: 0 4px 24px rgba(0,0,0,.45), 0 0 0 1px rgba(255,255,255,.04);
  --msg-shadow-lg: 0 20px 50px rgba(0,0,0,.55);
}
:root[data-theme='light'] .nx-messaging {
  --msg-surface: #ffffff;
  --msg-elevated: #f8fafc;
  --msg-elevated-2: #eef2f7;
  --msg-border: rgba(15, 23, 42, .1);
  --msg-border-strong: rgba(15, 23, 42, .16);
  --msg-text: #0f172a;
  --msg-muted: #667085;
  --msg-muted2: #98a2b3;
  --msg-shadow: 0 6px 24px rgba(15,23,42,.08), 0 0 0 1px rgba(15,23,42,.03);
  --msg-shadow-lg: 0 22px 56px rgba(15,23,42,.12);
}
.nx-messaging .msg-page-head {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
  margin-bottom: 22px;
}
.nx-messaging .msg-page-head h1 {
  font-family: 'Space Grotesk', system-ui, sans-serif;
  font-size: 1.65rem;
  font-weight: 800;
  letter-spacing: -0.02em;
  margin: 0 0 4px;
  color: var(--msg-text);
}
.nx-messaging .msg-page-head p {
  margin: 0;
  font-size: 14px;
  color: var(--msg-muted);
  max-width: 420px;
  line-height: 1.45;
}
.nx-messaging .msg-page-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 14px;
  border-radius: 999px;
  background: var(--msg-orange-soft);
  border: 1px solid rgba(255,107,53,.22);
  color: var(--msg-orange);
  font-size: 12px;
  font-weight: 600;
  font-family: 'Space Grotesk', sans-serif;
}
.nx-messaging .msg-layout {
  display: grid;
  grid-template-columns: minmax(260px, 380px) minmax(0, 1fr);
  gap: 0;
  width: 100%;
  max-width: min(1200px, 100%);
  margin-inline: auto;
  min-height: min(70dvh, calc(100dvh - 200px));
  max-height: min(calc(100dvh - 140px), 920px);
  border-radius: var(--msg-radius);
  overflow: hidden;
  background: var(--msg-surface);
  box-shadow: var(--msg-shadow-lg);
  border: 1px solid var(--msg-border);
}
@supports not (min-height: 100dvh) {
  .nx-messaging .msg-layout {
    min-height: min(70vh, calc(100vh - 200px));
    max-height: min(calc(100vh - 140px), 920px);
  }
}
.nx-messaging.nx-messaging--edge .msg-layout {
  max-width: none;
  width: 100%;
  margin-inline: 0;
  border-radius: 0;
  box-shadow: none;
}
body.msg-chat-fullscreen .nx-msg-full.nx-messaging.nx-messaging--edge .msg-layout {
  max-width: none;
  width: 100%;
  margin-inline: 0;
}
.nx-messaging .msg-list-col {
  display: flex;
  flex-direction: column;
  background: linear-gradient(180deg, var(--msg-elevated) 0%, var(--msg-surface) 100%);
  border-right: 1px solid var(--msg-border);
  min-height: 0;
}
.nx-messaging .msg-list-header {
  padding: 16px 16px 12px;
  border-bottom: 1px solid var(--msg-border);
  flex-shrink: 0;
}
.nx-messaging .msg-list-header label {
  display: block;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--msg-muted2);
  margin-bottom: 8px;
  font-family: 'Space Grotesk', sans-serif;
}
.nx-messaging .msg-search-wrap {
  position: relative;
}
.nx-messaging .msg-search-wrap i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--msg-muted2);
  font-size: 13px;
  pointer-events: none;
}
.nx-messaging .msg-search {
  width: 100%;
  padding: 10px 12px 10px 36px;
  border-radius: var(--msg-radius-sm);
  border: 1px solid var(--msg-border);
  background: rgba(0,0,0,.25);
  color: var(--msg-text);
  font-size: 13px;
  outline: none;
  transition: border-color .2s, box-shadow .2s;
}
.nx-messaging .msg-search::placeholder { color: var(--msg-muted2); }
.nx-messaging .msg-search:focus {
  border-color: rgba(255,107,53,.4);
  box-shadow: 0 0 0 3px rgba(255,107,53,.08);
}
.nx-messaging .msg-list {
  flex: 1;
  overflow-y: auto;
  min-height: 0;
}
.nx-messaging .msg-list-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 16px;
  text-decoration: none;
  color: inherit;
  border-bottom: 1px solid rgba(255,255,255,.04);
  transition: background .15s ease, transform .12s ease;
}
.nx-messaging .msg-list-item:hover {
  background: rgba(255,255,255,.04);
}
.nx-messaging .msg-list-item.active {
  background: linear-gradient(90deg, rgba(255,107,53,.1) 0%, transparent 100%);
  border-left: 3px solid var(--msg-orange);
  padding-left: 13px;
}
.nx-messaging .msg-avatar-wrap {
  position: relative;
  flex-shrink: 0;
}
.nx-messaging .msg-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--msg-border-strong);
  box-shadow: 0 4px 12px rgba(0,0,0,.35);
}
.nx-messaging .msg-list-item.active .msg-avatar {
  border-color: rgba(255,107,53,.45);
}
.nx-messaging .msg-list-body { flex: 1; min-width: 0; }
.nx-messaging .msg-list-name {
  font-family: 'Space Grotesk', sans-serif;
  font-weight: 700;
  font-size: 14px;
  color: var(--msg-text);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.nx-messaging .msg-list-preview {
  font-size: 12px;
  color: var(--msg-muted);
  margin-top: 3px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 1.35;
}
.nx-messaging .msg-list-photo-preview {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  max-width: 100%;
}
.nx-messaging .msg-list-photo-preview img {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  object-fit: cover;
  flex-shrink: 0;
  border: 1px solid var(--msg-border);
  background: var(--msg-elevated);
}
.nx-messaging .msg-list-meta {
  text-align: right;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 6px;
}
.nx-messaging .msg-list-time {
  font-size: 11px;
  color: var(--msg-muted2);
}
.nx-messaging .msg-unread-badge {
  min-width: 20px;
  height: 20px;
  padding: 0 6px;
  border-radius: 999px;
  background: var(--msg-orange);
  color: #fff;
  font-size: 11px;
  font-weight: 800;
  font-family: 'Space Grotesk', sans-serif;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.nx-messaging .msg-pane-empty {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 48px 32px;
  text-align: center;
  background:
    radial-gradient(ellipse 80% 60% at 50% -20%, rgba(255,107,53,.08), transparent),
    linear-gradient(180deg, var(--msg-surface) 0%, #0f0f12 100%);
  min-height: 320px;
}
.nx-messaging .msg-pane-empty-visual {
  width: 96px;
  height: 96px;
  border-radius: 50%;
  background: linear-gradient(145deg, rgba(255,107,53,.18), rgba(255,107,53,.03));
  border: 1px solid rgba(255,107,53,.2);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  box-shadow: 0 12px 40px rgba(255,107,53,.12);
}
.nx-messaging .msg-pane-empty-visual i {
  font-size: 36px;
  color: var(--msg-orange);
  opacity: .9;
}
.nx-messaging .msg-pane-empty h3 {
  font-family: 'Space Grotesk', sans-serif;
  font-size: 17px;
  font-weight: 700;
  margin: 0 0 8px;
  color: var(--msg-text);
}
.nx-messaging .msg-pane-empty p {
  margin: 0;
  font-size: 14px;
  color: var(--msg-muted);
  max-width: 280px;
  line-height: 1.5;
}
.nx-messaging .msg-list .msg-pane-empty-inner {
  padding: 36px 20px;
  text-align: center;
}
.nx-messaging .msg-list .msg-pane-empty-inner i {
  font-size: 32px;
  color: var(--msg-muted2);
  margin-bottom: 12px;
  opacity: .7;
}
.nx-messaging .msg-thread {
  display: flex;
  flex-direction: column;
  min-height: 0;
  background: var(--msg-surface);
}
.nx-messaging .msg-thread-head {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px 20px;
  border-bottom: 1px solid var(--msg-border);
  background: rgba(26,26,31,.94);
  backdrop-filter: blur(16px) saturate(1.15);
  flex-shrink: 0;
  position: sticky;
  top: 0;
  z-index: 6;
}
:root[data-theme='light'] .nx-messaging .msg-thread-head {
  background: rgba(255,255,255,.93);
}
.nx-messaging .msg-thread-head h2 {
  font-size: 16px;
  font-family: 'Space Grotesk', sans-serif;
  font-weight: 800;
  margin: 0 0 4px;
  letter-spacing: -0.02em;
}
.nx-messaging .msg-thread-meta {
  font-size: 12px;
  color: var(--msg-muted);
  display: flex;
  align-items: center;
  gap: 6px;
}
.nx-messaging .online-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: var(--msg-muted2);
  transition: background .2s, box-shadow .2s;
}
.nx-messaging .online-dot.is-online {
  background: var(--msg-success);
  box-shadow: 0 0 0 3px rgba(34,197,94,.22);
}
.nx-messaging .msg-scroll {
  flex: 1;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  padding: clamp(14px, 2.5vw, 22px) clamp(12px, 2.5vw, 20px);
  display: flex;
  flex-direction: column;
  gap: 12px;
  background-color: #0b0b0e;
  background-image:
    radial-gradient(ellipse 100% 140% at 0% 110%, rgba(255, 107, 53, 0.07), transparent 52%),
    radial-gradient(ellipse 90% 100% at 100% -5%, rgba(99, 102, 241, 0.045), transparent 48%),
    radial-gradient(ellipse 70% 80% at 50% 45%, rgba(255, 255, 255, 0.022), transparent 55%),
    linear-gradient(165deg, #08080c 0%, #101014 38%, #15151a 72%, var(--msg-surface) 100%);
  background-attachment: local;
  min-height: 0;
}
:root[data-theme='light'] .nx-messaging .msg-scroll {
  background-color: #ebe4db;
  background-image:
    radial-gradient(ellipse 100% 130% at 0% 105%, rgba(255, 107, 53, 0.072), transparent 50%),
    radial-gradient(ellipse 85% 90% at 100% 0%, rgba(124, 58, 237, 0.04), transparent 45%),
    radial-gradient(ellipse 80% 70% at 50% 55%, rgba(255, 255, 255, 0.85), transparent 60%),
    linear-gradient(172deg, #e8e2d8 0%, #efe8e0 42%, #ebe4db 100%);
}
.nx-messaging .msg-row { display: flex; width: 100%; }
.nx-messaging .msg-row.msg-mine { justify-content: flex-end; }
.nx-messaging .msg-bubble {
  max-width: 82%;
  padding: 12px 16px;
  border-radius: 18px;
  font-size: 14px;
  line-height: 1.45;
  box-shadow: 0 2px 12px rgba(0,0,0,.2);
}
.nx-messaging .msg-bubble.msg-bubble--media-only {
  padding: 3px;
  max-width: min(82%, 340px);
  overflow: hidden;
}
.nx-messaging .msg-bubble.msg-bubble--caption-media {
  padding: 12px 16px 11px;
  max-width: min(82%, 340px);
}
.nx-messaging .msg-bubble.msg-bubble--caption-media p {
  margin-bottom: 6px;
}
.nx-messaging .msg-theirs .msg-bubble {
  background: var(--msg-elevated-2);
  border: 1px solid var(--msg-border);
  border-bottom-left-radius: 5px;
}
.nx-messaging .msg-mine .msg-bubble {
  background: linear-gradient(160deg, rgba(255,107,53,.25) 0%, rgba(255,107,53,.1) 100%);
  border: 1px solid rgba(255,107,53,.32);
  border-bottom-right-radius: 5px;
}
/* Style type WhatsApp (vert clair envoyé / blanc reçu) pour les messages image seuls */
.nx-messaging .msg-theirs .msg-bubble.msg-bubble--media-only {
  background: #1e2428;
  border-color: rgba(255,255,255,.08);
}
.nx-messaging .msg-mine .msg-bubble.msg-bubble--media-only {
  background: linear-gradient(180deg, #0c4a3e 0%, #053d32 100%);
  border-color: rgba(52,211,153,.35);
}
:root[data-theme='light'] .nx-messaging .msg-theirs .msg-bubble.msg-bubble--media-only {
  background: #fff;
  border-color: rgba(15, 23, 42, .12);
}
:root[data-theme='light'] .nx-messaging .msg-mine .msg-bubble.msg-bubble--media-only {
  background: #d9fdd3;
  border-color: rgba(34, 197, 94, .35);
}
.nx-messaging .msg-bubble p { margin: 0; white-space: pre-wrap; word-break: break-word; }
.nx-messaging .msg-media {
  position: relative;
  display: block;
  line-height: 0;
  border-radius: calc(var(--msg-radius) - 4px);
  overflow: hidden;
  text-decoration: none;
}
/* Réserve l’espace tant que les dimensions pixel ne sont pas connues — évite bulles à hauteur 0 et image « invisible » */
.nx-messaging .msg-media:has(> img.msg-attachment) {
  min-height: clamp(120px, 30vw, 240px);
  width: 100%;
  box-sizing: border-box;
  background: rgba(0, 0, 0, 0.18);
}
:root[data-theme='light'] .nx-messaging .msg-media:has(> img.msg-attachment) {
  background: rgba(15, 23, 42, 0.06);
}
.nx-messaging .msg-bubble--media-only .msg-media {
  border-radius: calc(18px - 3px);
}
.nx-messaging .msg-media:focus-visible {
  outline: 2px solid var(--msg-orange);
  outline-offset: 2px;
}
@keyframes nx-msg-media-pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.45; }
}
.nx-messaging .msg-media.msg-media--waiting::before {
  content: '';
  position: absolute;
  inset: 0;
  z-index: 3;
  border-radius: inherit;
  pointer-events: none;
  background: linear-gradient(
    125deg,
    rgba(255, 255, 255, 0.04) 0%,
    rgba(255, 255, 255, 0.1) 42%,
    rgba(255, 255, 255, 0.05) 58%,
    rgba(255, 255, 255, 0.03) 100%
  );
  background-size: 180% 180%;
  animation: nx-msg-media-pulse 1.15s ease-in-out infinite;
}
:root[data-theme='light'] .nx-messaging .msg-media.msg-media--waiting::before {
  background: linear-gradient(
    125deg,
    rgba(15, 23, 42, 0.04) 0%,
    rgba(15, 23, 42, 0.08) 50%,
    rgba(15, 23, 42, 0.04) 100%
  );
  background-size: 180% 180%;
}
.nx-messaging .msg-media.msg-media--waiting .msg-attachment {
  opacity: 0;
}
.nx-messaging .msg-media:not(.msg-media--waiting) .msg-attachment,
.nx-messaging .msg-media .msg-attachment.msg-attachment--loaded {
  opacity: 1;
}
.nx-messaging .msg-media .msg-attachment {
  transition: opacity 0.45s ease;
  position: relative;
  z-index: 1;
}
.nx-messaging .msg-media.msg-media--error {
  min-height: 120px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(239, 68, 68, 0.1) !important;
}
.nx-messaging .msg-media.msg-media--error::after {
  display: none;
}
.nx-messaging .msg-media--bare {
  margin-top: 6px;
  border-radius: 14px;
}
.nx-messaging .msg-bubble--caption-media .msg-media--bare:first-of-type {
  margin-top: 0;
}
.nx-messaging .msg-media::after {
  content: '';
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  height: 48%;
  z-index: 2;
  background: linear-gradient(to top, rgba(0,0,0,.55) 0%, rgba(0,0,0,.12) 45%, transparent 100%);
  pointer-events: none;
  border-radius: 0 0 calc(var(--msg-radius) - 5px) calc(var(--msg-radius) - 5px);
  opacity: 0;
}
.nx-messaging .msg-bubble--media-only .msg-media:not(.msg-media--bare)::after {
  opacity: 1;
}
.nx-messaging .msg-media-meta {
  position: absolute;
  right: 8px;
  bottom: 6px;
  z-index: 5;
  display: inline-flex;
  align-items: center;
  justify-content: flex-end;
  gap: 6px;
  font-size: 11px;
  font-weight: 500;
  line-height: 1;
  color: rgba(255,255,255,.95);
  text-shadow:
    0 1px 2px rgba(0,0,0,.85),
    0 0 12px rgba(0,0,0,.65);
  pointer-events: none;
}
.nx-messaging .msg-media-meta .msg-read i {
  filter: drop-shadow(0 1px 2px rgba(0,0,0,.85));
}
.nx-messaging .msg-bubble.msg-bubble--media-only.msg-mine .msg-media-meta .msg-read .fa-check-double {
  color: #87cff8 !important;
}
.nx-messaging .msg-attachment {
  display: block;
  width: auto;
  max-width: min(100%, 320px);
  max-height: 320px;
  height: auto;
  border-radius: 0;
  margin: 0;
  vertical-align: bottom;
  object-fit: contain;
  background: rgba(0, 0, 0, .35);
}
.nx-messaging .msg-bubble--media-only .msg-attachment {
  width: 100%;
  max-width: none;
}
.nx-messaging .msg-media--bare .msg-attachment {
  background: rgba(0, 0, 0, .15);
}
.nx-messaging .msg-bubble a.msg-attachment-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  margin-top: 8px;
  font-size: 12px;
  color: var(--msg-orange);
  text-decoration: none;
}
.nx-messaging .msg-bubble a.msg-attachment-link:hover {
  text-decoration: underline;
}
.nx-messaging .msg-meta {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 8px;
  margin-top: 8px;
  font-size: 11px;
  color: var(--msg-muted2);
}
.nx-messaging .msg-bubble--caption-media .msg-meta {
  margin-top: 6px;
}
.nx-messaging .msg-typing {
  font-size: 12px;
  color: var(--msg-muted);
  padding: 0 20px 10px;
  min-height: 22px;
  font-style: italic;
}
.nx-messaging .msg-form-wrap {
  border-top: 1px solid var(--msg-border);
  padding: clamp(12px, 2vw, 18px) clamp(14px, 2.5vw, 20px);
  padding-bottom: max(14px, env(safe-area-inset-bottom, 0px));
  background: rgba(20, 20, 24, 0.97);
  backdrop-filter: blur(12px) saturate(1.1);
  flex-shrink: 0;
}
:root[data-theme='light'] .nx-messaging .msg-form-wrap {
  background: rgba(255, 255, 255, 0.96);
}
.nx-messaging .nx-chat-attach-preview {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 12px;
  padding: 10px 12px;
  border-radius: var(--msg-radius-sm);
  background: rgba(0, 0, 0, .22);
  border: 1px dashed var(--msg-border-strong);
}
.nx-messaging .nx-chat-attach-preview[hidden] {
  display: none !important;
}
.nx-messaging .nx-chat-attach-preview img {
  max-height: 72px;
  max-width: 120px;
  border-radius: 8px;
  object-fit: cover;
  border: 1px solid var(--msg-border);
}
.nx-messaging .nx-chat-attach-preview .nx-chat-attach-meta {
  font-size: 12px;
  color: var(--msg-muted);
  flex: 1;
  min-width: 0;
  word-break: break-all;
}
.nx-messaging .nx-chat-attach-remove {
  border: none;
  background: rgba(239, 68, 68, .18);
  color: #f87171;
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  font-family: 'Space Grotesk', sans-serif;
}
.nx-messaging .nx-chat-attach-remove:hover {
  background: rgba(239, 68, 68, .28);
}
.nx-messaging .msg-form .nx-msg-file-input {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}
.nx-messaging .msg-form {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: flex-end;
}
.nx-messaging .msg-form textarea {
  flex: 1 1 180px;
  min-width: 0;
  min-height: 48px;
  max-height: 140px;
  background: rgba(0,0,0,.35);
  border: 1px solid var(--msg-border);
  border-radius: var(--msg-radius-sm);
  color: var(--msg-text);
  padding: 12px 14px;
  font-family: inherit;
  font-size: 14px;
  resize: vertical;
  transition: border-color .2s, box-shadow .2s;
}
.nx-messaging .msg-form textarea:focus {
  outline: none;
  border-color: rgba(255,107,53,.35);
  box-shadow: 0 0 0 3px rgba(255,107,53,.07);
}
:root[data-theme='light'] .nx-messaging .msg-form textarea {
  background: rgba(255, 255, 255, 0.95);
  border-color: rgba(15, 23, 42, 0.12);
  color: var(--msg-text);
}
:root[data-theme='light'] .nx-messaging .msg-form .btn-attach {
  background: #fff;
  color: var(--msg-muted2);
}
.nx-messaging .msg-form .btn-attach {
  position: relative;
  flex-shrink: 0;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  padding: 12px 14px;
  border-radius: var(--msg-radius-sm);
  background: var(--msg-elevated);
  border: 1px solid var(--msg-border);
  color: var(--msg-muted);
  transition: border-color .2s, color .2s;
}
.nx-messaging .msg-form .btn-attach:hover {
  border-color: rgba(255,107,53,.35);
  color: var(--msg-orange);
}
.nx-messaging .msg-form .btn-send {
  background: linear-gradient(160deg, #FF7A47 0%, var(--msg-orange) 50%, #E85A28 100%);
  color: #fff;
  border: none;
  padding: 12px 20px;
  border-radius: var(--msg-radius-sm);
  font-weight: 700;
  cursor: pointer;
  font-family: 'Space Grotesk', sans-serif;
  box-shadow: 0 4px 16px rgba(255,107,53,.35);
  transition: transform .12s ease, box-shadow .2s;
}
.nx-messaging .msg-form .btn-send:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 22px rgba(255,107,53,.42);
}
.nx-messaging .msg-btn-outline {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  border-radius: var(--msg-radius-sm);
  border: 1px solid var(--msg-border);
  background: rgba(255,255,255,.03);
  color: var(--msg-text);
  font-size: 12px;
  font-weight: 600;
  text-decoration: none;
  transition: border-color .2s, background .2s;
}
.nx-messaging .msg-btn-outline:hover {
  border-color: rgba(255,107,53,.4);
  color: var(--msg-orange);
}
@media (max-width: 900px) {
  .nx-messaging .msg-layout {
    grid-template-columns: 1fr;
    max-height: none;
    min-height: min(82dvh, calc(100dvh - 160px));
    border-radius: clamp(12px, 3vw, 18px);
  }
  @supports not (min-height: 100dvh) {
    .nx-messaging .msg-layout { min-height: min(82vh, calc(100vh - 160px)); }
  }
  .nx-messaging .msg-pane-empty { display: none; }
  .nx-messaging .msg-list-col {
    max-height: min(40dvh, 360px);
    min-height: 200px;
  }
  .nx-messaging .msg-thread {
    min-height: min(48dvh, 520px);
  }
  @supports not (min-height: 100dvh) {
    .nx-messaging .msg-list-col { max-height: min(40vh, 360px); }
    .nx-messaging .msg-thread { min-height: min(48vh, 520px); }
  }
  .nx-messaging .msg-page-head { flex-direction: column; align-items: stretch; }
  .nx-messaging .msg-page-head h1 { font-size: 1.35rem; }
  .nx-messaging .msg-scroll { padding: clamp(12px, 3vw, 16px); gap: 10px; }
  .nx-messaging .msg-form-wrap { padding: 12px clamp(12px, 3vw, 14px); }
  .nx-messaging .msg-thread-head { padding: 12px 14px; flex-wrap: wrap; }
  .nx-messaging .msg-bubble { max-width: min(94%, 360px); padding: 10px 13px; font-size: 13px; }
  .nx-messaging .msg-form .btn-send { padding: 12px 16px; }
}
@media (max-width: 480px) {
  .nx-messaging .msg-layout { border-radius: 12px; }
  .nx-messaging .msg-list-header { padding: 12px 12px 10px; }
  .nx-messaging .msg-list-item { padding: 12px; gap: 10px; }
  .nx-messaging .msg-avatar { width: 42px; height: 42px; }
  .nx-messaging .msg-form { gap: 8px; }
  .nx-messaging .msg-form .btn-attach { padding: 10px 12px; }
}
/* Mobile master/detail : liste seule puis fil de discussion plein sous-cadre — acheteur & vendeur */
.nx-messaging .msg-thread-mobile-back {
  display: none;
  flex-shrink: 0;
  width: 40px;
  height: 40px;
  align-items: center;
  justify-content: center;
  border-radius: var(--msg-radius-sm);
  border: 1px solid var(--msg-border);
  background: var(--msg-elevated);
  color: var(--msg-muted);
  text-decoration: none;
  transition: border-color .2s, color .2s;
}
.nx-messaging .msg-thread-mobile-back:hover {
  border-color: rgba(255, 107, 53, .35);
  color: var(--msg-orange);
}
@media (max-width: 900px) {
  body.nx-msg-mobile--buyer-index .nx-messaging .msg-layout,
  body.nx-msg-mobile--seller-index .nx-messaging .msg-layout {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    max-height: none;
    border-radius: 0;
  }
  body.nx-msg-mobile--buyer-index .nx-messaging .msg-list-col,
  body.nx-msg-mobile--seller-index .nx-messaging .msg-list-col {
    flex: 1;
    max-height: none;
    min-height: 0;
  }
  body.nx-msg-mobile--buyer-index .nx-messaging .msg-pane-empty,
  body.nx-msg-mobile--seller-index .nx-messaging .msg-pane-empty {
    display: none !important;
  }
  body.nx-msg-mobile--buyer-chat .nx-messaging .msg-list-col,
  body.nx-msg-mobile--seller-chat .nx-messaging .msg-list-col {
    display: none !important;
  }
  body.nx-msg-mobile--buyer-chat .nx-messaging .msg-layout,
  body.nx-msg-mobile--seller-chat .nx-messaging .msg-layout {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-height: 0;
    max-height: none;
    border-radius: 0;
  }
  body.nx-msg-mobile--buyer-chat .nx-messaging .msg-thread,
  body.nx-msg-mobile--seller-chat .nx-messaging .msg-thread {
    flex: 1;
    min-height: 0;
    max-height: none;
  }
  body.nx-msg-mobile--buyer-chat .nx-messaging .msg-thread-mobile-back,
  body.nx-msg-mobile--seller-chat .nx-messaging .msg-thread-mobile-back {
    display: inline-flex;
  }
}
@media (max-width: 480px) {
  body.nx-msg-mobile--buyer-index .nx-messaging .msg-layout,
  body.nx-msg-mobile--seller-index .nx-messaging .msg-layout,
  body.nx-msg-mobile--buyer-chat .nx-messaging .msg-layout,
  body.nx-msg-mobile--seller-chat .nx-messaging .msg-layout {
    border-radius: 0;
  }
}
