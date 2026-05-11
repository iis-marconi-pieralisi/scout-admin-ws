<?php
function delete_tipologia($db)
{
    
    $data = json_decode(file_get_contents('php://input'), true);

    // Validazione
    if (!$data ||!isset($data['id_tipologia'])) 
    {
        // Restituisce errore 400 se manca l'id necessario per la cancellazione
        json_response(['error' => 'Chiave primaria mancante'], 400);
        return;
    }

    try {
        $sql = "DELETE FROM Tipologia WHERE id_tipologia = ?";

        $params = [(int)$data['id_tipologia']];

        // Esegue la DELETE e restituisce quante righe sono state eliminate
        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Tipologia eliminata',
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) 
    {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante DELETE Tipologia'], 500);
    }
}


function create_tipologia($db) 
{
    $data = json_decode(file_get_contents('php://input'), true);

    // Validazione: servono nome e descrizione
    if (!$data || !isset($data['nome']) || !isset($data['descrizione'])) 
    {
        json_response(['error' => 'Dati mancanti (nome, descrizione)'], 400);
        return;
    }

    try 
    {
        $sql = "INSERT INTO Tipologia (nome, descrizione) VALUES (?, ?)";

        $params = [
            $data['nome'],
            $data['descrizione']
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Tipologia creata",
            'affected_rows' => $affected_rows
        ]);

    } 
    catch (Exception $e) 
    {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione della tipologia'], 500);
    }
}


function update_tipologia($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    // controlla i campi richiesti
    if (!$data ||!isset($data['descrizione']) ||!isset($data['id_tipologia']) ||!isset($data['nome']))     
    {
        json_response(['error' => 'Dati mancanti'], 400);
        return;
    }
    try 
    {
        $sql = "UPDATE tipologia SET descrizione = ? WHERE id_tipologia  = ? AND nome = ? ";

        $params = [
        $data['descrizione'],
        (int)$data['id_tipologia'],
        $data['nome']];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Servizio aggiornato correttamente.",
            'affected_rows' => $affected_rows
        ]);
    
    } catch (Exception $e) 
    {
        json_response(['error' => 'Errore durante l\'aggiornamento del servizio.'], 500);
    }
}


function read_tipologia($db)
{
    try 
    {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT *
            FROM Tipologia 
        EOD;

        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) 
    {
        // In produzione, è buona norma non esporre i dettagli specifici dell'errore.
        // Si potrebbe loggare $e->getMessage() in un file di log per il debug.
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
?>