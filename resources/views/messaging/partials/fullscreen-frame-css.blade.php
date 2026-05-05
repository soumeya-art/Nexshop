:root{--bg:#08080a;--orange:#FF6B35}
:root[data-theme='light']{--bg:#f5f7fb}
:root[data-theme='light'] body{color:#0f172a}
:root[data-theme='light'] .msg-backbar .btn-back-dashboard{border-color:rgba(15,23,42,.12);background:#fff;color:#334155}
:root[data-theme='light'] .msg-backbar-aside.msg-backbar-shop{color:#0f172a}
:root[data-theme='light'] .msg-backbar-buyer-actions a{color:#0f172a}
:root[data-theme='light'] .msg-backbar-buyer-actions .nex-tag{color:#0f172a}
:root[data-theme='light'] .msg-backbar-buyer-actions .nex-tag span{color:#FF6B35}
*{box-sizing:border-box}
html,body.msg-chat-fullscreen{height:100%}
body{margin:0;background:var(--bg);color:#F4F4F5;font-family:Inter,system-ui,sans-serif}
body.msg-chat-fullscreen{display:flex;flex-direction:column;min-height:100vh;max-height:100vh;overflow:hidden}
.msg-backbar{flex-shrink:0;display:flex;align-items:center;gap:10px;padding:10px 14px;background:rgba(8,8,10,.97);border-bottom:1px solid rgba(255,255,255,.07);z-index:50}
.msg-backbar .btn-back-dashboard{display:inline-flex;align-items:center;gap:10px;padding:10px 16px;border-radius:12px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.04);color:#e5e7eb;font-size:14px;font-weight:600;font-family:'Space Grotesk',sans-serif;text-decoration:none;transition:background .15s,border-color .15s,color .15s}
.msg-backbar .btn-back-dashboard:hover{border-color:rgba(255,107,53,.35);color:#FF6B35;background:rgba(255,107,53,.1)}
.msg-backbar-aside{margin-left:auto;display:inline-flex;align-items:center;gap:12px;font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:800;color:#fff;text-decoration:none;letter-spacing:-0.03em;text-align:right;max-width:55%}
.msg-backbar-shop-logo{width:40px;height:40px;border-radius:11px;object-fit:cover;border:1px solid rgba(255,107,53,.35);flex-shrink:0;background:rgba(255,255,255,.05)}
.msg-backbar-shop-fallback{width:40px;height:40px;border-radius:11px;background:linear-gradient(145deg,rgba(255,107,53,.35),rgba(255,107,53,.08));border:1px solid rgba(255,107,53,.35);display:flex;align-items:center;justify-content:center;color:#FF6B35;font-size:17px;flex-shrink:0}
.msg-backbar-shop-name{font-size:16px;line-height:1.2;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.msg-backbar-buyer-actions{display:flex;align-items:center;gap:14px;font-size:13px;font-weight:600;color:#e5e7eb}
.msg-backbar-buyer-actions a{display:inline-flex;align-items:center;gap:6px;color:inherit;text-decoration:none;padding:8px 12px;border-radius:10px;border:1px solid rgba(255,255,255,.1);transition:border-color .15s,color .15s;background:rgba(255,255,255,.04)}
.msg-backbar-buyer-actions a:hover{border-color:rgba(255,107,53,.35);color:#FF6B35}
.msg-backbar-buyer-actions .nex-tag{font-weight:800;letter-spacing:-0.02em;color:#fff}
.msg-backbar-buyer-actions .nex-tag span{color:var(--orange)}
.msg-app-page.nx-msg-full{flex:1;display:flex;flex-direction:column;min-height:0;margin:0;max-width:none;padding:0}
body.msg-chat-fullscreen .nx-msg-full.nx-messaging{flex:1;min-height:0;display:flex;flex-direction:column;padding:0}
body.msg-chat-fullscreen .nx-msg-full.nx-messaging .msg-layout{flex:1;min-height:0!important;max-height:none!important;border-radius:0;border:none;box-shadow:none}
@supports(min-height:100dvh){body.msg-chat-fullscreen{min-height:100dvh;max-height:100dvh}}
@media(max-width:600px){
.msg-backbar{flex-wrap:wrap;padding:8px 10px;gap:8px;padding-top:calc(8px + env(safe-area-inset-top,0px))}
.msg-backbar .btn-back-dashboard{font-size:12px;padding:9px 12px}
.msg-backbar-aside{margin-left:0;width:100%;justify-content:flex-end;text-align:right;max-width:none}
.msg-backbar-shop-name{font-size:14px}
.msg-backbar-buyer-actions{flex-wrap:wrap;justify-content:flex-end;width:100%}
}
@include('messaging.skin')
