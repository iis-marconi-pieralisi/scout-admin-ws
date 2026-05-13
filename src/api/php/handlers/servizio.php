<?php
function read_servizio($db, $data)
{
    try {
        $sql = "SELECT * FROM Servizio";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function create_servizio($db, $data)
{
    $required_fields = ['descrizione', 'anno_associativo', 'id_persona', 'id_tipologia', 'id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
INSERT INTO Servizio (descrizione, anno_associativo, id_persona, id_tipologia, id_unita)
VALUES (?, ?, ?, ?, ?)
EOD;
        $params = [
            $data['descrizione'],
            (int)$data['anno_associativo'],
            (int)$data['id_persona'],
            (int)$data['id_tipologia'],
            (int)$data['id_unita'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Servizio creato con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function update_servizio($db, $data)
{
    $required_fields = ['anno_associativo', 'id_persona', 'descrizione', 'id_tipologia', 'id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
UPDATE Servizio SET descrizione = ?, id_tipologia = ?, id_unita = ?
WHERE anno_associativo = ? AND id_persona = ?
EOD;
        $params = [
            $data['descrizione'],
            (int)$data['id_tipologia'],
            (int)$data['id_unita'],
            (int)$data['anno_associativo'],
            (int)$data['id_persona'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Servizio aggiornato con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function delete_servizio($db, $data)
{
    $required_fields = ['anno_associativo', 'id_persona'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
DELETE FROM Servizio
WHERE anno_associativo = ? AND id_persona = ?
EOD;
        $params = [
            (int)$data['anno_associativo'],
            (int)$data['id_persona'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Servizio eliminato con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante DELETE Servizio'], 500);
    }
}
