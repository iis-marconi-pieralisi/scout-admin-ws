<?php

/**
 * Funzioni helper condivise.
 */
function json_response($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    echo json_encode($data);
}

// Esempio di handler generico, ritorna semplicemente tutti i record di una tabella specificata nell'URI.
function generic_table_handler($db, $data) {
    $uri = strtok($_SERVER['REQUEST_URI'], '?');
    $table_name = str_replace('/api/', '', $uri);

    try {
        $results = $db->query("SELECT * FROM {$table_name}");
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

// Un semplice handler di prova per testare il routing e la risposta JSON.
function mostra_messaggio_di_prova($db, $data) {
    json_response(['message' => 'Questo è un messaggio di prova.']);
}