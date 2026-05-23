<?php

/*http GET https://bookish-space-zebra-x5xp4gggw77vhp4xg-3000.app.github.dev/api/unita*/
/*http POST https://bookish-space-zebra-x5xp4gggw77vhp4xg-3000.app.github.dev/api/unita 
--raw 
'{
  "nome_unita": "Unita di test",
  "id_branca": 1
}'*/
function read_unita($db)
{
    try {
        $sql = <<<EOD
            SELECT  *
            FROM    Unita
        EOD;

        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}


function create_unita($db, $data)
{
    $required_fields = ['nome_unita', 'id_branca'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
INSERT INTO Unita (nome_unita, id_branca)
VALUES (?, ?)
EOD;
        $params = [
            $data['nome_unita'],
            (int)$data['id_branca'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Unita creata con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}


function update_unita($db, $data)
{
    $required_fields = ['id_unita', 'nome_unita', 'id_branca'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            UPDATE  Unita
            SET     nome_unita  = ?,
                    id_branca   = ?
            WHERE   id_unita    = ?
        EOD;

        $params = [
            $data['nome_unita'],
            (int)$data['id_branca'],
            (int)$data['id_unita'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success'       => true,
            'message'       => 'Unita aggiornata.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}


function delete_unita($db, $data)
{
    $required_fields = ['id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            DELETE FROM Unita
            WHERE id_unita = ?
        EOD;

        $affected_rows = $db->query($sql, [(int)$data['id_unita']]);

        json_response([
            'success' => true,
            'message' => 'Unita eliminata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
