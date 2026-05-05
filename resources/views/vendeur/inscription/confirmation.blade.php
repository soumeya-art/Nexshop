<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription envoyee</title>
    <style>
        :root{--bg:#0D0D0D;--bg2:#141414;--bd:rgba(255,255,255,.1);--txt:#F0F0F0;--muted:#9CA3AF;--orange:#FF6B35}
        body{margin:0;background:var(--bg);font-family:Inter,sans-serif;color:var(--txt);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .card{max-width:660px;width:100%;background:var(--bg2);border:1px solid var(--bd);border-radius:16px;padding:30px;text-align:center}
        h1{font-family:"Space Grotesk",sans-serif;margin:10px 0 8px}.p{color:var(--muted);line-height:1.7}
        .ico{font-size:60px}
        a{display:inline-block;margin-top:18px;background:var(--orange);color:#fff;text-decoration:none;padding:12px 16px;border-radius:10px;font-weight:700}
    </style>
</head>
<body>
    <div class="card">
        <div class="ico">✅</div>
        <h1>Inscription terminee</h1>
        <p class="p">Votre dossier est en cours de verification. Notre equipe traite votre demande sous 24h et vous notifiera par email.</p>
        <a href="{{ route('vendeur.attente') }}">Voir ma page d'attente</a>
    </div>
</body>
</html>
