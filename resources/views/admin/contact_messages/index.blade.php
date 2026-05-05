@extends('admin.contact_messages.layout')

@section('contact-messages-content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
  <div>
    <h1 class="page-title">Messages — formulaire contact</h1>
    <p class="page-sub">Messages reçus depuis la page d’accueil (aucun envoi email).</p>
  </div>
  @if($nonLus > 0)
    <span style="background:rgba(255,107,53,.12);border:1px solid rgba(255,107,53,.28);color:var(--orange);padding:6px 14px;border-radius:50px;font-size:12px;font-weight:700;font-family:'Space Grotesk',sans-serif">{{ $nonLus }} non lu(s)</span>
  @endif
</div>

@if($messages->isEmpty())
  <div style="text-align:center;padding:60px 20px;color:var(--muted)">
    <i class="fa-solid fa-inbox" style="font-size:40px;opacity:.3;margin-bottom:16px;display:block"></i>
    <p>Aucun message pour le moment.</p>
  </div>
@else
  <div class="card">
    <div class="card-body" style="padding:0">
      <table class="table">
        <thead>
          <tr>
            <th>État</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Sujet</th>
            <th>Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($messages as $m)
            <tr style="{{ !$m->lu ? 'background:rgba(255,107,53,.06)' : '' }}">
              <td>
                @if($m->lu)
                  <span class="status-badge inactif">Lu</span>
                @else
                  <span class="status-badge" style="background:rgba(245,158,11,.1);color:var(--warning);border:1px solid rgba(245,158,11,.22)">Nouveau</span>
                @endif
              </td>
              <td style="font-weight:600">{{ $m->nom }}</td>
              <td><a href="mailto:{{ $m->email }}" style="color:var(--blue)">{{ $m->email }}</a></td>
              <td style="color:var(--muted)">{{ $m->sujet ? \Illuminate\Support\Str::limit($m->sujet, 40) : '—' }}</td>
              <td style="font-size:11px;color:var(--muted)">{{ $m->created_at->format('d/m/Y H:i') }}</td>
              <td>
                <a href="{{ route('admin.contact-messages.show', $m) }}" class="tbl-btn" title="Ouvrir"><i class="fa-solid fa-eye"></i></a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @if($messages->hasPages())
      <div class="table-foot">
        <span>{{ $messages->total() }} message(s)</span>
        {{ $messages->links() }}
      </div>
    @endif
  </div>
@endif
@endsection
