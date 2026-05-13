<?php
function read_iter($db, $data)
{
    try {
        $sql = "SELECT * FROM Iter";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function create_iter($db, $data)
{
    $required_fields = ['nome', 'id_branca'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
INSERT INTO Iter (nome, descrizione, id_branca) 
VALUES (?, ?, ?)
EOD;
        $params = [
            $data['nome'],
            $data['descrizione'] ?? null,
            (int)$data['id_branca'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Iter creato con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function update_iter($db, $data)
{
    $required_fields = ['id_iter', 'nome', 'id_branca'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
UPDATE Iter SET nome = ?, descrizione = ?, id_branca = ? 
WHERE id_iter = ?
EOD;
        $params = [
            $data['nome'],
            $data['descrizione'] ?? null,
            (int)$data['id_branca'],
            (int)$data['id_iter'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Iter aggiornato con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function delete_iter($db, $data)
{
    $required_fields = ['id_iter'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = "DELETE FROM Iter WHERE id_iter = ?";
        $affected_rows = $db->query($sql, [(int)$data['id_iter']]);

        json_response([
            'success' => true,
            'message' => 'Iter eliminato con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}