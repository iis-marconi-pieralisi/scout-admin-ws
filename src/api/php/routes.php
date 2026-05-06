<?php

/**
 * Router
 *
 * Mappa  METHOD + URI  →  handler function.
 * Le rotte con :id catturano il parametro dall'URI e lo passano all'handler.
 */

// Include tutti i file PHP nella cartella handlers/ in modo automatico.
foreach (glob(__DIR__ . '/handlers/*.php') as $handler_file) {
    require_once $handler_file;
}

// ---------------------------------------------------------------------------
// Tabella delle rotte
// Aggiungere rispettando l'ordine alfabetico per comodità di lettura.
// TODO #1: rimuovere rotte parametriche e usare sempre json (anche per GET)
// TODO #2: uniformare le implementazioni degli handler (assicurandosi di usare la classe db helper)
// TODO #3: verificare il funzionamento delle rotte
// ---------------------------------------------------------------------------
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
    ],
    'POST' => [
        '/api/account' => 'create_account',
        //'/api/auth' => 'authenticate_user',
        '/api/attivita' => 'create_attivita',
        '/api/branca' => 'create_branca',
        '/api/iter' => 'create_iter',
        '/api/iscrizione' => 'create_iscrizione',
        '/api/pagamento' => 'create_pagamento',
        '/api/partecipa' => 'create_partecipa',
        '/api/unita' => 'create_unita'
    ],
    'PUT' => [
        '/api/account/:id' => 'update_account',
        '/api/attivita/:id_attivita' => 'update_attivita',
        '/api/branca/:id' => 'update_branca',
        '/api/iter/:id' => 'update_iter',
        '/api/iscrizione/:id' => 'update_iscrizione',
        '/api/pagamento' => 'update_pagamento',
        '/api/partecipa' => 'update_partecipa',
        '/api/unita' => 'update_unita'
    ],
    'DELETE' => [
        '/api/account' => 'delete_account',
        '/api/attivita' => 'delete_attivita',
        '/api/branca' => 'delete_branca',
        '/api/iter' => 'delete_iter',
        '/api/iscrizione/:id' => 'delete_iscrizione',
        '/api/partecipa/:id_attivita/:id_unita' => 'delete_partecipa',
        '/api/pagamento' => 'delete_pagamento',
        '/api/persona/:id' => 'delete_persona',
        '/api/unita' => 'delete_unita'
    ]
];