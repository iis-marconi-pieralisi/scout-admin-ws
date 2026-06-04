<?php

// Include tutti i file PHP nella cartella handlers/ in modo automatico.
foreach (glob(__DIR__ . '/handlers/*.php') as $handler_file) {
    require_once $handler_file;
}

$routes = [
    'GET' => [
        '/api/account' => 'read_account',
        '/api/attivita' => 'read_attivita',
        '/api/branca' => 'read_branca',
        '/api/iscrizione' => 'read_iscrizione',
        '/api/iter' => 'read_iter',
        '/api/partecipa' => 'read_partecipa',
        '/api/pagamento' => 'read_pagamento',
        '/api/persona' => 'read_persona',
        '/api/prova' => 'mostra_messaggio_di_prova',
        '/api/servizio' => 'read_servizio',
        '/api/unita' => 'read_unita',
        '/api/tutore' => 'read_tutore',
        '/api/permesso' => 'prova_permesso',
    ],
    'POST' => [
        '/api/account' => 'create_account',
        '/api/auth' => 'authenticate_user',
        '/api/attivita' => 'create_attivita',
        '/api/branca' => 'create_branca',
        '/api/iter' => 'create_iter',
        '/api/iscrizione' => 'create_iscrizione',
        '/api/pagamento' => 'create_pagamento',
        '/api/partecipa' => 'create_partecipa',
        '/api/unita' => 'create_unita',
        '/api/registration' => 'registration',
        '/api/servizio' => 'create_servizio',
    ],
    'PUT' => [
        '/api/account' => 'update_account',
        '/api/attivita' => 'update_attivita',
        '/api/branca' => 'update_branca',
        '/api/iter' => 'update_iter',
        '/api/iscrizione' => 'update_iscrizione',
        '/api/pagamento' => 'update_pagamento',
        '/api/partecipa' => 'update_partecipa',
        '/api/persona' => 'update_persona',
        '/api/servizio' => 'update_servizio',
        '/api/unita' => 'update_unita',
    ],
    'DELETE' => [
        '/api/account' => 'delete_account',
        '/api/attivita' => 'delete_attivita',
        '/api/branca' => 'delete_branca',
        '/api/iter' => 'delete_iter',
        '/api/iscrizione' => 'delete_iscrizione',
        '/api/partecipa' => 'delete_partecipa',
        '/api/pagamento' => 'delete_pagamento',
        '/api/persona' => 'delete_persona',
        '/api/servizio' => 'delete_servizio',
        '/api/unita' => 'delete_unita',
    ]
];