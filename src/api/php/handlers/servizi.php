<?php

function delete_servizio($db)
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
//GET
function read_servizio($db)
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

    } catch (Exception $e) {
        // Log dell'errore server (opzionale)
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento del prodotto. '], 500);
        mostra_messaggio_di_prova($db);
    }
}
function update_servizio($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    // controlla i campi richiesti
    if (
        !$data ||
        !isset($data['descrizione']) ||
        !isset($data['anno_associativo']) ||
        !isset($data['id_persona']) ||
        !isset($data['id_tipologia']) ||
        !isset($data['id_unità'])
    ) {
        json_response(['error' => 'Dati mancanti'], 400);
        return;
    }

    try {
        // aggiorna la descrizione del servizio identificato dalla chiave composta
        $sql = "
            UPDATE servizi SET descrizione = ? WHERE anno_associativo = ? AND id_persona = ? AND id_tipologia = ? AND id_unità = ?
        ";

        $params = [
            $data['descrizione'],
            (int)$data['anno_associativo'],
            (int)$data['id_persona'],
            (int)$data['id_tipologia'],
            (int)$data['id_unità']
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Servizio aggiornato correttamente.",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore durante l\'aggiornamento del servizio.'], 500);
    }
}
