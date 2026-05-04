<?php
function read_account($db)
{
    try {
        $sql = <<<EOD
            SELECT *
            FROM Account;
        EOD;

        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function create_account($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body || !isset($body['username']) || !isset($body['password']) || !isset($body['email'])) {
            json_response(['error' => 'Dati mancanti (username, password, email).'], 400);
            return;
        }

        $username = $body['username'];
        $password = password_hash($body['password'], PASSWORD_BCRYPT);
        $email    = $body['email'];

        $sql = <<<EOD
            INSERT INTO Account (username, password, email)
            VALUES (:username, :password, :email);
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':email'    => $email
        ]);

        json_response(['message' => 'Account creato con successo.'], 201);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function update_account($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body || !isset($body['id']) || !isset($body['username']) || !isset($body['password']) || !isset($body['email'])) {
            json_response(['error' => 'Dati mancanti (id, username, password, email).'], 400);
            return;
        }

        $id       = (int) $body['id'];
        $username = $body['username'];
        $password = password_hash($body['password'], PASSWORD_BCRYPT);
        $email    = $body['email'];

        $sql = <<<EOD
            UPDATE Account
            SET username = :username,
                password = :password,
                email    = :email
            WHERE id = :id;
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id'       => $id,
            ':username' => $username,
            ':password' => $password,
            ':email'    => $email
        ]);

        json_response(['message' => 'Account aggiornato con successo.']);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_account($db)
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body || !isset($body['id'])) {
            json_response(['error' => 'Dati mancanti (id).'], 400);
            return;
        }

        $id = (int) $body['id'];

        $sql = <<<EOD
            DELETE FROM Account
            WHERE id = :id;
        EOD;

        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);

        json_response(['message' => 'Account eliminato con successo.']);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}