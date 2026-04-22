<?php
// Questo array associa un URI e un metodo HTTP a una specifica funzione
// definita nel file handlers.php.

$routes = [
    // Rotte che rispondono al metodo GET
    'GET' => [
        // Rotta custom che usa un suo handler specifico
        '/api/prova' => 'mostra_messaggio_di_prova',
        // Rotte che usano il gestore generico per tabelle
        '/api/users' => 'generic_table_handler',
        '/api/products' => 'generic_table_handler',
        '/api/orders' => 'get_orders_join',
        '/api/partecipa' => 'get_all_partecipa',     // lista tutto

        '/api/branche' => 'get_branche'
    ],

    // Rotte che rispondono al metodo POST
    'POST' => [
        '/api/products' => 'create_product',
        '/api/auth' => 'authenticate_user',
        '/api/partecipa' =>  'create_partecipa',
        '/api/auth' => 'authenticate_user'
    ],
    
    'PUT' => [
        '/api/products/:id' => 'update_product',
        '/api/partecipa/:id_attivita/:id_unita' => 'update_partecipa',
        //'/api/products/:id' => 'update_product'
       // '/api/products/:id' => 'update_product'
    ],
    
    'DELETE' => [
        '/api/partecipa/:id_attivita/:id_unita' => 'delete_partecipa',
    ]
    // Puoi aggiungere qui altri metodi come PUT, DELETE, etc.
];
