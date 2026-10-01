<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paiement simulé
    |--------------------------------------------------------------------------
    |
    | Tant que le vrai prestataire n'est pas branché, un abonnement peut être
    | activé sans payer. L'endpoint qui fait ça est la pièce la plus sensible
    | de l'application : il n'est enregistré QUE si ce drapeau est vrai, et il
    | est forcé à faux en production. Un attaquant ne peut donc pas « forcer
    | un paiement » — la route qui le permettrait n'existe pas sur le site
    | public.
    |
    */

    'simulate' => env('APP_ENV') !== 'production' && (bool) env('BILLING_SIMULATE', true),

];
