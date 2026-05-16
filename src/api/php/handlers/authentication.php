<?php
    function authenticate_user($db, $data) 
    {
        if ( !validate_required_fields($data, ['email', 'password']) )
            return;

        try
        {
            $sql = "SELECT A.username, A.password, T.nome 
                    FROM Account A JOIN Persona P ON A.id_persona = P.id_persona
                    JOIN Servizio S ON P.id_persona = S.id_persona
                    JOIN Tipologia T ON S.id_tipologia = T.id_tipologia
                    WHERE A.email = ? AND S.anno_associativo = YEAR(CURDATE())";

            $params = [$data['email']];
            $result = $db->query($sql, $params);

            if (!$result || count($result) == 0 || !password_verify($data['password'], $result[0]['password']))
            {
                json_response([
                    'success' => false,
                    'message' => 'Credenziali non valide'
                ], 401);
            }
            else
            {
                $username = $result[0]['username'];
                $tipologia = $result[0]['nome'];
                
                $_SESSION['username'] = $username;
                $_SESSION['tipologia'] = $tipologia;
                $sessionId = session_id();

                json_response([
                    'success' => true,
                    'message' => 'Sei Autenticato',
                    'username' => $username,
                    'tipologia' => $tipologia,
                    'session_id' => $sessionId
                ]);
            }
        }
        catch (Exception $e) 
        {
            json_response(['error' => $e->getMessage()], 500);
        }
    }
?>