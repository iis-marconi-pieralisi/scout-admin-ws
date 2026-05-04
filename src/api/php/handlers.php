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

function get_branche($db)
{
    try {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT 	*
            FROM Branca;
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

function read_branche($db) 
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
        // In produzione, è buona norma non esporre i dettagli specifici dell'errore.
        // Si potrebbe loggare $e->getMessage() in un file di log per il debug.
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

        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        // In produzione, è buona norma non esporre i dettagli specifici dell'errore.
        // Si potrebbe loggare $e->getMessage() in un file di log per il debug.
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

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

    } 
    catch (Exception $e) 
    {
        // Log dell'errore server (opzionale)
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento del prodotto. '], 500);
        mostra_messaggio_di_prova($db);
    }
}

//PUT
function update_servizio($db)
{

}

//DELETE
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
    }

}


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

function authenticate_user1($db) 
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['email']) || !isset($data['password'])) 
    {
        json_response(['error' => 'Dati mancanti'], 400);
        return;
    }

    try
    {
        $sql = "SELECT T.nome 
                FROM Account A JOIN Persona P ON A.id_persona = P.id_persona
                JOIN Servizio S ON P.id_persona = S.id_persona
                JOIN Tipologia T ON S.id_tipologia = T.id_tipologia
                WHERE A.email = ? AND A.password = ? AND S.anno_associativo = YEAR(CURDATE())";

        $params = [$data['email'], $data['password']];

        $result = $db->query($sql, $params);

        if (!$result || count($result) == 0)
        {
            json_response([
                'success' => false,
                'message' => 'Credenziali non valide'
            ], 401);
        }
        else
        {
            json_response([
                'success' => true,
                'message' => 'Ecco la tipologia',
                'tipologia' => $result[0]['nome']
            ]);
        }
        
    }
    catch (Exception $e) 
    {
        json_response(['error' => $e->getMessage()], 500);
    }
}

function authenticate_user($db) 
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['email']) || !isset($data['password'])) 
    {
        json_response(['error' => 'Dati mancanti'], 400);
        return;
    }

    try
    {
        $sql = "SELECT T.nome 
                FROM Account A JOIN Persona P ON A.id_persona = P.id_persona
                JOIN Servizio S ON P.id_persona = S.id_persona
                JOIN Tipologia T ON S.id_tipologia = T.id_tipologia
                WHERE A.email = ? AND A.password = ? AND S.anno_associativo = YEAR(CURDATE())";

        $params = [$data['email'], $data['password']];

        $result = $db->query($sql, $params);

        if (!$result || count($result) == 0)
        {
            json_response([
                'success' => false,
                'message' => 'Credenziali non valide'
            ], 401);
        }
        else
        {
            json_response([
                'success' => true,
                'message' => 'Ecco la tipologia',
                'tipologia' => $result[0]['nome']
            ]);
        }
        
    }
    catch (Exception $e) 
    {
        json_response(['error' => $e->getMessage()], 500);
    }
}

/**
 * Funzione di esempio per una rotta custom.
 */
function mostra_messaggio_di_prova($db) 
{
    json_response(['message' => 'Questa è una risposta dalla rotta di prova!']);
}
