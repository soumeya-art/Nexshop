@extends('buyer.layout')

@section('title', 'Mon profil')

@push('styles')
<style>
.profile-edit{--pe-radius:14px;--pe-inset:rgba(255,107,53,.06);max-width:720px;margin:0 auto;padding-bottom:calc(28px + env(safe-area-inset-bottom,0px))}
.profile-edit-hero{
  display:flex;align-items:center;gap:22px;margin-bottom:28px;padding:24px 26px;border-radius:var(--pe-radius);
  background:linear-gradient(135deg,rgba(255,107,53,.12) 0%,rgba(20,20,20,.92) 45%,var(--bg2) 100%);
  border:1px solid var(--border);position:relative;overflow:hidden}
.profile-edit-hero::after{content:'';position:absolute;inset:auto -20% -60% auto;width:280px;height:280px;background:radial-gradient(circle,rgba(255,107,53,.18),transparent 70%);pointer-events:none}
.profile-edit-hero-avatar{width:76px;height:76px;border-radius:50%;border:3px solid rgba(255,107,53,.45);overflow:hidden;flex-shrink:0;box-shadow:0 8px 28px rgba(0,0,0,.35);position:relative;z-index:1}
.profile-edit-hero-avatar img{width:100%;height:100%;object-fit:cover}
.profile-edit-hero-body{position:relative;z-index:1;min-width:0}
.profile-edit-hero-tag{display:inline-flex;align-items:center;gap:6px;font-size:10px;font-weight:700;font-family:'Space Grotesk',sans-serif;letter-spacing:.1em;text-transform:uppercase;color:var(--orange);margin-bottom:6px}
.profile-edit-hero-title{font-family:'Space Grotesk',sans-serif;font-size:1.55rem;font-weight:800;color:var(--white);line-height:1.15;margin:0 0 4px}
.profile-edit-hero-mail{font-size:13px;color:var(--muted);word-break:break-all}
.profile-edit-sec{margin-bottom:10px}
.profile-card{
  background:var(--bg2);border:1px solid var(--border);border-radius:var(--pe-radius);margin-bottom:20px;
  box-shadow:0 4px 24px rgba(0,0,0,.2)}
.profile-card-hd{display:flex;align-items:flex-start;gap:14px;padding:20px 22px 16px;border-bottom:1px solid var(--border);background:rgba(255,107,53,.03)}
.profile-card-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:var(--pe-inset);border:1px solid rgba(255,107,53,.2);color:var(--orange);font-size:17px;flex-shrink:0}
.profile-card-titles{min-width:0}
.profile-card-title{font-family:'Space Grotesk',sans-serif;font-size:1rem;font-weight:800;color:var(--white);margin:0 0 4px;letter-spacing:-.02em}
.profile-card-sub{font-size:12px;color:var(--muted);line-height:1.45;margin:0}
.profile-card-bd{padding:22px}
.profile-fields{display:flex;flex-direction:column;gap:20px}
.profile-field{display:flex;flex-direction:column;gap:8px}
.profile-field label{
  font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.07em;display:flex;align-items:center;gap:8px}
.profile-field label i{font-size:11px;opacity:.7;color:var(--orange)}
.profile-field input{
  width:100%;background:var(--bg3);border:1.5px solid var(--border);border-radius:11px;padding:11px 14px;color:var(--white);
  font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s,box-shadow .2s}
.profile-field input::placeholder{color:var(--muted2)}
.profile-field input:hover{border-color:var(--border2)}
.profile-field input:focus{border-color:rgba(255,107,53,.55);box-shadow:0 0 0 3px rgba(255,107,53,.12)}
.profile-fieldgrid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
@media(max-width:600px){.profile-fieldgrid{grid-template-columns:1fr}}
.profile-divider{display:flex;align-items:center;gap:12px;margin:4px 0 2px;color:var(--muted2);font-size:11px;font-weight:700;font-family:'Space Grotesk',sans-serif;text-transform:uppercase;letter-spacing:.08em}
.profile-divider::before,.profile-divider::after{content:'';flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent)}
.profile-card-ft{padding:0 22px 22px;display:flex;flex-wrap:wrap;gap:12px;align-items:center}
.profile-btn-submit{
  display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:12px 24px;border-radius:11px;border:none;
  font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:transform .15s,box-shadow .2s,background .2s;
  background:linear-gradient(165deg,#FF7A47,var(--orange));color:#fff;box-shadow:0 4px 18px rgba(255,107,53,.35)}
.profile-btn-submit:hover{transform:translateY(-1px);box-shadow:0 8px 26px rgba(255,107,53,.42)}
.profile-btn-submit:active{transform:translateY(0)}
.profile-btn-submit.profile-btn--dark{background:linear-gradient(165deg,#3a3a42,#252528);box-shadow:0 4px 18px rgba(0,0,0,.4)}
.profile-btn-submit.profile-btn--dark:hover{box-shadow:0 8px 24px rgba(0,0,0,.45)}
.profile-hint{font-size:12px;color:var(--muted);margin:0;line-height:1.4}
.profile-card--security .profile-card-hd{background:rgba(239,68,68,.04);border-bottom-color:rgba(239,68,68,.08)}
.profile-card--security .profile-card-icon{border-color:rgba(239,68,68,.22);background:rgba(239,68,68,.06);color:#f87171}
@media(max-width:640px){
  .profile-edit-hero{flex-direction:column;text-align:center;padding:22px 18px}
  .profile-edit-hero-avatar{width:72px;height:72px}
  .profile-card-hd,.profile-card-bd,.profile-card-ft{padding-left:18px;padding-right:18px}
}
.profile-edit-hero-avatar:hover div{opacity:1 !important}
@media(max-width:400px){.profile-field input{font-size:16px}}
</style>
@endpush

@section('content')
<main class="profile-edit">
  <div class="sec-row profile-edit-sec">
    <div>
      <h1 class="sec-title">Mon profil</h1>
      <div class="sec-sub">Informations utilisées pour vos commandes et la messagerie.</div>
    </div>
  </div>

  <header class="profile-edit-hero">
    <label for="avatar-input" class="profile-edit-hero-avatar" style="cursor:pointer;position:relative" title="Changer la photo">
      <img id="avatar-preview" src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->nom).'&background=FF6B35&color=fff&size=160' }}" alt="">
      <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.4);opacity:0;transition:opacity .2s;border-radius:50%"><i class="fa-solid fa-camera" style="color:#fff;font-size:18px"></i></div>
    </label>
    <div class="profile-edit-hero-body">
      <div class="profile-edit-hero-tag"><i class="fa-solid fa-circle-check"></i> Compte actif</div>
      <p class="profile-edit-hero-title">{{ $user->nom }}</p>
      <p class="profile-edit-hero-mail">{{ $user->email }}</p>
    </div>
  </header>

  <section class="profile-card" aria-labelledby="profile-identite">
    <div class="profile-card-hd">
      <div class="profile-card-icon" aria-hidden="true"><i class="fa-regular fa-id-card"></i></div>
      <div class="profile-card-titles">
        <h2 id="profile-identite" class="profile-card-title">Identité &amp; contact</h2>
        <p class="profile-card-sub">Ces données nous permettent de vous joindre concernant vos achats.</p>
      </div>
    </div>
    <form action="{{ route('buyer.profile.update') }}" method="post" class="profile-card-bd" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display:none" onchange="previewAvatar(this)">
      <div class="profile-fields">
        <div class="profile-fieldgrid">
          <div class="profile-field">
            <label for="nom"><i class="fa-regular fa-user"></i> Nom complet</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" placeholder="Prénom et nom" required autocomplete="name">
          </div>
          <div class="profile-field">
            <label for="email"><i class="fa-regular fa-envelope"></i> Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="vous@exemple.com" required autocomplete="email">
          </div>
        </div>
        <div class="profile-divider">Coordonnées</div>
        <div class="profile-field">
          <label for="telephone"><i class="fa-solid fa-phone"></i> Téléphone</label>
          <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}" placeholder="Ex. 77 00 00 00" autocomplete="tel">
        </div>
        <div class="profile-field">
          <label for="adresse"><i class="fa-solid fa-location-dot"></i> Adresse</label>
          <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $user->adresse) }}" placeholder="Rue, quartier…" autocomplete="street-address">
        </div>
        <div class="profile-fieldgrid">
          <div class="profile-field">
            <label for="ville"><i class="fa-solid fa-city"></i> Ville</label>
            <input type="text" id="ville" name="ville" value="{{ old('ville', $user->ville) }}" placeholder="Ville" autocomplete="address-level2">
          </div>
          <div class="profile-field">
            <label for="code_postal"><i class="fa-regular fa-envelope-open"></i> Code postal</label>
            <input type="text" id="code_postal" name="code_postal" value="{{ old('code_postal', $user->code_postal) }}" placeholder="CP" autocomplete="postal-code">
          </div>
        </div>
      </div>
      <div class="profile-card-ft">
        <button type="submit" class="profile-btn-submit"><i class="fa-solid fa-check"></i> Enregistrer les modifications</button>
      </div>
    </form>
  </section>

  <section class="profile-card profile-card--security" aria-labelledby="profile-mdp">
    <div class="profile-card-hd">
      <div class="profile-card-icon" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></div>
      <div class="profile-card-titles">
        <h2 id="profile-mdp" class="profile-card-title">Sécurité du compte</h2>
        <p class="profile-card-sub">Choisissez un mot de passe d’au moins 8 caractères, idéalement unique à NexShop.</p>
      </div>
    </div>
    <form action="{{ route('buyer.profile.password') }}" method="post" class="profile-card-bd">
      @csrf
      @method('PUT')
      <div class="profile-fields">
        <div class="profile-field">
          <label for="current_password"><i class="fa-solid fa-key"></i> Mot de passe actuel</label>
          <input type="password" id="current_password" name="current_password" placeholder="Saisissez votre mot de passe actuel" required autocomplete="current-password">
        </div>
        <div class="profile-fieldgrid">
          <div class="profile-field">
            <label for="password"><i class="fa-solid fa-lock"></i> Nouveau mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Minimum 8 caractères" required minlength="8" autocomplete="new-password">
          </div>
          <div class="profile-field">
            <label for="password_confirmation"><i class="fa-solid fa-lock-open"></i> Confirmation</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Répétez le nouveau mot de passe" required minlength="8" autocomplete="new-password">
          </div>
        </div>
      </div>
      <div class="profile-card-ft">
        <button type="submit" class="profile-btn-submit profile-btn--dark">
          <i class="fa-solid fa-lock"></i> Mettre à jour le mot de passe
        </button>
        <p class="profile-hint">Après modification, utilisez ce nouveau mot de passe pour vos prochaines connexions.</p>
      </div>
    </form>
  </section>
</main>
@endsection

@push('scripts')
<script>
function previewAvatar(input){
  if(input.files&&input.files[0]){
    var r=new FileReader();
    r.onload=function(e){document.getElementById('avatar-preview').src=e.target.result};
    r.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush
