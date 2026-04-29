<?php

/**
 * Funzioni Handler
 *
 * Queste funzioni sono chiamate dal router e si occupano di interagire
 * con il database e di restituire la risposta in formato JSON.
 * 
 * TODO: suddividere la logica degli handler in altri sorgenti e caricarli con 
 * composer o altra tecnica.
 * Così si evitano conflitti sullo stesso file e si rende lo sviluppo più modulare
 */

/**
 * Imposta l'header per la risposta JSON.
 */
function json_response($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    echo json_encode($data);
}

/**
 * Gestore generico per tabelle.
 * Estrae il nome della tabella dall'URI e restituisce tutti i record.
 * La sicurezza è garantita dal router che fa un match esatto dell'URI.
 */
function generic_table_handler($db) {
    // Estrae l'URI della richiesta, es. /api/users
    $uri = strtok($_SERVER['REQUEST_URI'], '?');

    // Rimuove /api/ per ottenere il nome della tabella, che corrisponde
    // esattamente alla parte finale della rotta definita in routes.php.
    $table_name = str_replace('/api/', '', $uri);

    try {
        $results = $db->query("SELECT * FROM {$table_name}");
        json_response($results);
    } catch (Exception $e) {
        // In produzione, è buona norma non esporre i dettagli specifici dell'errore.
        // Si potrebbe loggare $e->getMessage() in un file di log per il debug.
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function mostra_messaggio_di_prova($db) {
    json_response(['message' => 'Questa è una risposta dalla rotta di prova!']);
}

function create_attivita($db){
    try {
        $sql = "INSERT INTO Attivita VALUES (nome, descrizione, luogo _partenza, luogo_arrivo, data, id_persona)";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_attivita($db){
    try {
        $sql = "DELETE FROM Attivita WHERE id_attivita = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function read_attivita($db){
    try {
        $sql = "SELECT * FROM Attivita ORDER BY data DESC";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function update_attivita($db){
    try {
        $sql = "UPDATE Attivita SET id_attivita = ? , nome = ? , descrizione = ? , luogo _partenza = ? , luogo_arrivo = ? , data = ? , id_persona = ? WHERE id_attivita = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_pagamento($db){
    try {
        $sql = "INSERT INTO Pagamento VALUES (importo, metodo, data)";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_pagamento($db){
    try {
        $sql = "DELETE FROM Pagamento WHERE id_pagamento = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function read_pagamento($db){
    try {
        $sql = "SELECT * FROM Pagamento ORDER BY data DESC";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function update_pagamento($db){
    try {
        $sql = "UPDATE Pagamento SET id_pagamento = ? , importo = ? , metodo = ?, data = ? WHERE id_pagamento = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}