@extends('admin.contact_messages.layout')

@section('contact-messages-content')
<div style="margin-bottom:20px">
  <a href="{{ route('admin.contact-messages.index') }}" style="font-size:13px;color:var(--muted);display:inline-flex;align-items:center;gap:6px;margin-bottom:12px"><i class="fa-solid fa-arrow-left"></i> Liste des messages</a>
  <h1 class="page-title">{{ $contact_message->nom }}</h1>
  <p class="page-sub"><a href="mailto:{{ $contact_message->email }}" style="color:var(--blue)">{{ $contact_message->email }}</a>
    · {{ $contact_message->created_at->translatedFormat('d F Y à H:i') }}</p>
</div>

@if($contact_message->sujet)
  <div class="card" style="margin-bottom:16px">
    <div class="card-head"><div class="card-title">Sujet</div></div>
    <div class="card-body">{{ $contact_message->sujet }}</div>
  </div>
@endif

<div class="card">
  <div class="card-head"><div class="card-title">Message</div></div>
  <div class="card-body" style="white-space:pre-wrap;line-height:1.6">{{ $contact_message->message }}</div>
</div>
@endsection
