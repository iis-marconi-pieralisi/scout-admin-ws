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
        '/api/aggiungipersona' => 'create_person',
    ],
    
    'PUT' => [
        '/api/products/:id' => 'update_product'
    ],
    
    // Puoi aggiungere qui altri metodi come PUT, DELETE, etc.
];
