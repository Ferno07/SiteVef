<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #1e3a8a; padding: 30px 40px; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .header p { color: #bfdbfe; margin: 6px 0 0; font-size: 14px; }
        .body { padding: 40px; }
        .field { margin-bottom: 18px; }
        .field label { display: block; font-size: 12px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .field value { display: block; font-size: 15px; color: #111827; }
        .badge { display: inline-block; padding: 4px 12px; background: #dbeafe; color: #1d4ed8; border-radius: 999px; font-size: 13px; font-weight: bold; }
        .message-box { background: #f9fafb; border-left: 4px solid #1e3a8a; padding: 16px 20px; border-radius: 4px; color: #374151; line-height: 1.7; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .footer { background: #f9fafb; padding: 20px 40px; border-top: 1px solid #e5e7eb; text-align: center; }
        .footer p { color: #9ca3af; font-size: 12px; margin: 0; }
        .btn { display: inline-block; margin-top: 20px; padding: 12px 24px; background: #1e3a8a; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Nouvelle candidature reçue</h1>
        <p>Verre d'Eau Fraîche — {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
    <div class="body">
        <div class="grid">
            <div class="field">
                <label>Nom complet</label>
                <value>{{ $candidature->candidature_prenom }} {{ $candidature->candidature_nom }}</value>
            </div>
            <div class="field">
                <label>Type de participation</label>
                <span class="badge">{{ ucfirst($candidature->candidature_typeParticipation) }}</span>
            </div>
            <div class="field">
                <label>Email</label>
                <value><a href="mailto:{{ $candidature->candidature_email }}">{{ $candidature->candidature_email }}</a></value>
            </div>
            <div class="field">
                <label>Téléphone</label>
                <value>{{ $candidature->candidature_telephone }}</value>
            </div>
            <div class="field">
                <label>Date de naissance</label>
                <value>{{ \Carbon\Carbon::parse($candidature->candidature_dateNaissance)->format('d/m/Y') }}</value>
            </div>
            <div class="field">
                <label>Préférence d'action</label>
                <value>{{ ucfirst($candidature->candidature_preferenceAction) }}</value>
            </div>
        </div>
        <div class="field">
            <label>Adresse</label>
            <value>{{ $candidature->candidature_adresse }}</value>
        </div>
        <div class="field">
            <label>Disponibilités</label>
            <value>{{ $candidature->candidature_disponibilites }}</value>
        </div>
        <div class="field">
            <label>Lettre de motivation</label>
            <div class="message-box">{{ $candidature->candidature_motivation }}</div>
        </div>
        <a href="{{ url('/administrateur') }}" class="btn">Voir dans le dashboard admin</a>
    </div>
    <div class="footer">
        <p>Cette candidature a été soumise depuis le site <strong>verredeaufraiche.org</strong></p>
    </div>
</div>
</body>
</html>
