<?php
// Questo array associa un URI e un metodo HTTP a una specifica funzione
// definita nel file handlers.php.

$routes = [
    // Rotte che rispondono al metodo GET
    'GET' => [
        // Rotta custom che usa un suo handler specifico
        '/api/prova' => 'mostra_messaggio_di_prova',
        '/api/branche' => 'get_branche',
        '/api/persona' => 'get_persone',
    ],

    // Rotte che rispondono al metodo POST
    'POST' => [
        '/api/products' => 'create_product',
        '/api/auth' => 'authenticate_user',
        '/api/persona' => 'create_person',
    ],
    
    'PUT' => [
        '/api/products/:id' => 'update_product',
        '/api/persona/:id' => 'update_person',
    ],
    
    'DELETE' => [
        '/api/persona/:id' => 'delete_person'
    ]
];
