<?php
// Questo array associa un URI e un metodo HTTP a una specifica funzione
// definita nel file handlers.php.

$routes = [
    // Rotte che rispondono al metodo GET
    'GET' => [
        // Rotta custom che usa un suo handler specifico
        '/api/prova' => 'mostra_messaggio_di_prova',
        '/api/servizi'=>'read_servizi',
        '/api/branche' => 'read_branche',
        '/api/persona' => 'read_persone',
    ],

    // Rotte che rispondono al metodo POST
    'POST' => [
        '/api/auth' => 'authenticate_user',
        '/api/persona' => 'create_persona',
    ],
    
    'PUT' => [
        '/api/persona/:id' => 'update_persona',
    ],
    'DELETE' =>[

    ],
    
    'DELETE' => [
        '/api/persona/:id' => 'delete_persona'
    ]
];
