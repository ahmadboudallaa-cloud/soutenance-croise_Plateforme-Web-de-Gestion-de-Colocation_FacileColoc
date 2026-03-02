<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invitation EasyColoc</title>
</head>
<body>
    <p>Bonjour,</p>

    <p>Vous avez été invité à rejoindre la colocation <strong>{{ $invitation->colocation->name }}</strong>.</p>

    <p>Cliquez sur ce lien pour accepter ou refuser :</p>

    <p>
        <a href="{{ route('invitations.show', $invitation->token) }}">
            {{ route('invitations.show', $invitation->token) }}
        </a>
    </p>

    <p>Si vous n’êtes pas concerné, ignorez cet email.</p>

    <p>— EasyColoc</p>
</body>
</html>
