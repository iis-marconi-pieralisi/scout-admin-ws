<?php
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
