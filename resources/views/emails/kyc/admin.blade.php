@component('mail::message')
# Nouveau dossier KYC

Un vendeur a soumis ses documents.

- Nom: **{{ $user->nom }}**
- Email: **{{ $user->email }}**

@component('mail::button', ['url' => route('admin.kyc.show', $user)])
Voir le dossier
@endcomponent
@endcomponent
