<?php
function read_partecipa($db, $data)
{
    try {
        $sql = "SELECT * FROM Partecipa";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_partecipa($db, $data)
{
    $required_fields = ['id_attivita', 'id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = "INSERT INTO Partecipa (id_attivita, id_unita) VALUES (?, ?)";
        $params = [
            (int)$data['id_attivita'],
            (int)$data['id_unita'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Partecipazione creata con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione della partecipazione.'], 500);
    }
}

function update_partecipa($db, $data)
{
    $required_fields = ['id_attivita', 'id_unita', 'new_id_attivita', 'new_id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
        UPDATE Partecipa SET id_attivita = ?, id_unita = ? 
        WHERE id_attivita = ? AND id_unita = ?
        EOD;
        $params = [
            (int)$data['new_id_attivita'],
            (int)$data['new_id_unita'],
            (int)$data['id_attivita'],
            (int)$data['id_unita'],
        ];

        $affected_rows = $db->query($sql, $params);

        if ($affected_rows === 0) {
            json_response(['error' => 'Partecipazione non trovata.'], 404);
            return;
        }

        json_response([
            'success' => true,
            'message' => 'Partecipazione aggiornata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento della partecipazione.'], 500);
    }
}

function delete_partecipa($db, $data)
{
    $required_fields = ['id_attivita', 'id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = "DELETE FROM Partecipa WHERE id_attivita = ? AND id_unita = ?";
        $params = [
            (int)$data['id_attivita'],
            (int)$data['id_unita'],
        ];

        $affected_rows = $db->query($sql, $params);

        if ($affected_rows === 0) {
            json_response(['error' => 'Partecipazione non trovata.'], 404);
            return;
        }

        json_response([
            'success' => true,
            'message' => 'Partecipazione eliminata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'eliminazione della partecipazione.'], 500);
    }
}
