<?php
function get_iscrizione($db)
{
    try {
        $sql = <<<EOD
            SELECT *
            FROM Iscrizione;
        EOD;

        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function post_iscrizione($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        $anno_associativo  = $body['anno_associativo'];
        $approvazione_capo = $body['approvazione_capo'];
        $id_persona        = $body['id_persona'];
        $id_pagamento      = $body['id_pagamento'];
        $id_unita          = $body['id_unita'];
        $id_iter           = $body['id_iter'];

        $sql = <<<EOD
            INSERT INTO Iscrizione (anno_associativo, approvazione_capo, id_persona, id_pagamento, id_unita, id_iter)
            VALUES (:anno_associativo, :approvazione_capo, :id_persona, :id_pagamento, :id_unita, :id_iter);
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':anno_associativo'  => $anno_associativo,
            ':approvazione_capo' => $approvazione_capo,
            ':id_persona'        => $id_persona,
            ':id_pagamento'      => $id_pagamento,
            ':id_unita'          => $id_unita,
            ':id_iter'           => $id_iter
        ]);

        json_response(['message' => 'Iscrizione creata con successo.'], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function put_iscrizione($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        $anno_associativo  = $body['anno_associativo'];
        $approvazione_capo = $body['approvazione_capo'];
        $id_persona        = $body['id_persona'];
        $id_pagamento      = $body['id_pagamento'];
        $id_unita          = $body['id_unita'];
        $id_iter           = $body['id_iter'];

        $sql = <<<EOD
            UPDATE Iscrizione
            SET approvazione_capo = :approvazione_capo,
                id_pagamento      = :id_pagamento,
                id_unita          = :id_unita,
                id_iter           = :id_iter
            WHERE anno_associativo = :anno_associativo
              AND id_persona       = :id_persona;
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':anno_associativo'  => $anno_associativo,
            ':approvazione_capo' => $approvazione_capo,
            ':id_persona'        => $id_persona,
            ':id_pagamento'      => $id_pagamento,
            ':id_unita'          => $id_unita,
            ':id_iter'           => $id_iter
        ]);

        json_response(['message' => 'Iscrizione aggiornata con successo.']);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_iscrizione($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        $anno_associativo = $body['anno_associativo'];
        $id_persona       = $body['id_persona'];

        $sql = <<<EOD
            DELETE FROM Iscrizione
            WHERE anno_associativo = :anno_associativo
              AND id_persona       = :id_persona;
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':anno_associativo' => $anno_associativo,
            ':id_persona'       => $id_persona
        ]);

        json_response(['message' => 'Iscrizione eliminata con successo.']);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
?>