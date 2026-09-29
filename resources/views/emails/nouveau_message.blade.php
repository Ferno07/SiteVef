<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: #2563eb; padding: 30px 40px; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .header p { color: #bfdbfe; margin: 6px 0 0; font-size: 14px; }
        .body { padding: 40px; }
        .field { margin-bottom: 20px; }
        .field label { display: block; font-size: 12px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .field value { display: block; font-size: 15px; color: #111827; }
        .message-box { background: #f9fafb; border-left: 4px solid #2563eb; padding: 16px 20px; border-radius: 4px; color: #374151; line-height: 1.7; }
        .footer { background: #f9fafb; padding: 20px 40px; border-top: 1px solid #e5e7eb; text-align: center; }
        .footer p { color: #9ca3af; font-size: 12px; margin: 0; }
        .btn { display: inline-block; margin-top: 20px; padding: 12px 24px; background: #2563eb; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Nouveau message de contact</h1>
        <p>Verre d'Eau Fraîche — {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
    <div class="body">
        <div class="field">
            <label>De</label>
            <value>{{ $contactMessage->prenom }} {{ $contactMessage->nom }}</value>
        </div>
        <div class="field">
            <label>Email</label>
            <value><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></value>
        </div>
        <div class="field">
            <label>Objet</label>
            <value>{{ $contactMessage->objet }}</value>
        </div>
        <div class="field">
            <label>Message</label>
            <div class="message-box">{{ $contactMessage->message }}</div>
        </div>
        <a href="{{ url('/administrateur') }}" class="btn">Voir dans le dashboard admin</a>
    </div>
    <div class="footer">
        <p>Ce message a été envoyé depuis le formulaire de contact du site <strong>verredeaufraiche.org</strong></p>
    </div>
</div>
</body>
</html>
