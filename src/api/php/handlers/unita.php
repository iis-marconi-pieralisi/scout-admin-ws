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


function create_unita($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['nome_unita']) || !isset($data['id_branca'])) {
        json_response(['error' => 'Campi obbligatori mancanti: nome_unita, id_branca.'], 400);
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
            'success'       => true,
            'message'       => 'Unita creata con successo.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}


function update_unita($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id_unita']) || !isset($data['nome_unita']) || !isset($data['id_branca'])) {
        json_response(['error' => 'Campi obbligatori mancanti: id_unita, nome_unita, id_branca.'], 400);
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


function delete_unita($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id_unita'])) {
        json_response(['error' => 'Campo obbligatorio mancante: id_unita.'], 400);
        return;
    }

    try {
        $sql = <<<EOD
            DELETE FROM Unita
            WHERE id_unita = ?
        EOD;

        $affected_rows = $db->query($sql, [(int)$data['id_unita']]);

        json_response([
            'success'       => true,
            'message'       => 'Unita eliminata.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
