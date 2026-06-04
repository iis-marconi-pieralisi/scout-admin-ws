<?php
    function read_tutore($db, $data)
    {
        try
        {
            $sql = "SELECT id_persona, nome, cognome FROM Persona ORDER BY cognome, nome";
            $result = $db->query($sql);
            json_response($result);
        }
        catch (Exception $e)
        {
            json_response(['error' => 'Errore interno del server.'], 500);
        }
    }