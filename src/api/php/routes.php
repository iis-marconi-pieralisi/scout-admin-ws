<?php

/**
 * ============================================================================
 * FILE: routes.php
 * ============================================================================
 * Questo file definisce la "mappa" della nostra applicazione.
 * Associa un metodo HTTP e un indirizzo (URI) a una specifica funzione 
 * che abbiamo scritto in handlers.php.
 * * Struttura dell'array:
 * [METODO_HTTP] => [
 * 'PERCORSO_URL' => 'NOME_FUNZIONE_HANDLER'
 * ]
 */

$routes = [

    /**
     * ------------------------------------------------------------------------
     * METODO GET: Utilizzato per RECUPERARE dati dal server.
     * ------------------------------------------------------------------------
     */
    'GET' => [
        
        // Rotta semplice di test per verificare che tutto sia online
        '/api/prova' => 'mostra_messaggio_di_prova',

        // Restituisce l'elenco completo di tutte le branche
        '/api/branche' => 'get_branche',

        // Esempio di rotta con parametro dinamico (:id).
        // Il router capirà che al posto di :id ci sarà un numero o un codice.
        '/api/branche/:id' => 'get_branca_by_id',

        // Esempio di rotta che sfrutta un JOIN per gli ordini
        '/api/orders' => 'get_orders_join'
    ],


    /**
     * ------------------------------------------------------------------------
     * METODO POST: Utilizzato per CREARE nuovi record (invio dati).
     * ------------------------------------------------------------------------
     */
    'POST' => [
        
        // Crea una nuova branca nel database
        '/api/branche' => 'create_branca',

        // Aggiunge un nuovo prodotto al catalogo
        '/api/products' => 'create_product',

        // Gestisce il tentativo di login di un utente
        '/api/auth' => 'authenticate_user'
    ],


    /**
     * ------------------------------------------------------------------------
     * METODO PUT: Utilizzato per AGGIORNARE record esistenti.
     * ------------------------------------------------------------------------
     */
    'PUT' => [

        // Aggiorna i dati di una branca specifica identificata dal suo ID
        '/api/branche/:id' => 'update_branca',

        // Modifica nome, prezzo o descrizione di un prodotto
        '/api/products/:id' => 'update_product'
    ],


    /**
     * ------------------------------------------------------------------------
     * METODO DELETE: Utilizzato per ELIMINARE record.
     * ------------------------------------------------------------------------
     */
    'DELETE' => [

        // Rimuove definitivamente una branca dal sistema
        '/api/branche/:id' => 'delete_branca'
    ]

];


/**
 * NOTA PER GLI SVILUPPATORI:
 * * 1. Segnaposto :id
 * Quando vedi ':id', significa che quella parte dell'URL è variabile.
 * Esempio: /api/branche/5 richiamerà la funzione con l'ID 5.
 * * 2. Manutenzione
 * Se crei una nuova tabella nel database o una nuova funzionalità,
 * devi prima scrivere la funzione in 'handlers.php' e poi aggiungerla
 * qui sopra per renderla accessibile dal mondo esterno.
 * * 3. Convenzioni REST
 * Abbiamo cercato di seguire lo standard RESTful:
 * - GET per leggere
 * - POST per creare
 * - PUT per modificare
 * - DELETE per cancellare
 */