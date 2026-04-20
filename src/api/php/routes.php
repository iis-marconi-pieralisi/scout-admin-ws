<?php
// Questo array associa un URI e un metodo HTTP a una specifica funzione
// definita nel file handlers.php.

$routes = [
    // Rotte che rispondono al metodo GET
    'GET' => [
        // Rotta custom che usa un suo handler specifico
        '/api/prova' => 'mostra_messaggio_di_prova',
<<<<<<< Updated upstream
        '/api/branca' => 'get_branca',
=======
        '/api/branca'=> 'get_branca',
        '/api/servizi'=>'get_servizio',
        
>>>>>>> Stashed changes
    ],

    // Rotte che rispondono al metodo POST
    'POST' => [
        '/api/products' => 'create_product',
        '/api/auth' => 'authenticate_user'
    ],
    
    'PUT' => [
        '/api/products/:id' => 'update_product'
    ],
    'DELETE' =>[

    ],
    
    // Puoi aggiungere qui altri metodi come PUT, DELETE, etc.
];
