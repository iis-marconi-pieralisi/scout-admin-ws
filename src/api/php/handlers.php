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

function get_branca($db) 
{
    try {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT 	*
            FROM Branca
        EOD;

        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        // In produzione, è buona norma non esporre i dettagli specifici dell'errore.
        // Si potrebbe loggare $e->getMessage() in un file di log per il debug.
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
/**
 * Ottiene la lista degli ordini con relativi nomi utente e nome prodotto.
 */
function get_orders_join($db) {
    // Estrae l'URI della richiesta, es. /api/users
    $uri = strtok($_SERVER['REQUEST_URI'], '?');

/*CREATE TABLE Servizio (
    descrizione TEXT NOT NULL,
    anno_associativo INT NOT NULL,
    id_persona INT NOT NULL,
    id_tipologia INT NOT NULL,
    id_unita INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_tipologia) REFERENCES Tipologia(id_tipologia) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_unita) REFERENCES Unita(id_unita) ON DELETE RESTRICT ON UPDATE CASCADE,
    PRIMARY KEY (anno_associativo, id_persona)
);*/
function get_servizio($db)
{
    try {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT *
            FROM Servizio
        EOD;

        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        // In produzione, è buona norma non esporre i dettagli specifici dell'errore.
        // Si potrebbe loggare $e->getMessage() in un file di log per il debug.
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_servizio($db) 
{
    $data = json_decode(file_get_contents('php://input'), true);
    var_dump($data);
    
    // 2. Validazione: servono obbligatoriamente anno_associativo e id_persona
    if (!$data || !isset($data['anno_associativo']) || !isset($data['id_persona'])) 
        {
            json_response(['error' => 'Dati mancanti (anno_associativo, id_persona)'], 400);
            return;
        }
    try 
    {
        $sql = "INSERT INTO Servizio VALUES (?, ?, ?, ?, ?)";

        // È fondamentale rispettare l'ordine dei punti di domanda!
        $params = [
            $data['descrizione'],          
            (int)$data['anno_associativo'],
            (int)$data['id_persona'],
            (int)$data['id_tipologia'],
            (int)$data['id_unità'],
        ];

        // 5. Esecuzione tramite Helper
        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Servizio aggiornato",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        // Log dell'errore server (opzionale)
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento del prodotto. '], 500);
        mostra_messaggio_di_prova($db);
    }
}

function update_servizio($db)
{

}

function delete_servizo($db)
{
    
}


/**
 * Ottiene la lista degli ordini con relativi nomi utente e nome prodotto.
 */
function get_orders_join($db) {
    // Estrae l'URI della richiesta, es. /api/users
    $uri = strtok($_SERVER['REQUEST_URI'], '?');
}

function create_product($db) {
    // 1. Lettura del payload JSON
    $data = json_decode(file_get_contents('php://input'), true);

    var_dump($data);
    
    // 2. Validazione: servono obbligatoriamente name e price
    if (!$data || !isset($data['name']) || !isset($data['price'])) {
        json_response(['error' => 'Dati mancanti (name, price)'], 400);
        return;
    }

    try {
        $sql = "INSERT INTO products VALUES (NULL, ?, ?, ?, NULL)";

        // È fondamentale rispettare l'ordine dei punti di domanda!
        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            $data['description'],   // 3° ? -> description (stringa)
            (float)$data['price'],  // 2° ? -> price (cast a float per bindare come 'd')
        ];

        // 5. Esecuzione tramite Helper
        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Prodotto aggiornato (Nome e Prezzo).",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        // Log dell'errore server (opzionale)
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento del prodotto. '], 500);
    }
}

/**
 * Aggiorna nome e prezzo di un prodotto.
 * Risponde alla rotta PUT /api/products/:id
 */
function update_product($db, $id) {
    // 1. Lettura del payload JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // 2. Validazione: servono obbligatoriamente name e price
    if (!$data || !isset($data['name']) || !isset($data['price'])) {
        json_response(['error' => 'Dati mancanti (name, price)'], 400);
        return;
    }

    try {
        // 3. Query SQL
        // Usiamo i ? perché il tuo helper usa mysqli::prepare
        $sql = "UPDATE products SET name = ?, price = ?, description = ? WHERE product_id = ?";

        // 4. Preparazione Parametri
        // È fondamentale rispettare l'ordine dei punti di domanda!
        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            (float)$data['price'],  // 2° ? -> price (cast a float per bindare come 'd')
            $data['description'],   // 3° ? -> description (stringa)
            (int)$id                // 4° ? -> product_id (cast a int per bindare come 'i')
        ];

        // 5. Esecuzione tramite Helper
        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Prodotto aggiornato (Nome e Prezzo).",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        // Log dell'errore server (opzionale)
        // error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento del prodotto.'], 500);
    }
}

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