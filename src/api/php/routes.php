<?php

/**
 * Router
 *
 * Mappa  METHOD + URI  →  handler function.
 * Le rotte con :id catturano il parametro dall'URI e lo passano all'handler.
 */

require_once 'handlers.php';

// ---------------------------------------------------------------------------
// Tabella delle rotte
// ---------------------------------------------------------------------------
$routes = [
    'GET' => [
        '/api/prova' => 'mostra_messaggio_di_prova',
        '/api/iter' => 'read_iter',
        '/api/users' => 'generic_table_handler',
        '/api/products' => 'generic_table_handler',
        '/api/orders' => 'get_orders_join',
        '/api/partecipa' => 'get_all_partecipa',
        '/api/branche' => 'read_branche',
        '/api/account' => 'read_account',        
        '/api/servizi'=>'read_servizi',
        '/api/persona' => 'read_persone',
        '/api/attivita' => 'read_attivita',
        '/api/pagamento' => 'read_pagamento'

    ],
    'POST' => [
        '/api/products' => 'create_product',
        '/api/partecipa' =>  'create_partecipa',
        '/api/auth' => 'authenticate_user',
        '/api/account' => 'create_account',
        '/api/iter' => 'create_iter',
        '/api/branche' => 'create_branche',
        '/api/attivita' => 'create_attivita',
        '/api/pagamento' => 'create_pagamento'
    ],
    
    'PUT' => [
        '/api/products/:id' => 'update_product',
        '/api/partecipa/:id_attivita/:id_unita' => 'update_partecipa',
        '/api/account/:id' => 'update_account',
        '/api/iter/:id' => 'update_iter',
        '/api/branche' => 'update_branche',
        '/api/attivita/:id_attivita' => 'update_attivita',
        '/api/pagamento' => 'update_pagamento'
    ],

    'DELETE' => [
        '/api/partecipa/:id_attivita/:id_unita' => 'delete_partecipa',
        '/api/account' => 'delete_account',
        '/api/persona/:id' => 'delete_persona',
        'api/iter' => 'delete_iter',
        '/api/branche' => 'delete_branche',
        'api/attivita' => 'delete_attivita',
        '/api/pagamento' => 'delete_pagamento'
    ]

];

// ---------------------------------------------------------------------------
// Dispatch
// ---------------------------------------------------------------------------
$method = $_SERVER['REQUEST_METHOD'];
$uri    = strtok($_SERVER['REQUEST_URI'], '?');

foreach ($routes as [$routeMethod, $routePattern, $handler]) {

    if ($routeMethod !== $method) continue;

    // Converte :id in gruppo regex  es. /api/products/:id → #^/api/products/([^/]+)$#
    $regex = '#^' . preg_replace('/:([a-zA-Z_]+)/', '([^/]+)', $routePattern) . '$#';

    if (preg_match($regex, $uri, $matches)) {
        array_shift($matches);   // rimuove il match completo, restano solo i :param
        $handler($db, ...$matches);
        exit;
    }
}

json_response(['error' => 'Rotta non trovata.'], 404);
