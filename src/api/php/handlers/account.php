<?php

/**
 * Test svolti
 *
 * read_account:
 * - Restituisce tutti gli account presenti
 * - Restituisce [] se la tabella è vuota
 *
 * create_account:
 * - Crea un account con username, password, email validi
 * - Rifiuta la richiesta se manca uno dei campi obbligatori
 * - Restituisce 500 se username già esistente (UNIQUE constraint)
 * - Salva la password come hash bcrypt (non in chiaro)
 *
 * update_account:
 * - Aggiorna password ed email di un account esistente
 * - Restituisce affected_rows=0 se username non esiste (nessun errore)
 * - Rifiuta la richiesta se manca uno dei campi obbligatori
 * - Salva la nuova password come hash bcrypt (non in chiaro)
 *
 * delete_account:
 * - Elimina l'account con lo username indicato
 * - Restituisce affected_rows=0 se username non esiste (nessun errore)
 * - Rifiuta la richiesta se manca il campo "username"
 *
 */

function read_account($db, $data)
{
    try {
        $sql = <<<EOD
            SELECT * 
            FROM Account
            EOD;
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_account($db, $data)
{
    $required_fields = ['username', 'password', 'email'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            INSERT INTO Account (username, password, email) 
            VALUES (?, ?, ?)
            EOD;
        $params = [
            $data['username'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['email'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Account creato con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function update_account($db, $data)
{
    $required_fields = ['username', 'password', 'email'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            UPDATE Account SET password = ?, email = ? 
            WHERE username = ?
            EOD;
        $params = [
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['email'],
            $data['username'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Account aggiornato con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_account($db, $data)
{
    $required_fields = ['username'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
            DELETE FROM Account 
            WHERE username = ?
            EOD;
        $affected_rows = $db->query($sql, [$data['username']]);

        json_response([
            'success' => true,
            'message' => 'Account eliminato con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}