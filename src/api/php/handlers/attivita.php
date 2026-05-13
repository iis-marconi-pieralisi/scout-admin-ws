<?php
function read_attivita($db, $data)
{
    try {
        $sql = "SELECT * FROM Attivita ORDER BY data DESC";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_attivita($db, $data)
{
    $required_fields = ['nome', 'luogo_partenza', 'luogo_arrivo', 'data', 'id_persona'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            INSERT INTO Attivita (nome, descrizione, luogo_partenza, luogo_arrivo, data, id_persona) 
            VALUES (?, ?, ?, ?, ?, ?)
        EOD;
        $params = [
            $data['nome'],
            $data['descrizione'] ?? null,
            $data['luogo_partenza'],
            $data['luogo_arrivo'],
            $data['data'],
            (int)$data['id_persona'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Attività creata con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function update_attivita($db, $data)
{
    $required_fields = ['id_attivita', 'nome', 'luogo_partenza', 'luogo_arrivo', 'data', 'id_persona'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            UPDATE Attivita SET nome = ?, descrizione = ?, luogo_partenza = ?, luogo_arrivo = ?, data = ?, id_persona = ? 
            WHERE id_attivita = ?
        EOD;
        $params = [
            $data['nome'],
            $data['descrizione'] ?? null,
            $data['luogo_partenza'],
            $data['luogo_arrivo'],
            $data['data'],
            (int)$data['id_persona'],
            (int)$data['id_attivita'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Attività aggiornata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_attivita($db, $data)
{
    $required_fields = ['id_attivita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = "DELETE FROM Attivita WHERE id_attivita = ?";
        $affected_rows = $db->query($sql, [(int)$data['id_attivita']]);

        json_response([
            'success' => true,
            'message' => 'Attività eliminata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
