<?php
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
function create_iter($db)
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
        $sql = "INSERT INTO Iter VALUES (NULL, ?, ?, ?)";

        // È fondamentale rispettare l'ordine dei punti di domanda!
        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            $data['description'],  // 2° ? -> description (stringa),
            (int)$data['branca']         //3° ? -> branca(int)
        ];

        // 5. Esecuzione tramite Helper
        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Iter aggiornato (Nome e Branca).",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        // Log dell'errore server (opzionale)
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione dell\' iter. '], 500);
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
    }

    try {
        // 3. Query SQL
        // Usiamo i ? perché il tuo helper usa mysqli::prepare
        $sql = "UPDATE Iter SET name = ?, branca = ?, description = ? WHERE id_iter = ?";

        // 4. Preparazione Parametri
        // È fondamentale rispettare l'ordine dei punti di domanda!
        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            (int)$data['branca'],   // 2° ? -> branca (int)
            $data['description'],   // 3° ? -> description (stringa)
            (int)$id                // 4° ? -> id_iter (cast a int per bindare come 'i')
        ];

        // 5. Esecuzione tramite Helper
        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Iter aggiornato (Nome e Branca).",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        // Log dell'errore server (opzionale)
        // error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento dell\'iter.'], 500);
    }
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