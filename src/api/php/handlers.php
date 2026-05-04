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



function read_account($db)
{
    try {
        $sql = <<<EOD
            SELECT *
            FROM Account;
        EOD;

        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_account($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body || !isset($body['username']) || !isset($body['password']) || !isset($body['email'])) {
            json_response(['error' => 'Dati mancanti (username, password, email).'], 400);
            return;
        }

        $username = $body['username'];
        $password = password_hash($body['password'], PASSWORD_BCRYPT);
        $email    = $body['email'];

        $sql = <<<EOD
            INSERT INTO Account (username, password, email)
            VALUES (:username, :password, :email);
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':email'    => $email
        ]);

        json_response(['message' => 'Account creato con successo.'], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function update_account($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body || !isset($body['id']) || !isset($body['username']) || !isset($body['password']) || !isset($body['email'])) {
            json_response(['error' => 'Dati mancanti (id, username, password, email).'], 400);
            return;
        }

        $id       = (int) $body['id'];
        $username = $body['username'];
        $password = password_hash($body['password'], PASSWORD_BCRYPT);
        $email    = $body['email'];

        $sql = <<<EOD
            UPDATE Account
            SET username = :username,
                password = :password,
                email    = :email
            WHERE id = :id;
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id'       => $id,
            ':username' => $username,
            ':password' => $password,
            ':email'    => $email
        ]);

        json_response(['message' => 'Account aggiornato con successo.']);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_account($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body || !isset($body['id'])) {
            json_response(['error' => 'Dati mancanti (id).'], 400);
            return;
        }

        $id = (int) $body['id'];

        $sql = <<<EOD
            DELETE FROM Account
            WHERE id = :id;
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);

        json_response(['message' => 'Account eliminato con successo.']);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
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

function get_iter($db)
{
    try {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT 	*
            FROM Iter;
        EOD;

        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        // In produzione, è buona norma non esporre i dettagli specifici dell'errore.
        // Si potrebbe loggare $e->getMessage() in un file di log per il debug.
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

<<<<<<< 404BrainNotFound
function mostra_messaggio_di_prova($db) {
    json_response(['message' => 'Questa è una risposta dalla rotta di prova!']);
}

function create_attivita($db){
    try {
        $sql = "INSERT INTO Attivita VALUES (nome, descrizione, luogo _partenza, luogo_arrivo, data, id_persona)";
=======
function read_persone($db)
{
         try {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT *
            FROM Persona
        EOD;

        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

//GET
function read_servizi($db)
{
    try {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT *
            FROM Servizio
        EOD;

>>>>>>> main
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

<<<<<<< 404BrainNotFound
function delete_attivita($db){
    try {
        $sql = "DELETE FROM Attivita WHERE id_attivita = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
=======
//POST 
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

function create_iter($db)
{
    // 1. Lettura del payload JSON
    $data = json_decode(file_get_contents('php://input'), true);

    var_dump($data);
    
    // 2. Validazione: servono obbligatoriamente name e price
    if (!$data || !isset($data['name']) || !isset($data['branca'])) {
        json_response(['error' => 'Dati mancanti (name, branca)'], 400);
        return;
>>>>>>> main
    }
}

function read_attivita($db){
    try {
<<<<<<< 404BrainNotFound
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
=======
        $sql = "INSERT INTO Iter VALUES (NULL, ?, ?, ?)";

        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            $data['description'],  // 2° ? -> description (stringa),
            (int)$data['branca']         //3° ? -> branca(int)
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Iter aggiornato (Nome e Branca).",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione dell\' iter. '], 500);
    }
}

//PUT
function update_servizio($db)
{

}

function delete_servizo($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    // Validazione
    if (
        !$data ||
        !isset($data['anno_associativo']) ||
        !isset($data['id_persona'])
    ) {
        json_response(['error' => 'Chiave primaria mancante'], 400);
        return;
    }

    try {
        $sql = "
            DELETE FROM Servizio
            WHERE anno_associativo = ?
              AND id_persona = ?
        ";

        $params = [
            (int)$data['anno_associativo'],
            (int)$data['id_persona']
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Servizio eliminato',
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante DELETE Servizio'], 500);
    }
}

function update_iter($db, $id)
{
    // 1. Lettura del payload JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // 2. Validazione: servono obbligatoriamente name e branca
    if (!$data || !isset($data['name']) || !isset($data['branca'])) {
        json_response(['error' => 'Dati mancanti (name, branca)'], 400);
        return;
>>>>>>> main
    }
}

function create_pagamento($db){
    try {
<<<<<<< 404BrainNotFound
        $sql = "INSERT INTO Pagamento VALUES (importo, metodo, data)";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
=======
        // 3. Query SQL
        // Usiamo i ? perché il tuo helper usa mysqli::prepare
        $sql = "UPDATE Iter SET name = ?, branca = ?, description = ? WHERE id_iter = ?";

        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            (int)$data['branca'],   // 2° ? -> branca (int)
            $data['description'],   // 3° ? -> description (stringa)
            (int)$id                // 4° ? -> id_iter (cast a int per bindare come 'i')
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Iter aggiornato (Nome e Branca).",
            'affected_rows' => $affected_rows
        ]);
>>>>>>> main

function delete_pagamento($db){
    try {
        $sql = "DELETE FROM Pagamento WHERE id_pagamento = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
<<<<<<< 404BrainNotFound
        json_response(['error' => 'Errore interno del server.'], 500);
=======
        // Log dell'errore server (opzionale)
        // error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento dell\'iter.'], 500);
    }
}

function create_persona($db) 
{
    //prende il body della richiesta php e trasforma il json in un array associativo
    $persona = json_decode(file_get_contents('php://input'), true);

    //validazione json
    if (!$persona || !isset($persona['nome']) || !isset($persona['cognome']) || !isset($persona['data_nascita'])|| !isset($persona['luogo_nascita'])|| !isset($persona['citta_residenza'])|| !isset($persona['via_residenza'])|| !isset($persona['cap_residenza'])|| !isset($persona['telefono']) || !isset($persona['id_tutore1']) ) 
    {
        json_response(['error' => 'Dati mancanti' ], 400);
        return;
    }

    try 
    {
        if (isset($persona['id_tutore2'])) 
        {
            $id_tutore2 = (int)$persona['id_tutore2'];
        } 
        else 
        {
            $id_tutore2 = null;
        }

        // id_persona -> AUTO_INCREMENT (NULL)
        // id_tutore2 -> nullable (Null = Sì)
        $sql = "INSERT INTO Persona 
                    (nome, cognome, data_nascita, luogo_nascita, citta_residenza, via_residenza, cap_residenza, telefono, id_tutore1, id_tutore2) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $persona['nome'],                         
            $persona['cognome'],                       
            $persona['data_nascita'],                 
            $persona['luogo_nascita'],                 
            $persona['citta_residenza'],               
            $persona['via_residenza'],                 
            $persona['cap_residenza'],                 
            $persona['telefono'],                      
            (int)$persona['id_tutore1'],               
            $id_tutore2,                          
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Persona creata con successo.',
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione della persona.'], 500);
>>>>>>> main
    }
    
}

<<<<<<< 404BrainNotFound
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
=======

function update_persona($db, $id) 
{
    $persona = json_decode(file_get_contents('php://input'), true);

    // Validazione JSON
    if (!$persona || !isset($persona['nome']) || !isset($persona['cognome']) || !isset($persona['data_nascita']) || !isset($persona['luogo_nascita']) || !isset($persona['citta_residenza']) || !isset($persona['via_residenza']) || !isset($persona['cap_residenza']) || !isset($persona['telefono']) || !isset($persona['id_tutore1'])) 
    {
        json_response(['error' => 'Dati mancanti'], 400);
        return;
    }

    try 
    {
        if (isset($persona['id_tutore2'])) 
        {
            $id_tutore2 = (int)$persona['id_tutore2'];
        } 
        else 
        {
            $id_tutore2 = null;
        }

        // Query SQL
        $sql = "UPDATE Persona SET 
            nome = ?, 
            cognome = ?, 
            data_nascita = ?, 
            luogo_nascita = ?, 
            citta_residenza = ?, 
            via_residenza = ?, 
            cap_residenza = ?, 
            telefono = ?, 
            id_tutore1 = ?, 
            id_tutore2 = ? 
            WHERE id_persona = ?";

        // Parametri
        $params = [
            $persona['nome'],
            $persona['cognome'],
            $persona['data_nascita'],
            $persona['luogo_nascita'],
            $persona['citta_residenza'],
            $persona['via_residenza'],
            $persona['cap_residenza'],
            $persona['telefono'],
            (int)$persona['id_tutore1'],
            $id_tutore2,
            (int)$id
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Persona aggiornata",
            'affected_rows' => $affected_rows
        ]);

    }
    catch (Exception $e) 
    {
        json_response(['error' => $e->getMessage()], 500); //visualizzare il msg di errore
    }
}

function delete_persona($db, $id)
{
    //niente json deve solo eliminare tramite l'id
    try 
    {
        // Query SQL
        $sql = "DELETE FROM Persona WHERE id_persona = ?";

        // Parametri
        $params = [
            (int)$id
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Persona eliminata",
            'affected_rows' => $affected_rows
        ]);

    } 
    catch (Exception $e) 
    {
        json_response(['error' => $e->getMessage()], 500); //problema di eliminazione per via della fk chiedere al prof!!
    }

}

// ===========================================================================
// ALTRO
// ===========================================================================

function authenticate_user($db) {
    $data = json_decode(file_get_contents('php://input'), true);
    json_response(['utente' => 'ciao']);
}

function delete_iter($db)
{
    // 1. Lettura del payload JSON
    $data = json_decode(file_get_contents('php://input'), true);

    var_dump($data);
    
    // 2. Validazione: servono obbligatoriamente name e price
    if (!$data || !isset($data['name']) || !isset($data['branca'])) {
        json_response(['error' => 'Dati mancanti (name, branca)'], 400);
        return;
    }

    try {
        $sql = "DELETE Iter VALUES (NULL, ?, ?, ?)";

        // È fondamentale rispettare l'ordine dei punti di domanda!
        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            $data['description'],  // 2° ? -> description (stringa),
            (int)$data['branca']   //3° ? -> branca(int)
        ];

        // 5. Esecuzione tramite Helper
        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Iter eliminato (Nome e Branca).",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        // Log dell'errore server (opzionale)
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'eliminazione dell\'iter. '], 500);
    }
}
/**
 * Funzione di esempio per una rotta custom.
 */
function mostra_messaggio_di_prova($db) {
    json_response(['message' => 'Questa è una risposta dalla rotta di prova!']);
}


//sezione per metodi partecipa
function get_all_partecipa($db) {
    try {
        $sql = "SELECT * FROM Partecipa";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_partecipa($db) {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id_attivita']) || !isset($data['id_unita'])) {
        json_response(['error' => 'Dati mancanti (id_attivita, id_unita)'], 400);
        return;
    }

    try {
        $sql = "INSERT INTO Partecipa (id_attivita, id_unita) VALUES (?, ?)";
        $params = [
            (int)$data['id_attivita'],
            (int)$data['id_unita']
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Partecipazione creata con successo.',
            'affected_rows' => $affected_rows
        ], 201);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione della partecipazione.'], 500);
    }
}

function update_partecipa($db, $id_attivita, $id_unita) {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['new_id_attivita']) || !isset($data['new_id_unita'])) {
        json_response(['error' => 'Dati mancanti (new_id_attivita, new_id_unita)'], 400);
        return;
    }

    try {
        $sql = "UPDATE Partecipa SET id_attivita = ?, id_unita = ? WHERE id_attivita = ? AND id_unita = ?";
        $params = [
            (int)$data['new_id_attivita'],  
            (int)$data['new_id_unita'],   
            (int)$id_attivita,              
            (int)$id_unita                  
        ];

        $affected_rows = $db->query($sql, $params);

        if ($affected_rows === 0) {
            json_response(['error' => 'Partecipazione non trovata.'], 404);
            return;
        }

        json_response([
            'success' => true,
            'message' => 'Partecipazione aggiornata con successo.',
            'affected_rows' => $affected_rows
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento della partecipazione.'], 500);
    }
}

function delete_partecipa($db, $id_attivita, $id_unita) {
    try {
        $sql = "DELETE FROM Partecipa WHERE id_attivita = ? AND id_unita = ?";
        $params = [
            (int)$id_attivita,
            (int)$id_unita
        ];

        $affected_rows = $db->query($sql, $params);

        if ($affected_rows === 0) {
            json_response(['error' => 'Partecipazione non trovata.'], 404);
            return;
        }

        json_response([
            'success' => true,
            'message' => 'Partecipazione eliminata con successo.',
            'affected_rows' => $affected_rows
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'eliminazione della partecipazione.'], 500);
    }
}

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

>>>>>>> main
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}