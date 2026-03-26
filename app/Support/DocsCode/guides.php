<?php

return [
    'club-pro-config' => [
        'lang' => 'yaml',
        'name' => 'flexiwind.yaml',
        'code' => <<<'YAML'
registries:
  '@club':
    url: https://club.flexiwind.dev/pro/{name}.json
    headers:
      Authorization: "Bearer ${YOUR_FLEXIWIND_CLUB_TOKEN}"
YAML,
        'lines' => [
            2 => 'added',
            3 => 'added',
            4 => 'added',
            5 => 'added'
        ]
    ]

];
