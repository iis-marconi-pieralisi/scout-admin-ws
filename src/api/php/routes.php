<?php
// Questo array associa un URI e un metodo HTTP a una specifica funzione
// definita nel file handlers.php.

$routes = [
    // Rotte che rispondono al metodo GET
    'GET' => [
        '/api/prova' => 'mostra_messaggio_di_prova',
        '/api/iter' => 'read_iter',
        '/api/users' => 'generic_table_handler',
        '/api/products' => 'generic_table_handler',
        '/api/orders' => 'get_orders_join',
        '/api/partecipa' => 'get_all_partecipa',     // lista tutto
        '/api/branche' => 'get_branche',
        '/api/account' => 'read_account',        
        '/api/servizi'=>'read_servizi',
        '/api/branche' => 'read_branche',
        '/api/persona' => 'read_persone',
    ],

    // Rotte che rispondono al metodo POST
    'POST' => [
        '/api/products' => 'create_product',
        '/api/partecipa' =>  'create_partecipa',
        '/api/auth' => 'authenticate_user',
        '/api/account' => 'create_account',
        '/api/iter' => 'create_iter'
    ],
    
    'PUT' => [
        '/api/products/:id' => 'update_product',
        '/api/partecipa/:id_attivita/:id_unita' => 'update_partecipa',
        '/api/account/:id' => 'update_account',
        '/api/iter/:id' => 'update_iter'
    ],

    'DELETE' => [
        '/api/partecipa/:id_attivita/:id_unita' => 'delete_partecipa',
        '/api/account' => 'delete_account',
        '/api/persona/:id' => 'delete_persona',
        'api/iter' => 'delete_iter'
    ]

];
