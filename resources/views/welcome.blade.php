<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('partials.theme-init')
<title>NexShop — Marketplace Djibouti</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{background:#1a1710;color:#f0f0f0;font-family:'Inter',sans-serif;font-size:15px;line-height:1.6;overflow-x:hidden;padding:0}
a{color:inherit;text-decoration:none}img{display:block;max-width:100%}ul{list-style:none}
h1,h2,h3,h4{font-family:'Space Grotesk',sans-serif;line-height:1.1}
::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:#1a1710}::-webkit-scrollbar-thumb{background:#e8772e;border-radius:3px}

:root{--accent:#e8772e;--accent2:#f09044;--bg:#1a1710;--bg2:#211e16;--bg3:#2a261e;--border:rgba(255,255,255,.07);--T:.25s ease}

/* ════════════ NAVBAR ════════════ */
.dm-nav{position:sticky;top:0;z-index:1000;display:flex;align-items:center;padding:0 48px;height:60px;background:rgba(26,23,16,.95);backdrop-filter:blur(18px);border-bottom:1px solid var(--border)}
.dm-logo{font-family:'Space Grotesk',sans-serif;font-size:21px;font-weight:800;color:#fff;white-space:nowrap;flex-shrink:0}
.dm-logo span{color:var(--accent)}
.dm-links{display:flex;gap:32px;margin-left:52px;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em}
.dm-links a{color:rgba(255,255,255,.45);transition:color var(--T)}
.dm-links a:hover{color:var(--accent)}
.dm-right{margin-left:auto;display:flex;align-items:center;gap:14px}
.dm-icon{position:relative;width:36px;height:36px;border-radius:50%;background:transparent;border:none;color:rgba(255,255,255,.6);font-size:15px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:color var(--T)}
.dm-icon:hover{color:var(--accent)}
.dm-badge{position:absolute;top:-1px;right:-1px;width:16px;height:16px;border-radius:50%;background:var(--accent);color:#fff;font-size:8px;font-weight:800;font-family:'Space Grotesk',sans-serif;display:flex;align-items:center;justify-content:center}
.dm-btn{padding:8px 20px;border-radius:8px;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;cursor:pointer;transition:all var(--T);text-decoration:none;text-transform:uppercase;letter-spacing:.06em}
.dm-btn--ghost{background:transparent;border:1.5px solid rgba(255,255,255,.12);color:#fff}
.dm-btn--ghost:hover{border-color:var(--accent);color:var(--accent)}
.dm-btn--fill{background:var(--accent);border:none;color:#fff}
.dm-btn--fill:hover{background:var(--accent2)}
.dm-hamburger{display:none;background:none;border:none;color:#fff;font-size:20px;cursor:pointer;margin-left:auto}

/* ════════════ HERO ════════════ */
.dm-hero{display:grid;grid-template-columns:1.1fr .9fr;min-height:calc(100vh - 60px);background:var(--bg);position:relative;overflow:hidden}
.dm-hero::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(232,119,46,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(232,119,46,.025) 1px,transparent 1px);background-size:60px 60px;pointer-events:none}
.dm-hero-left{display:flex;flex-direction:column;justify-content:center;padding:80px 48px 80px 80px;position:relative;z-index:2}
.dm-hero-tag{display:inline-flex;align-items:center;gap:10px;font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--accent);margin-bottom:28px;width:fit-content}
.dm-hero-tag::before{content:'';width:28px;height:2px;background:var(--accent);border-radius:1px}
.dm-hero-title{font-size:clamp(34px,4.2vw,56px);font-weight:800;letter-spacing:-.03em;line-height:1.1;margin-bottom:20px;color:#fff}
.dm-hero-title em{font-family:'Playfair Display',serif;font-style:italic;color:var(--accent)}
.dm-hero-sub{font-size:14px;color:rgba(255,255,255,.45);max-width:400px;line-height:1.75;margin-bottom:12px}
.dm-hero-bullet{font-size:13px;color:rgba(255,255,255,.5);margin-bottom:32px;display:flex;align-items:center;gap:8px}
.dm-hero-bullet::before{content:'→';color:var(--accent);font-weight:700}
.dm-hero-btns{display:flex;gap:14px;flex-wrap:wrap;align-items:center}
.dm-hero-btns .btn-p{background:var(--accent);color:#fff;border:none;padding:14px 30px;border-radius:10px;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all var(--T);text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:8px;box-shadow:0 4px 16px rgba(232,119,46,.35)}
.dm-hero-btns .btn-p:hover{background:var(--accent2);transform:translateY(-2px)}
.dm-hero-btns .btn-g{background:transparent;color:#fff;border:1.5px solid rgba(255,255,255,.15);padding:13px 28px;border-radius:10px;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all var(--T);text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:8px}
.dm-hero-btns .btn-g:hover{border-color:var(--accent);color:var(--accent)}
a.btn-p,a.btn-g{text-decoration:none}

.dm-hero-right{position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#1e1b14}
.dm-hero-right img{width:100%;height:100%;object-fit:cover;opacity:.85;transition:transform 10s ease}
.dm-hero:hover .dm-hero-right img{transform:scale(1.04)}
.dm-hero-right::before{content:'';position:absolute;inset:0;background:linear-gradient(90deg,var(--bg) 0%,transparent 35%);z-index:1}
.dm-float-top{position:absolute;top:36px;right:36px;z-index:3;background:var(--accent);border-radius:14px;padding:14px 20px;color:#fff;font-family:'Space Grotesk',sans-serif;text-align:center}
.dm-float-top .fn{font-size:22px;font-weight:800;line-height:1}
.dm-float-top .fl{font-size:9px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;opacity:.85;margin-top:2px}
.dm-float-mid{position:absolute;top:50%;right:20%;transform:translateY(-50%);z-index:3;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.3);text-align:center}
.dm-float-bot{position:absolute;bottom:36px;left:36px;z-index:3;background:rgba(26,23,16,.85);backdrop-filter:blur(10px);border:1px solid var(--border);border-radius:14px;padding:14px 22px;display:flex;align-items:center;gap:14px}
.dm-float-bot .fn{font-family:'Space Grotesk',sans-serif;font-size:16px;font-weight:800;color:#fff}
.dm-float-bot .fl{font-size:10px;color:rgba(255,255,255,.45);text-transform:uppercase;letter-spacing:.06em}
.dm-float-bot .dot{width:10px;height:10px;border-radius:50%;background:var(--accent);flex-shrink:0}

/* ════════════ STATS BAR ════════════ */
.dm-stats{display:grid;grid-template-columns:repeat(4,1fr);background:#1e1b14;border-top:1px solid var(--border);border-bottom:1px solid var(--border)}
.dm-stat{padding:22px 32px;border-right:1px solid var(--border);display:flex;align-items:center;gap:10px}
.dm-stat:last-child{border-right:none}
.dm-stat .sn{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:var(--accent)}
.dm-stat .sl{font-size:11px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.08em;font-weight:500}

/* ════════════ TRUST TICKER ════════════ */
.dm-trust{background:var(--accent);padding:11px 0;overflow:hidden;position:relative}
.dm-trust-track{display:flex;gap:32px;width:max-content;animation:tScroll 28s linear infinite;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#fff;padding:0 40px}
.dm-trust-track span{white-space:nowrap;display:flex;align-items:center;gap:8px}
.dm-trust-track .dot{opacity:.45;font-size:8px}
@keyframes tScroll{from{transform:translateX(0)}to{transform:translateX(-50%)}}

/* ════════════ SECTIONS ════════════ */
.dm-section{padding:72px 80px}
.dm-sec-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:40px}
.dm-sec-title{font-family:'Space Grotesk',sans-serif;font-size:clamp(24px,2.8vw,36px);font-weight:800;letter-spacing:-.02em;color:#fff}
.dm-see-all{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:.08em;display:flex;align-items:center;gap:6px;transition:gap var(--T);white-space:nowrap}
.dm-see-all:hover{gap:10px}

/* ════════════ CATEGORIES ════════════ */
.dm-cats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.dm-cat{position:relative;aspect-ratio:4/3;overflow:hidden;border-radius:16px;cursor:pointer;border:1px solid var(--border);transition:border-color .3s,transform .3s}
.dm-cat:hover{border-color:rgba(232,119,46,.3);transform:translateY(-4px)}
.dm-cat img{width:100%;height:100%;object-fit:cover;transition:transform .6s ease}
.dm-cat:hover img{transform:scale(1.05)}
.dm-cat::after{content:'';position:absolute;inset:0;background:linear-gradient(0deg,rgba(0,0,0,.75) 0%,transparent 50%)}
.dm-cat-info{position:absolute;bottom:0;left:0;right:0;padding:20px;z-index:2}
.dm-cat-name{font-family:'Space Grotesk',sans-serif;font-size:17px;font-weight:700;color:#fff;font-style:italic;margin-bottom:2px}
.dm-cat-count{font-size:11px;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.04em}

/* ════════════ PRODUCTS ════════════ */
.dm-prods{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.dm-prod{background:var(--bg2);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:border-color .3s,transform .3s,box-shadow .3s}
.dm-prod:hover{border-color:rgba(232,119,46,.25);transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,.35)}
.dm-prod-img{position:relative;aspect-ratio:1/1;overflow:hidden;background:#2a261e}
.dm-prod-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease}
.dm-prod:hover .dm-prod-img img{transform:scale(1.05)}
.dm-prod-badge{position:absolute;top:10px;left:10px;padding:4px 12px;border-radius:8px;font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#fff}
.dm-prod-badge.b-new{background:#3b82f6}
.dm-prod-badge.b-pop{background:#22c55e}
.dm-prod-badge.b-promo{background:var(--accent)}
.dm-prod-acts{position:absolute;top:10px;right:10px;display:flex;flex-direction:column;gap:6px;opacity:0;transition:opacity .25s}
.dm-prod:hover .dm-prod-acts{opacity:1}
.dm-prod-act{width:32px;height:32px;background:rgba(26,23,16,.8);border:1px solid rgba(255,255,255,.1);color:#fff;font-size:12px;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;backdrop-filter:blur(6px)}
.dm-prod-act:hover{background:var(--accent);border-color:var(--accent)}
.dm-prod-body{padding:14px 16px 16px}
.dm-prod-name{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:#fff;margin-bottom:3px;line-height:1.3}
.dm-prod-name a{color:inherit;text-decoration:none}
.dm-prod-sub{font-size:11px;color:rgba(255,255,255,.35);margin-bottom:10px;text-transform:uppercase;letter-spacing:.04em}
.dm-prod-foot{display:flex;align-items:center;justify-content:space-between}
.dm-prod-price{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:800;color:var(--accent)}
.dm-prod-old{font-size:11px;color:rgba(255,255,255,.3);text-decoration:line-through;margin-left:6px;font-weight:400}
.dm-add{width:32px;height:32px;background:var(--accent);color:#fff;border:none;border-radius:8px;font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s}
.dm-add:hover{background:var(--accent2);transform:scale(1.08)}
a.dm-add{text-decoration:none;color:#fff}

/* ════════════ CTA VENDEUR ════════════ */
.dm-cta{background:var(--bg2);border-top:1px solid var(--border);padding:64px 80px;display:flex;align-items:center;justify-content:space-between;gap:48px}
.dm-cta-tag{font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--accent);margin-bottom:12px;display:flex;align-items:center;gap:8px}
.dm-cta-tag::before{content:'';width:20px;height:2px;background:var(--accent);border-radius:1px}
.dm-cta h2{font-family:'Space Grotesk',sans-serif;font-size:clamp(24px,2.8vw,36px);font-weight:800;color:#fff;line-height:1.15;margin-bottom:12px}
.dm-cta h2 span{color:var(--accent)}
.dm-cta p{font-size:14px;color:rgba(255,255,255,.4);line-height:1.7;max-width:480px}
.dm-cta-btn{display:inline-flex;align-items:center;gap:8px;background:transparent;border:1.5px solid var(--accent);color:var(--accent);padding:14px 30px;border-radius:10px;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all var(--T);text-transform:uppercase;letter-spacing:.06em;white-space:nowrap;text-decoration:none;flex-shrink:0}
.dm-cta-btn:hover{background:var(--accent);color:#fff}
.dm-cta-btn i{transition:transform var(--T)}
.dm-cta-btn:hover i{transform:translateX(4px)}

/* ════════════ NEWSLETTER ════════════ */
.dm-nl{background:var(--bg);border-top:1px solid var(--border);padding:48px 80px;display:flex;align-items:center;justify-content:space-between;gap:40px}
.dm-nl-title{font-family:'Space Grotesk',sans-serif;font-size:20px;font-weight:800;color:#fff}
.dm-nl-sub{font-size:12px;color:rgba(255,255,255,.35);margin-top:4px}
.dm-nl-form{display:flex;gap:0;flex-shrink:0}
.dm-nl-form input{background:var(--bg3);border:1.5px solid var(--border);border-right:none;border-radius:10px 0 0 10px;padding:12px 20px;color:#fff;font-family:'Inter',sans-serif;font-size:13px;outline:none;min-width:240px;transition:border-color var(--T)}
.dm-nl-form input:focus{border-color:var(--accent)}
.dm-nl-form input::placeholder{color:rgba(255,255,255,.3)}
.dm-nl-form button{background:var(--accent);color:#fff;border:none;padding:12px 24px;border-radius:0 10px 10px 0;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:background var(--T);white-space:nowrap;text-transform:uppercase;letter-spacing:.06em}
.dm-nl-form button:hover{background:var(--accent2)}

/* ════════════ FOOTER ════════════ */
.dm-footer{background:#141210;padding:48px 80px 0}
.dm-footer-top{display:grid;grid-template-columns:1.4fr 1fr 1fr;gap:48px;padding-bottom:36px;border-bottom:1px solid var(--border)}
.dm-f-brand{}
.dm-f-logo{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:#fff;margin-bottom:12px}
.dm-f-logo span{color:var(--accent)}
.dm-f-desc{font-size:13px;color:rgba(255,255,255,.4);line-height:1.7;max-width:320px;margin-bottom:16px}
.dm-f-socials{display:flex;gap:8px}
.dm-f-socials a{width:34px;height:34px;border-radius:8px;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.35);font-size:13px;transition:all var(--T)}
.dm-f-socials a:hover{border-color:var(--accent);color:var(--accent)}
.dm-f-col h4{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--accent);margin-bottom:16px}
.dm-f-col a{display:block;font-size:13px;color:rgba(255,255,255,.4);padding:5px 0;transition:color var(--T)}
.dm-f-col a:hover{color:#fff}
.dm-footer-bottom{display:flex;align-items:center;justify-content:space-between;padding:20px 0}
.dm-f-copy{font-size:11px;color:rgba(255,255,255,.2);white-space:nowrap}
.dm-f-bottom-links{display:flex;gap:20px;font-size:11px}
.dm-f-bottom-links a{color:rgba(255,255,255,.25);transition:color var(--T)}
.dm-f-bottom-links a:hover{color:var(--accent)}

/* ════════════ DRAWER ════════════ */
.dm-overlay{position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:1999;display:none}
.dm-overlay.open{display:block}
.dm-drawer{position:fixed;top:0;right:-100%;width:280px;height:100%;background:var(--bg2);z-index:2000;border-left:1px solid var(--border);padding:28px 24px;transition:right .35s cubic-bezier(.4,0,.2,1);overflow-y:auto}
.dm-drawer.open{right:0}
.dm-drawer-close{position:absolute;top:18px;right:18px;background:var(--bg3);border:none;color:#fff;font-size:18px;width:36px;height:36px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center}
.dm-drawer-logo{font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;margin-bottom:28px;color:#fff}
.dm-drawer-logo span{color:var(--accent)}
.dm-drawer a.dl{display:flex;align-items:center;gap:12px;padding:13px 0;border-bottom:1px solid var(--border);font-size:14px;color:rgba(255,255,255,.5);font-family:'Space Grotesk',sans-serif;font-weight:500;transition:color var(--T)}
.dm-drawer a.dl i{color:var(--accent);width:18px}
.dm-drawer a.dl:hover{color:#fff}
.dm-drawer-btns{display:flex;flex-direction:column;gap:10px;margin-top:24px}

/* ════════════ CATEGORY FILTERS ════════════ */
.dm-cf{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px}
.dm-cf button{background:var(--bg3);border:1px solid var(--border);color:rgba(255,255,255,.5);padding:7px 16px;border-radius:8px;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:600;cursor:pointer;transition:all var(--T);white-space:nowrap;text-transform:uppercase;letter-spacing:.04em}
.dm-cf button:hover,.dm-cf button.active{background:var(--accent);border-color:var(--accent);color:#fff}

/* ════════════ REVEAL ════════════ */
.reveal{opacity:0;transform:translateY(24px);transition:opacity .6s ease,transform .6s ease}
.reveal.visible{opacity:1;transform:translateY(0)}

/* ════════════ TOAST ════════════ */
.toast{position:fixed;bottom:28px;right:28px;background:var(--bg2);border:1px solid rgba(232,119,46,.3);color:#fff;padding:13px 20px;border-radius:12px;font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:600;display:flex;align-items:center;gap:10px;z-index:9999;transform:translateY(80px);opacity:0;transition:all .35s cubic-bezier(.4,0,.2,1);box-shadow:0 8px 32px rgba(0,0,0,.5)}
.toast.show{transform:translateY(0);opacity:1}
.toast i{color:var(--accent)}

/* ════════════ INFO SECTIONS ════════════ */
.dm-info{padding:72px 80px;border-top:1px solid var(--border)}
.dm-info-title{font-family:'Space Grotesk',sans-serif;font-size:clamp(22px,2.4vw,32px);font-weight:800;color:#fff;margin-bottom:8px;display:flex;align-items:center;gap:12px}
.dm-info-title i{color:var(--accent);font-size:.75em}
.dm-info-sub{font-size:12px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.1em;font-family:'Space Grotesk',sans-serif;font-weight:700;margin-bottom:28px}
.dm-info-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px}
.dm-info-card{background:var(--bg2);border:1px solid var(--border);border-radius:16px;padding:24px;transition:border-color .3s,transform .3s}
.dm-info-card:hover{border-color:rgba(232,119,46,.25);transform:translateY(-3px)}
.dm-info-card h4{font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:700;color:#fff;margin-bottom:8px;display:flex;align-items:center;gap:8px}
.dm-info-card h4 i{color:var(--accent);font-size:14px}
.dm-info-card p{font-size:13px;color:rgba(255,255,255,.45);line-height:1.7}
.dm-info-text{font-size:14px;color:rgba(255,255,255,.5);line-height:1.8;max-width:780px}
.dm-info-text strong{color:#fff}
.dm-contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.dm-contact-form{display:flex;flex-direction:column;gap:14px}
.dm-contact-form input,.dm-contact-form textarea{background:var(--bg2);border:1.5px solid var(--border);border-radius:10px;padding:12px 16px;color:#fff;font-family:'Inter',sans-serif;font-size:14px;outline:none;transition:border-color var(--T);resize:none}
.dm-contact-form input::placeholder,.dm-contact-form textarea::placeholder{color:rgba(255,255,255,.3)}
.dm-contact-form input:focus,.dm-contact-form textarea:focus{border-color:var(--accent)}
.dm-contact-form button{align-self:flex-start;background:var(--accent);color:#fff;border:none;padding:12px 28px;border-radius:10px;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;cursor:pointer;transition:all var(--T);text-transform:uppercase;letter-spacing:.06em;display:flex;align-items:center;gap:8px}
.dm-contact-form button:hover{background:var(--accent2)}
.dm-contact-info{display:flex;flex-direction:column;gap:18px}
.dm-ci{display:flex;align-items:flex-start;gap:14px;font-size:14px;color:rgba(255,255,255,.5)}
.dm-ci-ico{width:40px;height:40px;border-radius:12px;background:rgba(232,119,46,.1);display:flex;align-items:center;justify-content:center;color:var(--accent);font-size:15px;flex-shrink:0}
.dm-ci strong{color:#fff;display:block;margin-bottom:2px}
.dm-faq{display:flex;flex-direction:column;gap:12px}
.dm-faq-item{background:var(--bg2);border:1px solid var(--border);border-radius:12px;overflow:hidden}
.dm-faq-q{padding:16px 20px;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:12px;border:none;background:none;width:100%;text-align:left;transition:color .2s}
.dm-faq-q:hover{color:var(--accent)}
.dm-faq-q i{color:var(--accent);font-size:11px;transition:transform .3s}
.dm-faq-item.open .dm-faq-q i{transform:rotate(180deg)}
.dm-faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease,padding .35s ease;padding:0 20px;font-size:13px;color:rgba(255,255,255,.45);line-height:1.7}
.dm-faq-item.open .dm-faq-a{max-height:300px;padding:0 20px 16px}

@media(max-width:900px){
  .dm-info{padding:56px 40px}
  .dm-contact-grid{grid-template-columns:1fr}
}
@media(max-width:600px){
  .dm-info{padding:40px 22px}
}

/* ════════════ LIGHT MODE ════════════ */
html[data-theme='light'] body{background:#f5f7fb;color:#1e293b}
html[data-theme='light'] .dm-nav{background:rgba(255,255,255,.96);border-bottom-color:rgba(15,23,42,.08)}
html[data-theme='light'] .dm-logo{color:#0f172a}
html[data-theme='light'] .dm-links a{color:rgba(15,23,42,.45)}
html[data-theme='light'] .dm-links a:hover{color:var(--accent)}
html[data-theme='light'] .dm-icon{color:rgba(15,23,42,.55)}
html[data-theme='light'] .dm-icon:hover{color:var(--accent)}
html[data-theme='light'] .dm-btn--ghost{border-color:rgba(15,23,42,.15);color:#0f172a}
html[data-theme='light'] .dm-btn--ghost:hover{border-color:var(--accent);color:var(--accent)}
html[data-theme='light'] .dm-hero{background:#f5f7fb}
html[data-theme='light'] .dm-hero::before{background-image:linear-gradient(rgba(232,119,46,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(232,119,46,.04) 1px,transparent 1px)}
html[data-theme='light'] .dm-hero-title{color:#0f172a}
html[data-theme='light'] .dm-hero-sub{color:#64748b}
html[data-theme='light'] .dm-hero-bullet{color:#64748b}
html[data-theme='light'] .dm-hero-btns .btn-g{border-color:rgba(15,23,42,.15);color:#0f172a}
html[data-theme='light'] .dm-hero-btns .btn-g:hover{border-color:var(--accent);color:var(--accent)}
html[data-theme='light'] .dm-hero-right{background:#e8ecf2}
html[data-theme='light'] .dm-hero-right::before{background:linear-gradient(90deg,#f5f7fb 0%,transparent 35%)}
html[data-theme='light'] .dm-float-bot{background:rgba(255,255,255,.9);border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .dm-float-bot .fn{color:#0f172a}
html[data-theme='light'] .dm-float-bot .fl{color:#64748b}
html[data-theme='light'] .dm-stats{background:#eef2f9;border-color:rgba(15,23,42,.06)}
html[data-theme='light'] .dm-stat{border-color:rgba(15,23,42,.06)}
html[data-theme='light'] .dm-stat .sl{color:#64748b}
html[data-theme='light'] .dm-section{background:#f5f7fb !important}
html[data-theme='light'] .dm-section[style*='1e1b14']{background:#eef2f9 !important}
html[data-theme='light'] .dm-sec-title{color:#0f172a}
html[data-theme='light'] .dm-cat{border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .dm-cat:hover{border-color:rgba(232,119,46,.3)}
html[data-theme='light'] .dm-prod{background:#fff;border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .dm-prod:hover{border-color:rgba(232,119,46,.25);box-shadow:0 12px 32px rgba(15,23,42,.1)}
html[data-theme='light'] .dm-prod-img{background:#eef2f9}
html[data-theme='light'] .dm-prod-name{color:#0f172a}
html[data-theme='light'] .dm-prod-name a{color:#0f172a}
html[data-theme='light'] .dm-prod-sub{color:#64748b}
html[data-theme='light'] .dm-prod-act{background:rgba(255,255,255,.85);border-color:rgba(15,23,42,.1);color:#334155}
html[data-theme='light'] .dm-cf button{background:#fff;border-color:rgba(15,23,42,.1);color:#64748b}
html[data-theme='light'] .dm-cf button:hover,html[data-theme='light'] .dm-cf button.active{background:var(--accent);border-color:var(--accent);color:#fff}
html[data-theme='light'] .dm-cta{background:#eef2f9;border-color:rgba(15,23,42,.06)}
html[data-theme='light'] .dm-cta h2{color:#0f172a}
html[data-theme='light'] .dm-cta p{color:#64748b}
html[data-theme='light'] .dm-nl{background:#f5f7fb;border-color:rgba(15,23,42,.06)}
html[data-theme='light'] .dm-nl-title{color:#0f172a}
html[data-theme='light'] .dm-nl-sub{color:#64748b}
html[data-theme='light'] .dm-nl-form input{background:#fff;border-color:rgba(15,23,42,.12);color:#0f172a}
html[data-theme='light'] .dm-nl-form input::placeholder{color:#94a3b8}
html[data-theme='light'] .dm-footer{background:#e8ecf2}
html[data-theme='light'] .dm-footer-top{border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .dm-f-logo{color:#0f172a}
html[data-theme='light'] .dm-f-desc{color:#64748b}
html[data-theme='light'] .dm-f-socials a{border-color:rgba(15,23,42,.1);color:#64748b}
html[data-theme='light'] .dm-f-socials a:hover{border-color:var(--accent);color:var(--accent)}
html[data-theme='light'] .dm-f-col h4{color:var(--accent)}
html[data-theme='light'] .dm-f-col a{color:#475569}
html[data-theme='light'] .dm-f-col a:hover{color:#0f172a}
html[data-theme='light'] .dm-f-copy{color:#94a3b8}
html[data-theme='light'] .dm-f-bottom-links a{color:#94a3b8}
html[data-theme='light'] .dm-drawer{background:#fff;border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .dm-drawer-logo{color:#0f172a}
html[data-theme='light'] .dm-drawer a.dl{color:#475569;border-color:rgba(15,23,42,.06)}
html[data-theme='light'] .dm-drawer a.dl:hover{color:#0f172a}
html[data-theme='light'] .dm-drawer-close{background:#f1f5f9;color:#334155}
html[data-theme='light'] .toast{background:#fff;border-color:rgba(232,119,46,.2);color:#0f172a;box-shadow:0 8px 32px rgba(15,23,42,.12)}
html[data-theme='light'] ::-webkit-scrollbar-track{background:#f5f7fb}
html[data-theme='light'] .dm-info{border-color:rgba(15,23,42,.06)}
html[data-theme='light'] .dm-info-title{color:#0f172a}
html[data-theme='light'] .dm-info-sub{color:#64748b}
html[data-theme='light'] .dm-info-card{background:#fff;border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .dm-info-card:hover{border-color:rgba(232,119,46,.25);box-shadow:0 8px 24px rgba(15,23,42,.06)}
html[data-theme='light'] .dm-info-card h4{color:#0f172a}
html[data-theme='light'] .dm-info-card p{color:#64748b}
html[data-theme='light'] .dm-info-text{color:#475569}
html[data-theme='light'] .dm-info-text strong{color:#0f172a}
html[data-theme='light'] .dm-contact-form input,html[data-theme='light'] .dm-contact-form textarea{background:#fff;border-color:rgba(15,23,42,.12);color:#0f172a}
html[data-theme='light'] .dm-contact-form input::placeholder,html[data-theme='light'] .dm-contact-form textarea::placeholder{color:#94a3b8}
html[data-theme='light'] .dm-ci{color:#475569}
html[data-theme='light'] .dm-ci strong{color:#0f172a}
html[data-theme='light'] .dm-ci-ico{background:rgba(255,107,53,.08)}
html[data-theme='light'] .dm-faq-item{background:#fff;border-color:rgba(15,23,42,.08)}
html[data-theme='light'] .dm-faq-q{color:#0f172a}
html[data-theme='light'] .dm-faq-a{color:#475569}

/* ════════════ RESPONSIVE ════════════ */
@media(max-width:1200px){
  .dm-links{display:none}
  .dm-cats{grid-template-columns:repeat(2,1fr)}
  .dm-prods{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:900px){
  .dm-hero{grid-template-columns:1fr;min-height:auto}
  .dm-hero-left{padding:56px 40px}
  .dm-hero-right{height:320px}
  .dm-hero-right::before{background:linear-gradient(0deg,var(--bg) 0%,transparent 50%)}
  .dm-float-top,.dm-float-mid,.dm-float-bot{display:none}
  .dm-section{padding:56px 40px}
  .dm-stats{grid-template-columns:repeat(2,1fr)}
  .dm-prods{grid-template-columns:repeat(2,1fr)}
  .dm-cta{flex-direction:column;padding:56px 40px;text-align:center;align-items:center}
  .dm-cta p{max-width:100%}
  .dm-nl{flex-direction:column;padding:40px;text-align:center}
  .dm-nl-form{width:100%;max-width:380px}
  .dm-nl-form input{min-width:0;flex:1}
  .dm-footer{padding:40px 40px 0}
  .dm-footer-top{grid-template-columns:1fr;gap:28px;text-align:center}
  .dm-f-socials{justify-content:center}
  .dm-footer-bottom{flex-direction:column;gap:10px;text-align:center}
}
@media(max-width:600px){
  .dm-nav{padding:0 20px;gap:10px}
  .dm-btn,.dm-icon{display:none}
  .dm-hamburger{display:block}
  .dm-hero-left{padding:40px 22px}
  .dm-section{padding:40px 22px}
  .dm-cats{grid-template-columns:1fr}
  .dm-prods{grid-template-columns:repeat(2,1fr)}
  .dm-stats{grid-template-columns:1fr 1fr}
  .dm-cta{padding:40px 22px}
  .dm-nl{padding:32px 22px}
  .dm-nl-form{flex-direction:column;gap:10px}
  .dm-nl-form input{border-right:1.5px solid var(--border);border-radius:10px}
  .dm-nl-form button{border-radius:10px}
  .dm-footer{padding:32px 22px 0}
}
</style>
@include('partials.theme-manager')
</head>
<body>

@php
  $catalogUrl = auth()->check() && auth()->user()->type_compte === 'client'
    ? route('buyer.products.index')
    : route('login');
@endphp

<!-- ═══ NAVBAR ═══ -->
<nav class="dm-nav">
  <div class="dm-logo">Nex<span>Shop</span></div>

  <div class="dm-links">
    @foreach(($categories ?? collect())->take(4) as $cat)
      <a href="#prods-grid" data-cat-trigger="{{ $cat->id }}">{{ $cat->nom }}</a>
    @endforeach
    <a href="#a-propos">À propos</a>
  </div>

  <div class="dm-right">
    <button type="button" class="dm-icon" data-theme-toggle aria-pressed="false" title="Changer le thème"><i class="fa-regular fa-moon"></i></button>
    <button class="dm-icon"><i class="fa-solid fa-magnifying-glass"></i></button>
    @auth
      @if(auth()->user()->type_compte === 'client')
        <a href="{{ route('buyer.favorites.index') }}" class="dm-icon"><i class="fa-regular fa-heart"></i></a>
        <a href="{{ route('buyer.cart.index') }}" class="dm-icon"><i class="fa-solid fa-bag-shopping"></i><span class="dm-badge">{{ auth()->user()->panier()->count() }}</span></a>
      @endif
    @else
      <a href="{{ route('login') }}" class="dm-icon"><i class="fa-regular fa-heart"></i></a>
      <a href="{{ route('login') }}" class="dm-icon"><i class="fa-solid fa-bag-shopping"></i></a>
    @endauth

    @auth
      @if(auth()->user()->type_compte === 'admin')
        <a href="{{ route('admin.home') }}" class="dm-btn dm-btn--fill">Mon espace</a>
      @elseif(auth()->user()->type_compte === 'vendeur')
        <a href="{{ route('vendeur.home') }}" class="dm-btn dm-btn--fill">Mon espace</a>
      @else
        <a href="{{ route('buyer.home') }}" class="dm-btn dm-btn--fill">Mon espace</a>
      @endif
      <form action="{{ route('logout') }}" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="dm-btn dm-btn--ghost" style="cursor:pointer">Déconnexion</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="dm-btn dm-btn--ghost">Connexion</a>
      <a href="{{ route('register') }}" class="dm-btn dm-btn--fill">S'inscrire</a>
    @endauth
  </div>

  <button class="dm-hamburger" onclick="toggleDrawer()"><i class="fa-solid fa-bars"></i></button>
</nav>

<!-- ═══ DRAWER MOBILE ═══ -->
<div class="dm-overlay" id="overlay" onclick="toggleDrawer()"></div>
<div class="dm-drawer" id="drawer">
  <button class="dm-drawer-close" onclick="toggleDrawer()"><i class="fa-solid fa-xmark"></i></button>
  <div class="dm-drawer-logo">Nex<span>Shop</span></div>
  <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false" style="width:100%;justify-content:center;margin-bottom:18px"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
  @foreach(($categories ?? collect()) as $cat)
    <a href="#prods-grid" class="dl" data-cat-trigger="{{ $cat->id }}"><i class="{{ $cat->icone ?: 'fa-solid fa-tag' }}"></i>{{ $cat->nom }}</a>
  @endforeach
  @auth
    @if(auth()->user()->type_compte === 'client')
      <a href="{{ route('buyer.favorites.index') }}" class="dl"><i class="fa-regular fa-heart"></i>Favoris</a>
      <a href="{{ route('buyer.cart.index') }}" class="dl"><i class="fa-solid fa-bag-shopping"></i>Panier</a>
    @endif
  @endauth
  <div class="dm-drawer-btns">
    @auth
      @if(auth()->user()->type_compte === 'admin')
        <a href="{{ route('admin.home') }}" class="dm-btn dm-btn--fill" style="display:block;text-align:center;padding:13px">Mon espace</a>
      @elseif(auth()->user()->type_compte === 'vendeur')
        <a href="{{ route('vendeur.home') }}" class="dm-btn dm-btn--fill" style="display:block;text-align:center;padding:13px">Mon espace</a>
      @else
        <a href="{{ route('buyer.home') }}" class="dm-btn dm-btn--fill" style="display:block;text-align:center;padding:13px">Mon espace</a>
      @endif
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="dm-btn dm-btn--ghost" style="width:100%;display:block;text-align:center;padding:13px;cursor:pointer">Déconnexion</button>
      </form>
    @else
      <a href="{{ route('login') }}" class="dm-btn dm-btn--fill" style="display:block;text-align:center;padding:13px">Connexion</a>
      <a href="{{ route('register') }}" class="dm-btn dm-btn--ghost" style="display:block;text-align:center;padding:13px">S'inscrire</a>
    @endauth
  </div>
</div>

<!-- ═══ HERO ═══ -->
<section class="dm-hero">
  <div class="dm-hero-left">
    <div class="dm-hero-tag">Nouvelle collection 2026</div>
    <h1 class="dm-hero-title">L'authenticité<br>djiboutienne<br><em>redéfinie</em></h1>
    <p class="dm-hero-sub">Produits locaux, vendeurs vérifiés et mode contemporaine.</p>
    <div class="dm-hero-bullet">Livraison partout à Djibouti.</div>
    <div class="dm-hero-btns">
      <a href="{{ $catalogUrl }}" class="btn-p">Découvrir la boutique</a>
      @if(auth()->check() && auth()->user()->type_compte === 'vendeur')
        <a href="{{ route('vendeur.home') }}" class="btn-g">Mon espace vendeur</a>
      @else
        <a href="{{ route('vendeur.inscription.index') }}" class="btn-g">Voir les vendeurs</a>
      @endif
    </div>
  </div>
  <div class="dm-hero-right">
    <img src="{{ asset('images/shops.png') }}" alt="NexShop">
    <div class="dm-float-top">
      <div class="fn">Nouveau</div>
      <div class="fl">Vendeurs partenaires</div>
    </div>
    <div class="dm-float-mid">Photo produit vedette</div>
    <div class="dm-float-bot">
      <div>
        <div class="fn">100%</div>
        <div class="fl">Produits locaux</div>
      </div>
      <div class="dot"></div>
    </div>
  </div>
</section>

<!-- ═══ STATS BAR ═══ -->
<div class="dm-stats reveal">
  <div class="dm-stat"><div class="sn">100%</div><div class="sl">Local</div></div>
  <div class="dm-stat"><div class="sn">Gratuit</div><div class="sl">Inscription</div></div>
  <div class="dm-stat"><div class="sn">24h</div><div class="sl">Livraison</div></div>
  <div class="dm-stat"><div class="sn">5 jours</div><div class="sl">Retour garanti</div></div>
</div>

<!-- ═══ TRUST TICKER ═══ -->
<div class="dm-trust">
  <div class="dm-trust-track">
    <span><i class="fa-solid fa-gem"></i> Chat djiboutien authentique</span><span class="dot">•</span>
    <span><i class="fa-solid fa-wallet"></i> En espéces</span><span class="dot">•</span>
    <span><i class="fa-solid fa-rotate-left"></i> Retours sous 5 jours</span><span class="dot">•</span>
    <span><i class="fa-solid fa-shield-halved"></i> Vendeurs locaux certifiés</span><span class="dot">•</span>
    <span><i class="fa-solid fa-truck-fast"></i> Livraison gratuite dès 10 000 Fdj</span><span class="dot">•</span>
    <span><i class="fa-solid fa-gem"></i> Chat djiboutien authentique</span><span class="dot">•</span>
    <span><i class="fa-solid fa-wallet"></i> En espéces</span><span class="dot">•</span>
    <span><i class="fa-solid fa-rotate-left"></i> Retours sous 5 jours</span><span class="dot">•</span>
    <span><i class="fa-solid fa-shield-halved"></i> Vendeurs locaux certifiés</span><span class="dot">•</span>
    <span><i class="fa-solid fa-truck-fast"></i> Livraison gratuite dès 10 000 Fdj</span>
  </div>
</div>

<!-- ═══ EXPLORER LES UNIVERS ═══ -->
<section class="dm-section reveal" style="background:#1e1b14">
  <div class="dm-sec-head">
    <h2 class="dm-sec-title">Explorer les univers</h2>
    <a href="{{ $catalogUrl }}" class="dm-see-all">Toutes les catégories <i class="fa-solid fa-arrow-right"></i></a>
  </div>
  <div class="dm-cats">
    @forelse(($categories ?? collect())->take(3) as $cat)
      <a href="#prods-grid" class="dm-cat" data-cat-trigger="{{ $cat->id }}" style="text-decoration:none;color:inherit">
        <img src="{{ $cat->displayImageUrl() }}" alt="{{ $cat->nom }}" loading="lazy">
        <div class="dm-cat-info">
          <div class="dm-cat-name">{{ $cat->nom }}</div>
          <div class="dm-cat-count">{{ number_format($cat->actifs_count ?? 0, 0, ',', ' ') }} produits</div>
        </div>
      </a>
    @empty
      <p style="grid-column:1/-1;color:rgba(255,255,255,.35);padding:20px">Aucune catégorie pour le moment.</p>
    @endforelse
  </div>
</section>

<!-- ═══ COUPS DE CŒUR ═══ -->
<section class="dm-section reveal" style="padding-top:0;background:var(--bg)">
  <div class="dm-sec-head">
    <h2 class="dm-sec-title">Coups de cœur</h2>
    <a href="{{ $catalogUrl }}" class="dm-see-all">Voir tout <i class="fa-solid fa-arrow-right"></i></a>
  </div>

  <div class="dm-cf">
    <button type="button" class="active" data-cat-id="all" onclick="filterCat(this,'all')">Tous</button>
    @foreach(($filterCategories ?? collect()) as $cat)
      <button type="button" data-cat-id="{{ $cat->id }}" onclick="filterCat(this,'{{ $cat->id }}')">{{ $cat->nom }}</button>
    @endforeach
  </div>

  <div class="dm-prods" id="prods-grid">
    @forelse(($featuredProducts ?? collect()) as $p)
      @php
        $catId = $p->categorie_id ?? '';
        $isNew = $p->created_at && $p->created_at->gt(now()->subDays(14));
      @endphp
      <div class="dm-prod" data-cat="{{ $catId }}">
        <div class="dm-prod-img">
          <a href="{{ route('public.products.show', $p) }}" style="display:block;height:100%">
            <img src="{{ $p->imageUrl() }}" alt="{{ $p->nom }}" loading="lazy">
          </a>
          @if($isNew)
            <span class="dm-prod-badge b-new">Nouveau</span>
          @endif
          <div class="dm-prod-acts">
            <button type="button" class="dm-prod-act" onclick="toggleWish(this)"><i class="fa-regular fa-heart"></i></button>
            <a href="{{ route('public.products.show', $p) }}" class="dm-prod-act"><i class="fa-regular fa-eye"></i></a>
          </div>
        </div>
        <div class="dm-prod-body">
          <div class="dm-prod-name"><a href="{{ route('public.products.show', $p) }}">{{ $p->nom }}</a></div>
          <div class="dm-prod-sub">{{ $p->categorie?->nom ?? 'Produit' }}</div>
          <div class="dm-prod-foot">
            <div><span class="dm-prod-price">{{ money_fdj($p->prix) }}</span></div>
            @auth
              @if(auth()->user()->type_compte === 'client')
                <a href="{{ route('buyer.products.show', $p) }}" class="dm-add"><i class="fa-solid fa-plus"></i></a>
              @else
                <a href="{{ route('public.products.show', $p) }}" class="dm-add"><i class="fa-solid fa-plus"></i></a>
              @endif
            @else
              <a href="{{ route('login') }}" class="dm-add"><i class="fa-solid fa-plus"></i></a>
            @endauth
          </div>
        </div>
      </div>
    @empty
      <p style="grid-column:1/-1;color:rgba(255,255,255,.35);padding:24px">Aucun produit actif pour le moment.</p>
    @endforelse
  </div>
</section>

<!-- ═══ CTA VENDEUR ═══ -->
<div class="dm-cta reveal">
  <div>
    <div class="dm-cta-tag">Programme vendeurs</div>
    <h2>Vendez vos produits<br>sur <span>NexShop</span></h2>
    <p>Rejoignez nos vendeurs locaux et atteignez des clients partout à Djibouti. Inscription gratuite.</p>
  </div>
  @if(auth()->check() && auth()->user()->type_compte === 'vendeur')
    <a href="{{ route('vendeur.home') }}" class="dm-cta-btn">Mon espace vendeur <i class="fa-solid fa-arrow-right"></i></a>
  @else
    <a href="{{ route('vendeur.inscription.index') }}" class="dm-cta-btn">Devenir vendeur <i class="fa-solid fa-arrow-right"></i></a>
  @endif
</div>

<!-- ═══ NEWSLETTER ═══ -->
<div class="dm-nl reveal" id="newsletter">
  <div>
    <div class="dm-nl-title">Restez informé</div>
    <div class="dm-nl-sub">Nouveautés, offres exclusives et actualités des vendeurs djiboutiens.</div>
  </div>
  <form class="dm-nl-form" id="nl-form" onsubmit="return handleNewsletter(event)">
    <input type="email" id="nl-email" placeholder="Votre adresse email" required>
    <button type="submit">S'inscrire</button>
  </form>
  <div id="nl-success" style="display:none;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:10px;padding:14px 20px;color:#22c55e;font-size:13px;font-weight:600;align-items:center;gap:8px">
    <i class="fa-solid fa-circle-check"></i> <span id="nl-msg"></span>
  </div>
</div>

<!-- ═══ À PROPOS ═══ -->
<section class="dm-info reveal" id="a-propos" style="background:var(--bg2)">
  <div class="dm-info-sub">Qui sommes-nous</div>
  <h2 class="dm-info-title"><i class="fa-solid fa-store"></i> À propos de NexShop</h2>
  <div class="dm-info-text" style="margin-bottom:32px">
    <strong>NexShop</strong> est la première marketplace 100 % djiboutienne qui connecte les vendeurs locaux aux acheteurs.
    Notre mission : rendre le commerce en ligne <strong>accessible, fiable et rapide</strong> pour tout Djibouti.<br><br>
    Fondée en 2026, NexShop permet à chaque vendeur de créer sa boutique en quelques minutes et à chaque client de découvrir des produits authentiques avec un paiement en espèces à la livraison.
  </div>
  <div class="dm-info-grid">
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-bullseye"></i> Notre mission</h4>
      <p>Démocratiser le e-commerce à Djibouti en offrant une plateforme sécurisée, simple et adaptée aux réalités locales.</p>
    </div>
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-shield-halved"></i> Confiance</h4>
      <p>Tous les vendeurs sont vérifiés (KYC). Chaque produit est validé avant publication pour garantir la qualité.</p>
    </div>
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-truck-fast"></i> Livraison locale</h4>
      <p>Livraison partout à Djibouti en 24h. Gratuite dès 10 000 Fdj. Paiement en espèces à la réception.</p>
    </div>
  </div>
</section>

<!-- ═══ CONTACT ═══ -->
@include('partials.welcome-contact')

<!-- ═══ CGV ═══ -->
<section class="dm-info reveal" id="cgv" style="background:var(--bg2)">
  <div class="dm-info-sub">Conditions générales</div>
  <h2 class="dm-info-title"><i class="fa-solid fa-file-contract"></i> Conditions Générales de Vente</h2>
  <div class="dm-info-grid" style="grid-template-columns:repeat(auto-fit,minmax(300px,1fr))">
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-cart-shopping"></i> Commandes</h4>
      <p>Toute commande passée sur NexShop est un engagement d'achat. Le paiement s'effectue en espèces à la livraison. La commande est confirmée dès que le vendeur l'accepte.</p>
    </div>
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-truck"></i> Livraison</h4>
      <p>Livraison sous 24h à Djibouti-ville. Gratuite pour les commandes supérieures à 10 000 Fdj. Le client est contacté avant la livraison.</p>
    </div>
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-rotate-left"></i> Retours & remboursements</h4>
      <p>Retour possible sous 5 jours après réception. Le produit doit être dans son état d'origine. L'admin contacte le vendeur pour traiter chaque demande.</p>
    </div>
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-user-shield"></i> Données personnelles</h4>
      <p>NexShop protège vos données conformément à la législation djiboutienne. Aucune donnée n'est partagée avec des tiers sans votre consentement.</p>
    </div>
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-ban"></i> Responsabilité</h4>
      <p>NexShop agit comme intermédiaire. Chaque vendeur est responsable de la qualité et de la conformité de ses produits. NexShop modère les avis et valide les produits.</p>
    </div>
    <div class="dm-info-card">
      <h4><i class="fa-solid fa-gavel"></i> Litiges</h4>
      <p>En cas de litige, contactez notre support. NexShop s'engage à résoudre tout différend dans un délai de 7 jours ouvrés en médiation avec le vendeur.</p>
    </div>
  </div>
</section>

<!-- ═══ AIDE / FAQ ═══ -->
<section class="dm-info reveal" id="aide" style="background:var(--bg)">
  <div class="dm-info-sub">Centre d'aide</div>
  <h2 class="dm-info-title"><i class="fa-solid fa-circle-question"></i> Aide & FAQ</h2>
  <div class="dm-faq">
    <div class="dm-faq-item">
      <button class="dm-faq-q" onclick="this.parentElement.classList.toggle('open')">Comment passer une commande ? <i class="fa-solid fa-chevron-down"></i></button>
      <div class="dm-faq-a">Parcourez les produits, ajoutez-les au panier, puis validez votre commande en indiquant votre adresse de livraison. Le paiement se fait en espèces à la réception.</div>
    </div>
    <div class="dm-faq-item">
      <button class="dm-faq-q" onclick="this.parentElement.classList.toggle('open')">Comment demander un retour ? <i class="fa-solid fa-chevron-down"></i></button>
      <div class="dm-faq-a">Rendez-vous dans « Mes commandes », ouvrez la commande livrée, puis cliquez sur « Demander un retour ». Vous avez 5 jours après la livraison. L'administrateur contactera le vendeur pour traiter votre demande.</div>
    </div>
    <div class="dm-faq-item">
      <button class="dm-faq-q" onclick="this.parentElement.classList.toggle('open')">Quels sont les modes de paiement ? <i class="fa-solid fa-chevron-down"></i></button>
      <div class="dm-faq-a">NexShop propose le paiement en espèces à la livraison. C'est simple, sécurisé et sans frais supplémentaires.</div>
    </div>
    <div class="dm-faq-item">
      <button class="dm-faq-q" onclick="this.parentElement.classList.toggle('open')">La livraison est-elle gratuite ? <i class="fa-solid fa-chevron-down"></i></button>
      <div class="dm-faq-a">Oui, la livraison est gratuite pour toute commande d'un montant supérieur à 10 000 Fdj. En dessous, des frais de livraison peuvent s'appliquer.</div>
    </div>
    <div class="dm-faq-item">
      <button class="dm-faq-q" onclick="this.parentElement.classList.toggle('open')">Comment devenir vendeur sur NexShop ? <i class="fa-solid fa-chevron-down"></i></button>
      <div class="dm-faq-a">Cliquez sur « Devenir vendeur » et suivez les 3 étapes : créer un compte, vérifier votre identité (KYC), puis créer votre boutique. L'inscription est gratuite avec un plan Free (10 commandes/mois).</div>
    </div>
    <div class="dm-faq-item">
      <button class="dm-faq-q" onclick="this.parentElement.classList.toggle('open')">Comment contacter le support NexShop ? <i class="fa-solid fa-chevron-down"></i></button>
      <div class="dm-faq-a">Utilisez le formulaire de contact ci-dessus, envoyez un email à nexshop.dj@gmail.com ou appelez le +253 77 44 78 73 (Sam–Jeu, 8h–20h).</div>
    </div>
    <div class="dm-faq-item">
      <button class="dm-faq-q" onclick="this.parentElement.classList.toggle('open')">Mon compte peut-il être suspendu ? <i class="fa-solid fa-chevron-down"></i></button>
      <div class="dm-faq-a">Un compte peut être suspendu en cas de non-respect des CGV, de fraude ou d'abus signalé. Vous serez toujours notifié par email avec la raison.</div>
    </div>
  </div>
</section>

<!-- ═══ FOOTER ═══ -->
<footer class="dm-footer">
  <div class="dm-footer-top">
    <div class="dm-f-brand">
      <div class="dm-f-logo">Nex<span>Shop</span></div>
      <p class="dm-f-desc">La marketplace qui connecte acheteurs et vendeurs. Paiement en espèces, livraison rapide.</p>
      <div class="dm-f-socials">
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-tiktok"></i></a>
        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
      </div>
    </div>
    <div class="dm-f-col">
      <h4>Navigation</h4>
      <a href="#">Accueil</a>
      <a href="{{ $catalogUrl }}">Produits</a>
      @auth
        @if(auth()->user()->type_compte === 'client')
          <a href="{{ route('buyer.cart.index') }}">Panier</a>
          <a href="{{ route('buyer.orders.index') }}">Mes commandes</a>
        @endif
      @else
        <a href="{{ route('login') }}">Panier</a>
        <a href="{{ route('login') }}">Mes commandes</a>
      @endauth
    </div>
    <div class="dm-f-col">
      <h4>Informations</h4>
      <a href="#a-propos">À propos</a>
      <a href="#cgv">Politique de livraison</a>
      <a href="#cgv">CGU & CGV</a>
      <a href="#cgv">Confidentialité</a>
    </div>
  </div>
  <div class="dm-footer-bottom">
    <div class="dm-f-copy">© 2026 NexShop — Djibouti. Tous droits réservés.</div>
    <div class="dm-f-bottom-links">
      <a href="#cgv">CGV</a>
      <a href="#aide">Aide</a>
      <a href="#contact">Contact</a>
    </div>
  </div>
</footer>

<div class="toast" id="toast"><i class="fa-solid fa-circle-check"></i><span id="tmsg">Action effectuée</span></div>

<script>
function toggleDrawer(){document.getElementById('drawer').classList.toggle('open');document.getElementById('overlay').classList.toggle('open')}

function applyCatFilter(cat){
  const grid=document.getElementById('prods-grid');
  if(!grid)return;
  grid.querySelectorAll('.dm-prod').forEach(card=>{
    const c=card.dataset.cat||'';
    card.style.display=(cat==='all'||String(c)===String(cat))?'':'none';
  });
}
function filterCat(btn,cat){
  document.querySelectorAll('.dm-cf button').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  applyCatFilter(cat);
}
document.querySelectorAll('[data-cat-trigger]').forEach(el=>{
  el.addEventListener('click',e=>{
    const id=el.dataset.catTrigger;
    if(id===undefined||id==='')return;
    e.preventDefault();
    const b=document.querySelector('.dm-cf button[data-cat-id="'+id+'"]');
    if(b)filterCat(b,id);
    else{
      document.querySelectorAll('.dm-cf button').forEach(x=>x.classList.remove('active'));
      applyCatFilter(id);
    }
    document.getElementById('prods-grid')?.scrollIntoView({behavior:'smooth',block:'start'});
  });
});

function handleContact(e){
  e.preventDefault();
  var btn=document.getElementById('ct-btn');
  btn.disabled=true;btn.innerHTML='<i class="fa-solid fa-spinner fa-spin"></i> Envoi…';
  fetch('/contact',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||''},body:JSON.stringify({nom:document.getElementById('ct-nom').value,email:document.getElementById('ct-email').value,sujet:document.getElementById('ct-sujet').value,message:document.getElementById('ct-message').value})})
  .then(function(r){return r.json()})
  .then(function(d){
    document.getElementById('contact-form').style.display='none';
    document.getElementById('ct-success').style.display='flex';
  })
  .catch(function(){btn.disabled=false;btn.innerHTML='<i class="fa-solid fa-paper-plane"></i> Envoyer';showToast('Erreur, veuillez réessayer.');});
  return false;
}

function handleNewsletter(e){
  e.preventDefault();
  var email=document.getElementById('nl-email').value.trim();
  if(!email)return false;
  fetch('/newsletter',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.content||''},body:JSON.stringify({email:email})})
  .then(function(r){return r.json()})
  .then(function(d){
    document.getElementById('nl-form').style.display='none';
    var box=document.getElementById('nl-success');box.style.display='flex';
    document.getElementById('nl-msg').textContent=d.message||'Merci ! Vous êtes inscrit à la newsletter.';
  })
  .catch(function(){
    showToast('Erreur, veuillez réessayer.');
  });
  return false;
}

function toggleWish(btn){const i=btn.querySelector('i');const a=btn.classList.toggle('active');i.className=a?'fa-solid fa-heart':'fa-regular fa-heart';showToast(a?'Ajouté aux favoris':'Retiré des favoris')}
let tt;
function showToast(m){const t=document.getElementById('toast');document.getElementById('tmsg').textContent=m;t.classList.add('show');clearTimeout(tt);tt=setTimeout(()=>t.classList.remove('show'),2800)}

const obs=new IntersectionObserver(e=>e.forEach((el,i)=>{if(el.isIntersecting)setTimeout(()=>el.target.classList.add('visible'),i*80)}),{threshold:.1});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));
</script>
</body>
</html>