<?php
function read_branche($db) 
{
    try {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT 	*
            FROM Branca
        EOD;
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) 
     
    {
        // In produzione, è buona norma non esporre i dettagli specifici dell'errore.
        // Si potrebbe loggare $e->getMessage() in un file di log per il debug.
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function create_branche($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['nome'])) {
        json_response(['error' => 'Campo obbligatorio mancante: nome.'], 400);
        return;
    }

    try {
        $sql = <<<EOD
            INSERT INTO Branca (nome, descrizione)
            VALUES (?, ?)
        EOD;

        $params = [
            $data['nome'],
            $data['descrizione'] ?? null,
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success'       => true,
            'message'       => 'Branca creata con successo.',
            'affected_rows' => $affected_rows,
        ]);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function update_branche($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id_branca']) || !isset($data['nome'])) {
        json_response(['error' => 'Campi obbligatori mancanti: id_branca, nome.'], 400);
        return;
    }

    try {
        $sql = <<<EOD
            UPDATE  Branca
            SET     nome        = ?,
                    descrizione = ?
            WHERE   id_branca   = ?
        EOD;

        $params = [
            $data['nome'],
            $data['descrizione'] ?? null,
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
function delete_branche($db)
{
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id_branca'])) {
        json_response(['error' => 'Campo obbligatorio mancante: id_branca.'], 400);
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