<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réception</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fffef2;
            color: #0d0c43;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(13, 12, 67, 0.08);
        }

        .email-header {
            background-color: #0d0c43;
            color: #feed02;
            padding: 24px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .email-body {
            padding: 32px 24px;
            line-height: 1.6;
        }

        .email-body p {
            margin-bottom: 16px;
            font-size: 15px;
        }

        .highlight {
            color: #0da3d8;
            font-weight: 600;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 20px 24px;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            display: inline-block;
            background-color: #feed02;
            color: #0d0c43;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Akany Tia Zaza Madagascar</h1>
        </div>

        <div class="email-body">
            <p>Bonjour <span class="highlight">{{ $userName }}</span>,</p>

            <p>Nous accusons bonne réception de votre message. Toute l'équipe d'Akany Tia Zaza vous remercie pour
                l'intérêt que vous portez à nos actions.</p>

            <p>Un membre de notre équipe de Communication (CM) a bien pris en compte votre demande et s'engage à vous
                répondre dans les plus brefs délais (généralement sous 24 à 48 heures).</p>

            <p>En attendant, n'hésitez pas à consulter nos dernières actualités sur notre site web.</p>

            <p style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/fr') }}" class="btn">Visiter notre site</a>
            </p>
        </div>

        <div class="email-footer">
            <p>Ce message a été envoyé automatiquement. Merci de ne pas y répondre directement.</p>
            <p>© {{ date('Y') }} Akany Tia Zaza Madagascar. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>
