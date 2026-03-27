@extends('buyer.layout')

@section('title', 'Mon profil')

@section('content')
<main>
  <div class="sec-row">
    <div>
      <div class="sec-title">Mon profil</div>
      <div class="sec-sub">Modifiez vos informations personnelles.</div>
    </div>
  </div>

  <div style="max-width: 640px;">
    <div class="contact-form-wrap" style="margin-bottom: 32px;">
      <div class="f-col-title" style="margin-bottom: 20px;">Informations personnelles</div>
      <form action="{{ route('buyer.profile.update') }}" method="post" class="contact-form">
        @csrf
        @method('PUT')
        <div class="form-row">
          <div class="form-group">
            <label>Nom complet</label>
            <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" placeholder="Votre nom" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="votre@email.com" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" placeholder="06 00 00 00 00">
          </div>
          <div class="form-group">
            <label>Adresse</label>
            <input type="text" name="adresse" value="{{ old('adresse', $user->adresse) }}" placeholder="Adresse postale">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Ville</label>
            <input type="text" name="ville" value="{{ old('ville', $user->ville) }}" placeholder="Ville">
          </div>
          <div class="form-group">
            <label>Code postal</label>
            <input type="text" name="code_postal" value="{{ old('code_postal', $user->code_postal) }}" placeholder="Code postal">
          </div>
        </div>
        <button type="submit" class="btn-primary"><i class="fa-solid fa-check"></i> Enregistrer les modifications</button>
      </form>
    </div>

    <div class="contact-form-wrap">
      <div class="f-col-title" style="margin-bottom: 20px;">Changer le mot de passe</div>
      <form action="{{ route('buyer.profile.password') }}" method="post" class="contact-form">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label>Mot de passe actuel</label>
          <input type="password" name="current_password" placeholder="••••••••" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Nouveau mot de passe</label>
            <input type="password" name="password" placeholder="••••••••" required minlength="8">
          </div>
          <div class="form-group">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" placeholder="••••••••" required minlength="8">
          </div>
        </div>
        <button type="submit" class="btn-primary"><i class="fa-solid fa-lock"></i> Modifier le mot de passe</button>
      </form>
    </div>
  </div>
</main>
@endsection
