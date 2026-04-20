<?php

/**
 * ============================================================================
 * FILE: handlers.php
 * ============================================================================
 * Questo file contiene tutte le funzioni "Handler" della nostra API.
 * * Un handler è il "cuore" della logica: riceve la richiesta dal router,
 * comunica con il database (tramite l'oggetto $db) e restituisce una
 * risposta strutturata in formato JSON.
 */

/**
 * UTILITY: Invia una risposta JSON al client.
 * * Questa funzione centralizza il modo in cui rispondiamo al frontend.
 * Imposta gli header corretti per evitare problemi di CORS e per dire
 * al browser che riceverà dei dati JSON.
 *
 * @param mixed $data        I dati da convertire in JSON (array o oggetti).
 * @param int   $statusCode  Il codice di stato HTTP (es. 200 OK, 400 Bad Request, 500 Errore).
 */
function json_response($data, $statusCode = 200) {
    // Imposta il codice di stato della risposta (es. 200, 404, 500)
    http_response_code($statusCode);

    // Specifica che il contenuto restituito è JSON
    header('Content-Type: application/json');

    // CORS: Permette a qualsiasi dominio di fare richieste a questa API.
    // In produzione, sarebbe meglio limitarlo a domini specifici.
    header('Access-Control-Allow-Origin: *');

    // Specifica quali metodi HTTP sono accettati
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');

    // Trasforma l'array PHP in una stringa JSON e la stampa (invio al client)
    echo json_encode($data);
}


/**
 * HANDLER GENERICO: Restituisce tutti i record di una tabella.
 * * Invece di scrivere una funzione per ogni tabella semplice, questa funzione
 * capisce quale tabella interrogare guardando l'indirizzo (URI).
 */
function generic_table_handler($db) {
    // 1. Pulizia dell'URI (es. trasforma "/api/users?id=1" in "/api/users")
    $uri = strtok($_SERVER['REQUEST_URI'], '?');

    // 2. Rimuove il prefisso "/api/" per isolare il nome della tabella
    $table_name = str_replace('/api/', '', $uri);

    try {
        // 3. Esegue la query dinamica. 
        // NOTA: Sicuro solo se il router controlla che $table_name sia valido!
        $results = $db->query("SELECT * FROM {$table_name}");

        // 4. Risponde con i dati trovati
        json_response($results);

    } catch (Exception $e) {
        // Se qualcosa va storto (es. tabella non esistente), risponde con errore 500
        json_response(['error' => 'Errore interno del server durante la lettura dei dati.'], 500);
    }
}


/**
 * ============================================================================
 * SEZIONE: BRANCHE
 * ============================================================================
 */

/**
 * Legge tutte le Branche presenti nel database.
 */
function get_branche($db) {
    try {
        // Definiamo la query SQL. Usiamo EOD per pulizia visiva se la query fosse lunga.
        $sql = "SELECT * FROM Branca";

        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) {
        json_response(['error' => 'Impossibile recuperare le branche.'], 500);
    }
}

/**
 * Crea una nuova Branca (Metodo POST).
 * Aspetta un corpo JSON con: nome_branca, min_eta, max_eta.
 */
function create_branca($db) {
    // Leggiamo il corpo della richiesta (raw body) perché PHP non popola $_POST con i JSON
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);
    
    // Validazione dei dati obbligatori
    if (!$data || !isset($data['nome_branca'], $data['min_eta'], $data['max_eta'])) {
        json_response(['error' => 'Dati incompleti: nome_branca, min_eta e max_eta sono obbligatori'], 400);
        return;
    }

    try {
        // Preparazione della query con i segnaposti "?" per evitare SQL Injection
        $sql = "INSERT INTO Branca (nome_branca, min_eta, max_eta) VALUES (?, ?, ?)";
        
        $params = [
            $data['nome_branca'], 
            (int)$data['min_eta'], 
            (int)$data['max_eta']
        ];

        $db->query($sql, $params);

        json_response(['success' => true, 'message' => 'Branca creata con successo!'], 201);

    } catch (Exception $e) {
        json_response(['error' => 'Errore nel salvataggio della branca.'], 500);
    }
}

/**
 * Aggiorna una branca esistente (Metodo PUT).
 * L'$id viene passato direttamente dal router che lo estrae dall'URL.
 */
function update_branca($db, $id) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    try {
        $sql = "UPDATE Branca SET nome_branca = ?, min_eta = ?, max_eta = ? WHERE id_branca = ?";
        
        $params = [
            $data['nome_branca'], 
            (int)$data['min_eta'], 
            (int)$data['max_eta'], 
            (int)$id
        ];

        $affected = $db->query($sql, $params);
        
        json_response([
            'updated' => true, 
            'rows_affected' => $affected,
            'message' => 'Dati aggiornati correttamente.'
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore durante l\'aggiornamento.'], 500);
    }
}

/**
 * Elimina una branca tramite il suo ID (Metodo DELETE).
 */
function delete_branca($db, $id) {
    try {
        $sql = "DELETE FROM Branca WHERE id_branca = ?";
        
        // Eseguiamo l'eliminazione
        $affected = $db->query($sql, [(int)$id]);

        json_response([
            'deleted' => true, 
            'rows_affected' => $affected
        ]);

    } catch (Exception $e) {
        // Questo errore spesso accade se ci sono record collegati (es. Unita o Iter)
        json_response([
            'error' => 'Impossibile eliminare: verifica che non ci siano unità collegate a questa branca.'
        ], 500);
    }
}


/**
 * ============================================================================
 * SEZIONE: PRODOTTI E ORDINI
 * ============================================================================
 */

/**
 * Ottiene la lista degli ordini unendo più tabelle (JOIN).
 * Utile per mostrare nomi leggibili invece di semplici ID numerici.
 */
function get_orders_join($db) {
    try {
        // Query complessa che mette insieme tre tabelle: ordini, prodotti e utenti
        $sql = "SELECT 
                    o.order_id, 
                    u.name AS user_name, 
                    p.name AS product_name, 
                    o.quantity, 
                    o.created_at
                FROM orders o
                JOIN products p ON o.product_id = p.product_id
                JOIN users u ON o.user_id = u.user_id";

        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) {
        json_response(['error' => 'Errore nel caricamento degli ordini.'], 500);
    }
}

/**
 * Crea un nuovo prodotto nel catalogo.
 */
function create_product($db) {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validazione di base
    if (!$data || !isset($data['name'], $data['price'])) {
        json_response(['error' => 'Dati mancanti: nome e prezzo sono obbligatori.'], 400);
        return;
    }

    try {
        // Query di inserimento. Assumiamo che la tabella products abbia (id, name, description, price, created_at)
        $sql = "INSERT INTO products (name, description, price) VALUES (?, ?, ?)";

        $params = [
            $data['name'],
            $data['description'] ?? '', // Se manca la descrizione, mettiamo stringa vuota
            (float)$data['price']
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Prodotto creato con successo.",
            'affected_rows' => $affected_rows
        ], 201);

    } catch (Exception $e) {
        json_response(['error' => 'Errore durante la creazione del prodotto.'], 500);
    }
}

/**
 * Aggiorna un prodotto esistente tramite ID.
 */
function update_product($db, $id) {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['name'], $data['price'])) {
        json_response(['error' => 'Dati mancanti per l\'aggiornamento.'], 400);
        return;
    }

    try {
        $sql = "UPDATE products SET name = ?, price = ?, description = ? WHERE product_id = ?";

        $params = [
            $data['name'],
            (float)$data['price'],
            $data['description'] ?? '',
            (int)$id
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Prodotto aggiornato correttamente.",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore durante l\'aggiornamento del prodotto.'], 500);
    }
}


/**
 * ============================================================================
 * SEZIONE: AUTENTICAZIONE E TEST
 * ============================================================================
 */

/**
 * Gestore dell'autenticazione. 
 * Per ora restituisce una risposta di prova.
 */
function authenticate_user($db) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // In futuro qui andrà la logica di controllo password (password_verify)
    json_response([
        'status' => 'success',
        'message' => 'Login simulato correttamente',
        'user' => 'admin'
    ]);
}

/**
 * Rotta di test per verificare se l'API sta funzionando.
 */
function mostra_messaggio_di_prova($db) {
    json_response([
        'message' => 'Connessione riuscita! Il sistema di handler è operativo.',
        'timestamp' => date('Y-m-d H:i:s'),
        'ambiente' => 'Sviluppo'
    ]);
}