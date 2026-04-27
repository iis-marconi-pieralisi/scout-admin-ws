<?php

/**
 * Funzioni Handler
 *
 * Queste funzioni sono chiamate dal router e si occupano di interagire
 * con il database e di restituire la risposta in formato JSON.
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
    $uri = strtok($_SERVER['REQUEST_URI'], '?');
    $table_name = str_replace('/api/', '', $uri);

    try {
        $results = $db->query("SELECT * FROM {$table_name}");
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

// ===========================================================================
// BRANCHE
// ===========================================================================

/**
 * Handler: read_branche
 * Rotta:   GET /api/branche
 */
function read_branche($db)
{
    try {
        $sql = <<<EOD
            SELECT  *
            FROM    Branca
        EOD;

        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

/**
 * Handler: create_branche
 * Rotta:   POST /api/branche
 * Body JSON atteso:
 *   { "nome": "Esploratori", "descrizione": "Ragazzi 12-16 anni" }
 */
function create_branche($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['nome'])) {
        json_response(['error' => 'Campo obbligatorio mancante: nome.'], 400);
        return;
    }

    try {
        $sql = <<<EOD
            INSERT INTO Branca (nome, descrizione)
            VALUES (?, ?)
        EOD;

        $params = [
            $data['nome'],
            $data['descrizione'] ?? null,
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success'       => true,
            'message'       => 'Branca creata con successo.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

/**
 * Handler: update_branche
 * Rotta:   PUT /api/branche
 * Body JSON atteso:
 *   { "id_branca": 2, "nome": "Esploratori", "descrizione": "Descrizione aggiornata" }
 */
function update_branche($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id_branca']) || !isset($data['nome'])) {
        json_response(['error' => 'Campi obbligatori mancanti: id_branca, nome.'], 400);
        return;
    }

    try {
        $sql = <<<EOD
            UPDATE  Branca
            SET     nome        = ?,
                    descrizione = ?
            WHERE   id_branca   = ?
        EOD;

        $params = [
            $data['nome'],
            $data['descrizione'] ?? null,
            (int)$data['id_branca'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success'       => true,
            'message'       => 'Branca aggiornata.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

/**
 * Handler: delete_branche
 * Rotta:   DELETE /api/branche
 * Body JSON atteso:
 *   { "id_branca": 2 }
 */
function delete_branche($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id_branca'])) {
        json_response(['error' => 'Campo obbligatorio mancante: id_branca.'], 400);
        return;
    }

    try {
        $sql = <<<EOD
            DELETE FROM Branca
            WHERE id_branca = ?
        EOD;

        $affected_rows = $db->query($sql, [(int)$data['id_branca']]);

        json_response([
            'success'       => true,
            'message'       => 'Branca eliminata.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

// ===========================================================================
// ORDINI
// ===========================================================================

/**
 * Ottiene la lista degli ordini con relativi nomi utente e nome prodotto.
 */
function get_orders_join($db) {
    try {
        $sql = <<<EOD
            SELECT  order_id,
                    users.name    AS user_name,
                    products.name AS product_name,
                    orders.quantity   AS quantity,
                    orders.created_at AS created_at
            FROM orders
                NATURAL JOIN products
                JOIN users ON orders.user_id = users.user_id
        EOD;

        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

// ===========================================================================
// PRODOTTI
// ===========================================================================

function create_product($db) {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['name']) || !isset($data['price'])) {
        json_response(['error' => 'Dati mancanti (name, price)'], 400);
        return;
    }

    try {
        $sql = "INSERT INTO products VALUES (NULL, ?, ?, ?, NULL)";

        $params = [
            $data['name'],
            $data['description'],
            (float)$data['price'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success'       => true,
            'message'       => 'Prodotto creato.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione del prodotto.'], 500);
    }
}

/**
 * Aggiorna nome e prezzo di un prodotto.
 * Risponde alla rotta PUT /api/products/:id
 */
function update_product($db, $id) {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['name']) || !isset($data['price'])) {
        json_response(['error' => 'Dati mancanti (name, price)'], 400);
        return;
    }

    try {
        $sql = "UPDATE products SET name = ?, price = ?, description = ? WHERE product_id = ?";

        $params = [
            $data['name'],
            (float)$data['price'],
            $data['description'],
            (int)$id,
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success'       => true,
            'message'       => 'Prodotto aggiornato (Nome e Prezzo).',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore durante l\'aggiornamento del prodotto.'], 500);
    }
}

// ===========================================================================
// ALTRO
// ===========================================================================

function authenticate_user($db) {
    $data = json_decode(file_get_contents('php://input'), true);
    json_response(['utente' => 'ciao']);
}

/**
 * Funzione di esempio per una rotta custom.
 */
function mostra_messaggio_di_prova($db) {
    json_response(['message' => 'Questa è una risposta dalla rotta di prova!']);
}