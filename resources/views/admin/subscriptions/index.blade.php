<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.theme-init')
    <title>Admin — Abonnements vendeurs</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700;800&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root{--bg:#0D0D0D;--bg2:#141414;--bd:rgba(255,255,255,.1);--txt:#F0F0F0;--muted:#9CA3AF;--orange:#FF6B35;--ok:#22C55E;--danger:#EF4444}
        body{margin:0;background:var(--bg);color:var(--txt);font-family:Inter,sans-serif}.wrap{max-width:1100px;margin:28px auto;padding:0 16px}
        h1{font-family:"Space Grotesk",sans-serif;margin:0 0 8px}
        .nav{margin-bottom:20px}a{color:#FDBA74;text-decoration:none;font-size:14px}
        .ok{background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.3);padding:10px;border-radius:10px;color:#86EFAC;margin-bottom:10px}
        .err{background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.3);padding:10px;border-radius:10px;color:#FCA5A5;margin-bottom:10px}
        table{width:100%;border-collapse:collapse;background:var(--bg2);border:1px solid var(--bd);border-radius:12px;overflow:hidden;margin-bottom:24px}
        th,td{padding:12px;border-bottom:1px solid rgba(255,255,255,.06);text-align:left;font-size:13px} th{color:var(--muted);font-size:11px;text-transform:uppercase}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;border:none;font-weight:700;cursor:pointer;font-size:12px;font-family:"Space Grotesk",sans-serif}
        .btn-ok{background:var(--ok);color:#052e16}
        .btn-no{background:transparent;border:1px solid var(--danger);color:var(--danger)}
        textarea{width:100%;min-height:48px;background:#111;border:1px solid var(--bd);border-radius:8px;color:var(--txt);padding:8px;font-family:inherit;font-size:12px;margin-top:6px}
        h2{font-family:"Space Grotesk",sans-serif;font-size:16px;margin:24px 0 12px;color:var(--muted)}
    </style>
    @include('partials.theme-manager')
</head>
<body>
<div style="display:flex;justify-content:space-between;align-items:center;padding:12px 16px 0;background:var(--bg)">
    <a href="{{ route('admin.home') }}">← Retour admin</a>
    <button type="button" class="theme-toggle" data-theme-toggle aria-pressed="false"><i class="fa-regular fa-moon" aria-hidden="true"></i><span class="theme-toggle-label">Thème</span></button>
</div>
<div class="wrap">
    <h1>Abonnements vendeurs</h1>
    <p style="color:var(--muted);margin:0 0 16px;font-size:14px">Validez les paiements D‑Money ou en espèce (Pro 5 000 FDJ / mois, Premium 10 000 FDJ / mois — 30 jours).</p>

    @if(session('success'))<div class="ok">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="err">{{ session('error') }}</div>@endif

    <h2>En attente de validation</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Vendeur</th>
                <th>Plan</th>
                <th>Montant</th>
                <th>Méthode</th>
                <th>Réf. client</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($pending as $p)
            <tr>
                <td>{{ $p->created_at?->format('d/m/Y H:i') }}</td>
                <td>{{ $p->user?->nom }}<br><small style="color:var(--muted)">{{ $p->user?->email }}</small></td>
                <td><strong>{{ strtoupper($p->plan) }}</strong></td>
                <td>{{ number_format($p->amount_fdj, 0, ',', ' ') }} FDJ</td>
                <td>{{ $p->payment_method === 'dmoney' ? 'D‑Money' : 'En espèce' }}</td>
                <td>{{ $p->buyer_reference ?: '—' }}</td>
                <td style="vertical-align:top">
                    <form action="{{ route('admin.subscriptions.approve', $p) }}" method="POST" style="margin-bottom:8px">
                        @csrf
                        <textarea name="admin_notes" placeholder="Notes (optionnel)"></textarea>
                        <button type="submit" class="btn btn-ok" style="margin-top:6px"><i class="fa-solid fa-check"></i> Approuver</button>
                    </form>
                    <form action="{{ route('admin.subscriptions.reject', $p) }}" method="POST" onsubmit="return confirm('Rejeter cette demande ?')">
                        @csrf
                        <textarea name="admin_notes" placeholder="Motif du refus"></textarea>
                        <button type="submit" class="btn btn-no" style="margin-top:6px"><i class="fa-solid fa-xmark"></i> Rejeter</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:24px">Aucune demande en attente.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($pending->hasPages())
        <div style="margin-bottom:24px">{{ $pending->links() }}</div>
    @endif

    <h2>Dernières décisions</h2>
    <table>
        <thead>
            <tr><th>Date</th><th>Vendeur</th><th>Plan</th><th>Statut</th><th>Admin</th></tr>
        </thead>
        <tbody>
        @forelse($recent as $p)
            <tr>
                <td>{{ $p->processed_at?->format('d/m/Y H:i') }}</td>
                <td>{{ $p->user?->email }}</td>
                <td>{{ strtoupper($p->plan) }}</td>
                <td>{{ $p->status === 'paid' ? 'Payé' : 'Rejeté' }}</td>
                <td>{{ $p->processor?->nom ?? '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:var(--muted)">Aucun historique.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
