<?php

function read_branca($db)
{
    try {
        $sql = <<<EOD
            SELECT  *
            FROM    Branca
        EOD;

        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}


function create_branca($db, $data)
{
    if (!validate_required_fields($data, ['nome_branca', 'min_eta', 'max_eta'])) {
        return;
    }

    try {
        $sql = <<<EOD
            INSERT INTO Branca (nome_branca, min_eta, max_eta)
            VALUES (?, ?, ?)
        EOD;

        $params = [
            $data['nome_branca'],
            (int)$data['min_eta'],
            (int)$data['max_eta'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success'       => true,
            'message'       => 'Branca creata con successo.',
            'affected_rows' => $affected_rows,
        ], 201);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}


function update_branca($db, $data)
{
    if (!validate_required_fields($data, ['id_branca', 'nome_branca', 'min_eta', 'max_eta'])) {
        return;
    }

    try {
        $sql = <<<EOD
            UPDATE  Branca
            SET     nome_branca = ?,
                    min_eta     = ?,
                    max_eta     = ?
            WHERE   id_branca   = ?
        EOD;

        $params = [
            $data['nome_branca'],
            (int)$data['min_eta'],
            (int)$data['max_eta'],
            (int)$data['id_branca'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success'       => true,
            'message'       => 'Branca aggiornata.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}


function delete_branca($db, $data)
{
    if (!validate_required_fields($data, ['id_branca'])) {
        return;
    }

    try {
        $sql = <<<EOD
            DELETE FROM Branca
            WHERE id_branca = ?
        EOD;

        $affected_rows = $db->query($sql, [(int)$data['id_branca']]);

        json_response([
            'success'       => true,
            'message'       => 'Branca eliminata.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}