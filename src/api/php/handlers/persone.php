<?php
function read_persone($db)
{
         try {
        // EOD necessario per stringa literal multiriga
        $sql = <<<EOD
            SELECT *
            FROM Persona
        EOD;

        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function create_persona($db) 
{
    //prende il body della richiesta php e trasforma il json in un array associativo
    $persona = json_decode(file_get_contents('php://input'), true);

    //validazione json
    if (!$persona || !isset($persona['nome']) || !isset($persona['cognome']) || !isset($persona['data_nascita'])|| !isset($persona['luogo_nascita'])|| !isset($persona['citta_residenza'])|| !isset($persona['via_residenza'])|| !isset($persona['cap_residenza'])|| !isset($persona['telefono']) || !isset($persona['id_tutore1']) ) 
    {
        json_response(['error' => 'Dati mancanti' ], 400);
        return;
    }

    try 
    {
        if (isset($persona['id_tutore2'])) 
        {
            $id_tutore2 = (int)$persona['id_tutore2'];
        } 
        else 
        {
            $id_tutore2 = null;
        }

        // id_persona -> AUTO_INCREMENT (NULL)
        // id_tutore2 -> nullable (Null = Sì)
        $sql = "INSERT INTO Persona 
                    (nome, cognome, data_nascita, luogo_nascita, citta_residenza, via_residenza, cap_residenza, telefono, id_tutore1, id_tutore2) 
                VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $persona['nome'],                         
            $persona['cognome'],                       
            $persona['data_nascita'],                 
            $persona['luogo_nascita'],                 
            $persona['citta_residenza'],               
            $persona['via_residenza'],                 
            $persona['cap_residenza'],                 
            $persona['telefono'],                      
            (int)$persona['id_tutore1'],               
            $id_tutore2,                          
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Persona creata con successo.',
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione della persona.'], 500);
    }
    
}
function update_persona($db, $id) 
{
    $persona = json_decode(file_get_contents('php://input'), true);

    // Validazione JSON
    if (!$persona || !isset($persona['nome']) || !isset($persona['cognome']) || !isset($persona['data_nascita']) || !isset($persona['luogo_nascita']) || !isset($persona['citta_residenza']) || !isset($persona['via_residenza']) || !isset($persona['cap_residenza']) || !isset($persona['telefono']) || !isset($persona['id_tutore1'])) 
    {
        json_response(['error' => 'Dati mancanti'], 400);
        return;
    }

    try 
    {
        if (isset($persona['id_tutore2'])) 
        {
            $id_tutore2 = (int)$persona['id_tutore2'];
        } 
        else 
        {
            $id_tutore2 = null;
        }

        // Query SQL
        $sql = "UPDATE Persona SET 
            nome = ?, 
            cognome = ?, 
            data_nascita = ?, 
            luogo_nascita = ?, 
            citta_residenza = ?, 
            via_residenza = ?, 
            cap_residenza = ?, 
            telefono = ?, 
            id_tutore1 = ?, 
            id_tutore2 = ? 
            WHERE id_persona = ?";

        // Parametri
        $params = [
            $persona['nome'],
            $persona['cognome'],
            $persona['data_nascita'],
            $persona['luogo_nascita'],
            $persona['citta_residenza'],
            $persona['via_residenza'],
            $persona['cap_residenza'],
            $persona['telefono'],
            (int)$persona['id_tutore1'],
            $id_tutore2,
            (int)$id
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Persona aggiornata",
            'affected_rows' => $affected_rows
        ]);

    }
    catch (Exception $e) 
    {
        json_response(['error' => $e->getMessage()], 500); //visualizzare il msg di errore
    }
}
function delete_persona($db, $id)
{
    //niente json deve solo eliminare tramite l'id
    try 
    {
        // Query SQL
        $sql = "DELETE FROM Persona WHERE id_persona = ?";

        // Parametri
        $params = [
            (int)$id
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Persona eliminata",
            'affected_rows' => $affected_rows
        ]);

    } 
    catch (Exception $e) 
    {
        json_response(['error' => $e->getMessage()], 500); //problema di eliminazione per via della fk chiedere al prof!!
    }

}