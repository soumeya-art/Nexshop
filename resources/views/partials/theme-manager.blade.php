{{-- Charger EN DERNIER dans le <head> (après app.css et les <style> de la page). --}}
<style>
:root { color-scheme: dark; }
html[data-theme='light'] { color-scheme: light; }

/* ── Palette partagée (écrase :root imbriqués plus bas lorsque présent sur <html>) ── */
html[data-theme='light'] {
  --bg: #f5f7fb;
  --bg2: #ffffff;
  --bg3: #eef2f9;
  --bg4: #e6ecf4;
  --border: rgba(12, 24, 46, .1);
  --border2: rgba(12, 24, 46, .16);
  --white: #0f172a;
  --text: #0f172a;
  --muted: #5b6473;
  --muted2: #7b8697;
  --orange: #FF6B35;
  --orange2: #FF8C5A;
  --surface: #ffffff;
  --surface2: #f4f7fc;
}

html[data-theme='dark'] {
  --bg: #0D0D0D;
  --bg2: #141414;
  --bg3: #1C1C1C;
  --border: rgba(255,255,255,.08);
  --border2: rgba(255,255,255,.14);
  --white: #FFFFFF;
  --text: #F0F0F0;
  --muted: #888888;
  --muted2: #555555;
}

html[data-theme='light'] body {
  background: var(--bg) !important;
  color: var(--text);
}

.theme-toggle {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  min-height: 36px;
  padding: 6px 12px;
  border-radius: 999px;
  border: 1px solid var(--border, rgba(255,255,255,.14));
  background: var(--bg3, rgba(255,255,255,.06));
  color: var(--text, #f3f4f6);
  font-family: 'Space Grotesk', sans-serif;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .04em;
  text-transform: uppercase;
  cursor: pointer;
  transition: border-color .2s, color .2s, background .2s, box-shadow .2s;
}
.theme-toggle:hover {
  border-color: var(--orange, #FF6B35);
  color: var(--orange, #FF6B35);
  box-shadow: 0 0 0 1px rgba(255,107,53,.2);
}
.theme-toggle:focus-visible {
  outline: 2px solid var(--orange, #FF6B35);
  outline-offset: 2px;
}
.theme-toggle-label { pointer-events: none; }
@media (max-width: 520px) {
  .theme-toggle-label { display: none !important; }
}

/* ── Zone acheteur (buyer/layout) — barres forcées avant variables ── */
html[data-theme='light'] body.buyer-app .navbar,
html[data-theme='light'] body.buyer-app .sub-nav {
  background: rgba(255,255,255,.96) !important;
  backdrop-filter: blur(20px) !important;
  border-bottom-color: var(--border) !important;
}
html[data-theme='light'] body.buyer-app .hero {
  background: linear-gradient(135deg, #eaf1ff 0%, #f5f9ff 42%, var(--bg) 100%) !important;
  border-color: var(--border) !important;
}
html[data-theme='light'] body.buyer-app .hero-title { color: var(--text) !important; }
html[data-theme='light'] body.buyer-app .prod-wish {
  background: rgba(248,250,252,.92) !important;
  backdrop-filter: blur(8px) !important;
  color: var(--muted) !important;
}

/* Footer (app.css : fond #080808 fixe) — accueil + espace acheteur */
html[data-theme='light'] .footer {
  background: #eef1f8 !important;
  border-top: 1px solid var(--border) !important;
}
html[data-theme='dark'] .footer {
  background: #080808 !important;
}

html[data-theme='light'] .contact-form-wrap,
html[data-theme='light'] body.buyer-app .toast {
  background: var(--bg2) !important;
  border-color: var(--border) !important;
  color: var(--text);
}

html[data-theme='light'] .msg-layout {
  border-color: var(--border) !important;
}

/* Commandes acheteur (fonds rgba fixés) */
html[data-theme='light'] .order-card,
html[data-theme='light'] .order-detail-card {
  background: rgba(255,255,255,.96) !important;
  backdrop-filter: blur(12px);
}
html[data-theme='dark'] .order-card,
html[data-theme='dark'] .order-detail-card {
  background: rgba(20,20,20,.85) !important;
}

/* Profil acheteur (cartes) */
html[data-theme='light'] .profile-edit .profile-card-hd {
  background: rgba(255,107,53,.06) !important;
}
html[data-theme='light'] .profile-edit-hero {
  background: linear-gradient(135deg, rgba(255,107,53,.08) 0%, rgba(255,255,255,.95) 50%, var(--bg2) 100%) !important;
  border-color: var(--border) !important;
}
html[data-theme='light'] .profile-edit .profile-field input {
  background: var(--bg3) !important;
  border-color: var(--border) !important;
  color: var(--text);
}

html[data-theme='dark'] .profile-edit-hero .profile-edit-hero-title,
html[data-theme='dark'] .profile-edit .profile-card-title {
  color: var(--text);
}

html[data-theme='dark'] body.buyer-app .navbar,
html[data-theme='dark'] body.buyer-app .sub-nav {
  background: rgba(13,13,13,.96) !important;
  border-bottom-color: var(--border) !important;
}

/* Vendeur / Admin — navbar & sidebar forcées dans les feuilles inline */
html[data-theme='light'] body > nav.navbar {
  background: rgba(255,255,255,.96) !important;
  border-bottom-color: var(--border) !important;
}
html[data-theme='light'] aside.sidebar {
  background: var(--bg2) !important;
  border-color: var(--border) !important;
}
html[data-theme='light'] footer {
  border-color: var(--border) !important;
  background: var(--bg2) !important;
}
html[data-theme='dark'] body > nav.navbar,
html[data-theme='dark'] aside.sidebar {
  background: rgba(13,13,13,.96) !important;
}

/* Nouveau produit vendeur (.seller-product-create sur <body>) */
html[data-theme='light'] body.seller-product-create header.topbar {
  background: rgba(255,255,255,.93) !important;
  border-color: var(--border) !important;
}
html[data-theme='light'] body.seller-product-create .wrap .card {
  border-color: var(--border) !important;
  background: var(--surface) !important;
  box-shadow: 0 4px 24px rgba(15,23,42,.06) !important;
}
html[data-theme='light'] body.seller-product-create .card-hd {
  background: linear-gradient(180deg, var(--surface2) 0%, var(--surface) 100%) !important;
}
html[data-theme='light'] body.seller-product-create .inp,
html[data-theme='light'] body.seller-product-create .sel,
html[data-theme='light'] body.seller-product-create .txa {
  background: #fff !important;
  border-color: var(--border) !important;
  color: var(--text);
}
html[data-theme='light'] body.seller-product-create .file-slot {
  background: rgba(15,23,42,.04) !important;
  border-color: var(--border) !important;
}

/* Ma boutique (classe seller-boutique-page sur <body>) */
html[data-theme='light'] body.seller-boutique-page header.top {
  background: rgba(255, 255, 255, 0.97) !important;
  border-color: var(--border) !important;
  box-shadow: 0 1px 0 rgba(15, 23, 42, 0.06);
}
html[data-theme='light'] body.seller-boutique-page .top-brand-nex {
  color: #0f172a !important;
}
html[data-theme='light'] body.seller-boutique-page .top-brand-shop {
  color: #ff6b35 !important;
}
html[data-theme='light'] body.seller-boutique-page .top-brand-tag {
  background: rgba(255, 107, 53, 0.1) !important;
  color: #c2410c !important;
  border-color: rgba(255, 107, 53, 0.25) !important;
}
html[data-theme='light'] body.seller-boutique-page .top-nav a.link {
  color: #475569 !important;
  background: #f1f5f9 !important;
  border-color: #e2e8f0 !important;
}
html[data-theme='light'] body.seller-boutique-page .top-nav a.link:hover {
  color: #ff6b35 !important;
  border-color: rgba(255, 107, 53, 0.35) !important;
}
html[data-theme='light'] body.seller-boutique-page .page {
  background: linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%) !important;
}
html[data-theme='light'] body.seller-boutique-page .page .card {
  background: #fff !important;
  border-color: #e2e8f0 !important;
  box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06) !important;
}
html[data-theme='light'] body.seller-boutique-page .page-title {
  color: #0f172a !important;
}
html[data-theme='light'] body.seller-boutique-page .page-sub {
  color: #64748b !important;
}
html[data-theme='light'] body.seller-boutique-page .form-group input,
html[data-theme='light'] body.seller-boutique-page .form-group textarea {
  background: #fff !important;
  border-color: #e2e8f0 !important;
  color: #0f172a !important;
}
html[data-theme='light'] body.seller-boutique-page .readonly {
  background: #f8fafc !important;
  color: #334155 !important;
  border: 1px solid #e2e8f0 !important;
}
html[data-theme='light'] body.seller-boutique-page .form-group input[type='file'] {
  background: #f8fafc !important;
  border-color: #e2e8f0 !important;
  color: #334155 !important;
}
html[data-theme='light'] body.seller-boutique-page .btn-submit {
  box-shadow: 0 6px 22px rgba(255, 107, 53, 0.28) !important;
}

/* Messages vendeur bandeau */
html[data-theme='light'] .msg-backbar {
  background: rgba(255,255,255,.96) !important;
  border-bottom-color: var(--border) !important;
}
html[data-theme='light'] body.msg-chat-fullscreen {
  color: #0f172a;
}

/* Page d’accueil — barres hors variables */
html[data-theme='light'] .market-topline {
  background: #eef2fb !important;
  color: #1e293b !important;
}
html[data-theme='light'] .market-catbar {
  background: #fff !important;
  border-top-color: #e2e8f0 !important;
  border-bottom-color: #e2e8f0 !important;
}
html[data-theme='light'] .market-catbar a { color: #1e293b !important; }

html[data-theme='dark'] .market-topline {
  background: #0b0f16 !important;
  color: #e5e7eb !important;
}
html[data-theme='dark'] .market-catbar {
  background: #0f1720 !important;
  border-top-color: rgba(255,255,255,.12) !important;
  border-bottom-color: rgba(255,255,255,.12) !important;
}
html[data-theme='dark'] .market-catbar a { color: #e5e7eb !important; }

/* Tableaux / liste admin & vendeur */


html[data-theme='light'] .table th {
  background: var(--bg3) !important;
  border-color: var(--border) !important;
}
html[data-theme='light'] .table td {
  border-color: var(--border) !important;
}

html[data-theme='light'] .mega-menu {
  background: #ffffff !important;
  border-color: #e5e7eb !important;
}
html[data-theme='dark'] .mega-menu {
  background: #111827 !important;
  border-color: rgba(255,255,255,.12) !important;
}
html[data-theme='dark'] .mega-left button {
  background: #111827 !important;
  color: #e5e7eb !important;
}
html[data-theme='light'] .mega-left button:hover,
html[data-theme='light'] .mega-left button.active {
  background: #f1f5f9 !important;
  color: #0f172a !important;
}

/* Admin KYC (pages isolées) */
html[data-theme='light'] body.admin-kyc-page table {
  border-color: var(--border) !important;
  background: var(--bg2) !important;
}
html[data-theme='light'] body.admin-kyc-page th,
html[data-theme='light'] body.admin-kyc-page td {
  border-bottom-color: rgba(15, 23, 42, .08) !important;
}
html[data-theme='light'] body.admin-kyc-page .box {
  background: #f8fafc !important;
  border-color: var(--border) !important;
}
html[data-theme='light'] body.admin-kyc-page button:not(.ok):not(.bad),
html[data-theme='light'] body.admin-kyc-page input {
  background: #fff !important;
  border-color: var(--border) !important;
  color: var(--text) !important;
}
</style>
<script>
(() => {
  const KEY = 'nexshop-theme';
  function btnLabel(theme) {
    return theme === 'dark' ? 'Sombre' : 'Clair';
  }
  function updateToggles(theme) {
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
      btn.setAttribute('aria-label', theme === 'dark'
        ? 'Thème sombre actif — passer au thème clair'
        : 'Thème clair actif — passer au thème sombre');
      btn.setAttribute('title', theme === 'dark' ? 'Passer au thème clair' : 'Passer au thème sombre');
      btn.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
      const icon = btn.querySelector('i');
      if (icon) {
        icon.className = theme === 'dark' ? 'fa-regular fa-moon' : 'fa-regular fa-sun';
      }
      const lbl = btn.querySelector('.theme-toggle-label');
      if (lbl) {
        lbl.textContent = btnLabel(theme);
      }
    });
  }
  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(KEY, theme);
    updateToggles(theme);
  }
  document.addEventListener('DOMContentLoaded', () => {
    const current = document.documentElement.getAttribute('data-theme') || 'dark';
    updateToggles(current);
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const active = document.documentElement.getAttribute('data-theme') || 'dark';
        applyTheme(active === 'dark' ? 'light' : 'dark');
      });
    });
  });
})();
</script>
