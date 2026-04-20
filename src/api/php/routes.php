<?php
// Questo array associa un URI e un metodo HTTP a una specifica funzione
// definita nel file handlers.php.

$routes = [
    // Rotte che rispondono al metodo GET
    'GET' => [
        // Rotta custom che usa un suo handler specifico
        '/api/prova' => 'mostra_messaggio_di_prova',
        '/api/branche' => 'get_branche',
        '/api/attivita' => 'read_attivita'

    ],

    // Rotte che rispondono al metodo POST
    'POST' => [
        '/api/products' => 'create_product',
        '/api/auth' => 'authenticate_user',

        '/api/attivita' => 'create_attivita'
    ],
    
    'PUT' => [
        '/api/products/:id' => 'update_product',

        '/api/attivita/:id_attivita' => 'update_attivita'
    ],

    'DELETE' => [
        'api/attivita' => 'delete_attivita'
    ],
    
    // Puoi aggiungere qui altri metodi come PUT, DELETE, etc.
];
