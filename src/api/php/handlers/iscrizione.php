<?php

/**
 * Test svolti
 *
 * read_iscrizione:
 * - Restituisce tutte le iscrizioni presenti
 * - Restituisce [] se la tabella è vuota
 *
 * create_iscrizione:
 * - Crea un'iscrizione con tutti i campi obbligatori validi
 * - Rifiuta la richiesta se manca uno dei campi obbligatori 
 *   (anno_associativo, approvazione_capo, id_persona, id_pagamento, id_unita, id_iter)
 * - Restituisce 500 se una FK non esiste (id_persona, id_pagamento, id_unita, id_iter)
 * - Effettua il cast corretto dei tipi (int, bool) prima dell'inserimento
 *
 * update_iscrizione:
 * - Aggiorna approvazione_capo, id_pagamento, id_unita, id_iter
 *   identificando il record tramite anno_associativo + id_persona
 * - Restituisce affected_rows=0 se la coppia chiave non esiste (nessun errore)
 * - Rifiuta la richiesta se manca uno dei campi obbligatori
 * - Effettua il cast corretto dei tipi (int, bool) prima dell'aggiornamento
 *
 * delete_iscrizione:
 * - Elimina l'iscrizione identificata da anno_associativo + id_persona
 * - Restituisce affected_rows=0 se la coppia chiave non esiste (nessun errore)
 * - Rifiuta la richiesta se manca anno_associativo o id_persona
 *
*/

function read_iscrizione($db, $data)
{
    try {
        $sql = <<<EOD
            SELECT * 
            FROM Iscrizione
            EOD;
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_iscrizione($db, $data)
{
    $required_fields = ['anno_associativo', 'approvazione_capo', 'id_persona', 'id_pagamento', 'id_unita', 'id_iter'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            INSERT INTO Iscrizione (anno_associativo, approvazione_capo, id_persona, id_pagamento, id_unita, id_iter) 
            VALUES (?, ?, ?, ?, ?, ?)
            EOD;
        $params = [
            (int)$data['anno_associativo'],
            (bool)$data['approvazione_capo'],
            (int)$data['id_persona'],
            (int)$data['id_pagamento'],
            (int)$data['id_unita'],
            (int)$data['id_iter'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Iscrizione creata con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function update_iscrizione($db, $data)
{
    $required_fields = ['anno_associativo', 'id_persona', 'approvazione_capo', 'id_pagamento', 'id_unita', 'id_iter'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            UPDATE Iscrizione SET approvazione_capo = ?, id_pagamento = ?, id_unita = ?, id_iter = ? 
            WHERE anno_associativo = ? AND id_persona = ?
            EOD;
        $params = [
            (bool)$data['approvazione_capo'],
            (int)$data['id_pagamento'],
            (int)$data['id_unita'],
            (int)$data['id_iter'],
            (int)$data['anno_associativo'],
            (int)$data['id_persona'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Iscrizione aggiornata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_iscrizione($db, $data)
{
    $required_fields = ['anno_associativo', 'id_persona'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            DELETE FROM Iscrizione 
            WHERE anno_associativo = ? AND id_persona = ?
            EOD;
        $affected_rows = $db->query($sql, [(int)$data['anno_associativo'], (int)$data['id_persona']]);

        json_response([
            'success' => true,
            'message' => 'Iscrizione eliminata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}