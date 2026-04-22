<?php
// Questo array associa un URI e un metodo HTTP a una specifica funzione
// definita nel file handlers.php.

$routes = [
    // Rotte che rispondono al metodo GET
    'GET' => [
        // Rotta custom che usa un suo handler specifico
        '/api/prova' => 'mostra_messaggio_di_prova',
        '/api/iter' => 'read_iter',
    ],

    // Rotte che rispondono al metodo POST
    'POST' => [
        '/api/auth' => 'authenticate_user',
        '/api/iter' => 'create_iter'
    ],
    
    'PUT' => [
        '/api/iter/:id' => 'update_iter'
    ],

    'DELETE' =>[
        'api/iter' => 'delete_iter'
    ]
    
    // Puoi aggiungere qui altri metodi come PUT, DELETE, etc.
];
