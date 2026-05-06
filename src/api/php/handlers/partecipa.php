<?php
function read_partecipa($db) {
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
function update_partecipa($db, $id_attivita, $id_unita) 
{
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

    function delete_partecipa($db, $id_attivita, $id_unita) 
    {
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
    
}