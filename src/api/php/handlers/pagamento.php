<?php
function read_pagamento($db, $data)
{
    try {
        $sql = "SELECT * FROM Pagamento ORDER BY data DESC";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function create_pagamento($db, $data)
{
    $required_fields = ['importo', 'metodo', 'data'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
INSERT INTO Pagamento (importo, metodo, data) 
VALUES (?, ?, ?)
EOD;
        $params = [
            $data['importo'],
            $data['metodo'],
            $data['data'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Pagamento creato con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function update_pagamento($db, $data)
{
    $required_fields = ['id_pagamento', 'importo', 'metodo', 'data'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
UPDATE Pagamento SET importo = ?, metodo = ?, data = ? 
WHERE id_pagamento = ?
EOD;
        $params = [
            $data['importo'],
            $data['metodo'],
            $data['data'],
            (int)$data['id_pagamento'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Pagamento aggiornato con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function delete_pagamento($db, $data)
{
    $required_fields = ['id_pagamento'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = "DELETE FROM Pagamento WHERE id_pagamento = ?";
        $affected_rows = $db->query($sql, [(int)$data['id_pagamento']]);

        json_response([
            'success' => true,
            'message' => 'Pagamento eliminato con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}