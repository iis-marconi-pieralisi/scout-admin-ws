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
                session_start();
                $username = $result[0]['username'];
                $tipologie = array_column($result, 'nome');

                if($tipologie[0] == 'Membro')
                {
                    $sql = "SELECT P.data_nascita 
                            FROM Account A JOIN Persona P ON A.id_persona = P.id_persona
                            WHERE A.username = ?";

                    $result = $db->query($sql, [$username]);
                    $data_nascita = $result[0]['data_nascita'];
                    $oggi = new DateTime();
                    $nascita = new DateTime($data_nascita);
                    $eta = $oggi->diff($nascita)->y; // anni compiuti

                    if ($eta >= 18) 
                    {
                        $tipologie[0] = "Maggiorenne";
                    } 
                    else 
                    {
                        $tipologie[0] = "Minorenne";

                    }
                }
            
                $_SESSION['username'] = $username;
                $_SESSION['tipologie'] = $tipologie;
                $sessionId = session_id();

                json_response([
                    'success' => true,
                    'message' => 'Sei Autenticato',
                    'username' => $username,
                    'tipologie' => $tipologie,
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