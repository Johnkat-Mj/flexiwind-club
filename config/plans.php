<?php

/*
|--------------------------------------------------------------------------
| Catalogue des plans Flexiwind Pro
|--------------------------------------------------------------------------
|
| Le catalogue vit ici, pas en base. C'est la défense principale contre un
| faux paiement : le checkout ne reçoit qu'une CLÉ de plan, tout le reste
| (prix, nombre de sièges, durée) est relu côté serveur depuis ce fichier.
| Un client qui poste `price_cents=0` ne change rien : la valeur n'est
| jamais lue depuis la requête.
|
| `duration` est une période ISO-8601 (P1Y = un an) ou null pour un
| lifetime. `seats` est le nombre de comptes qui partagent l'abonnement.
|
*/

return [

    'solo-annual' => [
        'name' => 'Solo',
        'billing_label' => 'per year',
        'seats' => 1,
        'duration' => 'P1Y',
        'price_cents' => 7900,
        'currency' => 'EUR',
        'tagline' => 'Every pro component and block, for one developer, renewed each year.',
        'features' => [
            'All pro components and blocks',
            'Unlimited projects, including client work',
            'CLI access with your own tokens',
            'One year of updates',
        ],
    ],

    'solo-lifetime' => [
        'name' => 'Solo Lifetime',
        'billing_label' => 'one time',
        'seats' => 1,
        'duration' => null,
        'price_cents' => 19900,
        'currency' => 'EUR',
        'tagline' => 'Pay once, keep access for good — updates included.',
        'features' => [
            'All pro components and blocks',
            'Unlimited projects, including client work',
            'CLI access with your own tokens',
            'Lifetime updates',
        ],
        'featured' => true,
    ],

    'team-lifetime' => [
        'name' => 'Team Lifetime',
        'billing_label' => 'one time, 5 seats',
        'seats' => 5,
        'duration' => null,
        'price_cents' => 49900,
        'currency' => 'EUR',
        'tagline' => 'Five developers, five accounts, one payment.',
        'features' => [
            'Everything in Solo Lifetime',
            '5 seats — each member signs in with their own account',
            'Each member generates and revokes their own CLI tokens',
            'Reassign a seat whenever someone leaves',
        ],
    ],

];
