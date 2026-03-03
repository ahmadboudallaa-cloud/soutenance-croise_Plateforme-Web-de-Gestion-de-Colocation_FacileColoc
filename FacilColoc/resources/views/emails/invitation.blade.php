<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invitation FacileColoc</title>
</head>
<body>
    <p>Bonjour,</p>

    <p>Vous avez Ã©tÃ© invitÃ© Ã  rejoindre la colocation <strong>{{ $invitation->colocation->name }}</strong>.</p>

    <p>Cliquez sur ce lien pour accepter ou refuser :</p>

    <p>
        <a href="{{ route('invitations.show', $invitation->token) }}">
            {{ route('invitations.show', $invitation->token) }}
        </a>
    </p>

    <p>Si vous nâ€™Ãªtes pas concernÃ©, ignorez cet email.</p>

    <p>â€” FacileColoc</p>
</body>
</html>

