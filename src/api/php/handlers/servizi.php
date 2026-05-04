<?php
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