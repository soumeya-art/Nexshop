@component('mail::message')
# Dossier rejete

Bonjour {{ $user->nom }},

Votre dossier KYC a ete rejete.

Motif: **{{ $motif }}**

Vous pouvez corriger et resoumettre vos documents.
@endcomponent
