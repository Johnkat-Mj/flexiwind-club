<?php

namespace App\Auth;

enum MagicLinkStatus
{
    /** Lien émis et envoyé (ou en file d'envoi). */
    case Sent;

    /** Trop de demandes : on n'a rien émis. */
    case Throttled;
}
