<?php
function read_account($db, $data)
{
    if(!check_permission('account', 'R', $_SESSION['tipologia']))
    {
        json_response(['error' => 'Accesso non consentito.'], 403);
        return;
    }

    try {
        $sql = "SELECT * FROM Account";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_account($db, $data)
{
    if(!check_permission('account', 'C', $_SESSION['tipologia']))
    {
        json_response(['error' => 'Accesso non consentito.'], 403);
        return;
    }

    $required_fields = ['username', 'password', 'email', 'id_persona'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
          INSERT INTO Account (username, password, email, id_persona) 
          VALUES (?, ?, ?, ?)
          EOD;
        $params = [
            $data['username'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['email'],
            (int)$data['id_persona'],
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
    if(!check_permission('account', 'U', $_SESSION['tipologia']))
    {
        json_response(['error' => 'Accesso non consentito.'], 403);
        return;
    }

    $required_fields = ['username', 'password', 'email', 'id_persona'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = <<<EOD
          UPDATE Account SET password = ?, email = ?, id_persona = ? 
          WHERE username = ?
          EOD;
        $params = [
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['email'],
            (int)$data['id_persona'],
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

    if(!check_permission('account', 'D', $_SESSION['tipologia']))
    {
        json_response(['error' => 'Accesso non consentito.'], 403);
        return;
    }

    $required_fields = ['username'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }

    try {
        $sql = "DELETE FROM Account WHERE username = ?";
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