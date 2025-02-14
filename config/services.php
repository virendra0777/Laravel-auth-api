<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'cricket' => [
        'league' => 'https://rest.entitysport.com/v2/competitions?token=e0d307d79ebf119c073e8cc13a83255d&per_page={per_page}&&paged={page}&status=fixture',
        'matches' => 'https://rest.entitysport.com/v2/competitions/{leagueId}/matches/?token=e0d307d79ebf119c073e8cc13a83255d&per_page={per_page}&&paged={page}',
        'teamSquads' => 'https://rest.entitysport.com/v2/competitions/{leagueId}/squads/{matchId}?token=e0d307d79ebf119c073e8cc13a83255d',
        'livescore' => 'https://rest.entitysport.com/v2/matches/{matchId}/newpoint2?token=e0d307d79ebf119c073e8cc13a83255d',
        'scoreboard' => 'https://rest.entitysport.com/v2/matches/{matchId}/scorecard?token=e0d307d79ebf119c073e8cc13a83255d',
        'lineup' => 'https://rest.entitysport.com/v2/matches/{matchId}/squads?token=e0d307d79ebf119c073e8cc13a83255d'
    ],
    'football' => [
        'league' => 'https://soccer.entitysport.com/competitions?token=44689d60663efa7ad59e4903675b794e&per_page={per_page}&paged={page}',
        'matches' => 'https://soccer.entitysport.com/competition/{leagueId}/matches?token=44689d60663efa7ad59e4903675b794e&per_page={per_page}&&paged={page}',
        'teamSquads' => 'https://soccer.entitysport.com/competition/{leagueId}/squad?token=44689d60663efa7ad59e4903675b794e',
        'livescore' => 'https://soccer.entitysport.com/matches/{matchId}/newfantasy?token=44689d60663efa7ad59e4903675b794e'
    ]
];
