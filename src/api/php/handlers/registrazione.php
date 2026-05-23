<?php
    function registration($db, $data)
    {
        $required_fields = ['nome', 'cognome', 'data_nascita', 'luogo_nascita', 'citta_residenza', 'via_residenza', 'cap_residenza', 'telefono', 'id_tutore1', 'username', 'email', 'password'];
        if (!validate_required_fields($data, $required_fields)) 
        {
            return;
        }

        try 
        {
            $sql = <<<EOD
                    INSERT INTO Persona (nome, cognome, data_nascita, luogo_nascita, citta_residenza, via_residenza, cap_residenza, telefono, id_tutore1, id_tutore2) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    EOD;

            $params = [
                $data['nome'],
                $data['cognome'],
                $data['data_nascita'],
                $data['luogo_nascita'],
                $data['citta_residenza'],
                $data['via_residenza'],
                $data['cap_residenza'],
                $data['telefono'],
                (int)$data['id_tutore1'],
            ];

            if (isset($data['id_tutore2'])) 
            {
                $params[] = (int)$data['id_tutore2'];
            } 
            else 
            {
                $params[] = null;
            }

            $affected_rows = $db->query($sql, $params);

            if ($affected_rows > 0)
            {
                $sql = <<<EOD
                        SELECT id_persona FROM Persona 
                        WHERE nome = ? AND cognome = ? AND data_nascita = ? AND luogo_nascita = ? 
                        AND citta_residenza = ? AND via_residenza = ? AND cap_residenza = ? AND telefono = ?
                        EOD;

                $params = [
                $data['nome'],
                $data['cognome'],
                $data['data_nascita'],
                $data['luogo_nascita'],
                $data['citta_residenza'],
                $data['via_residenza'],
                $data['cap_residenza'],
                $data['telefono'],
                ]; 

                $result = $db->query($sql, $params);
                $id_persona = $result[0]['id_persona'];

                $sql = <<<EOD
                        INSERT INTO Account (username, password, email, id_persona) 
                        VALUES (?, ?, ?, ?)
                        EOD;

                $params = [
                    $data['username'],
                    password_hash($data['password'], PASSWORD_BCRYPT),
                    $data['email'],
                    $id_persona,
                ];

                $affected_rows = $db->query($sql, $params);

                if ($affected_rows > 0)
                {
                    json_response(['success' => 'Registrazione completata con successo.'], 201);
                }
                else
                {
                    json_response(['error' => 'Errore durante la creazione dell\'account.'], 500);
                }
            }
            else
            {
                json_response(['error' => 'Errore durante la creazione della persona.'], 500);
            }

        } 
        catch (Exception $e) 
        {
            error_log($e->getMessage());
            json_response(['error' => 'Errore durante la registrazione.'], 500);
        }
    }
?>