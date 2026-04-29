<?php
// Questo array associa un URI e un metodo HTTP a una specifica funzione
// definita nel file handlers.php.

$routes = [
    // Rotte che rispondono al metodo GET
    'GET' => [
        // Rotta custom che usa un suo handler specifico
        '/api/prova' => 'mostra_messaggio_di_prova',
        '/api/attivita' => 'read_attivita',
        '/api/pagamento' => 'read_pagamento'

    ],

    // Rotte che rispondono al metodo POST
    'POST' => [
        '/api/attivita' => 'create_attivita',
        '/api/pagamento' => 'create_pagamento'
    ],
    
    'PUT' => [
        '/api/attivita/:id_attivita' => 'update_attivita',
        '/api/pagamento' => 'update_pagamento'
    ],

    'DELETE' => [
        'api/attivita' => 'delete_attivita',
        '/api/pagamento' => 'delete_pagamento'
    ],
    
    // Puoi aggiungere qui altri metodi come PUT, DELETE, etc.
];
