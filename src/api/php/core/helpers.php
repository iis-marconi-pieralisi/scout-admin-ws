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

function generic_table_handler($db) {
    $uri = strtok($_SERVER['REQUEST_URI'], '?');
    $table_name = str_replace('/api/', '', $uri);

    try {
        $results = $db->query("SELECT * FROM {$table_name}");
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function mostra_messaggio_di_prova($db) {
    json_response(['message' => 'Questo è un messaggio di prova.']);
}