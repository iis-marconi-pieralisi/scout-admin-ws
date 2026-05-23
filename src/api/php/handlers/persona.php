<?php
//http GET https://turbo-acorn-4jpv7r9jj6rr24wr-3000.app.github.dev/api/persona --raw ''
function read_persona($db, $data)
{
    try 
    {    
        $sql = "SELECT * FROM Persona";
        $results = $db->query($sql);
        json_response($results);

    } catch (Exception $e) 
    {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
/*
http POST https://turbo-acorn-4jpv7r9jj6rr24wr-3000.app.github.dev/api/persona --raw 
'{
        "nome": "prova_post",
        "cognome": "prova_post",
        "data_nascita": "2000-00-00",
        "luogo_nascita": "prova_post",
        "citta_residenza": "prova_post",
        "via_residenza": "prova_post",
        "cap_residenza": "00000",
        "telefono": "0",
        "id_tutore1": 1
       
}'
*/

function create_persona($db, $data)
{
    $required_fields = ['nome', 'cognome', 'data_nascita', 'luogo_nascita', 'citta_residenza', 'via_residenza', 'cap_residenza', 'telefono', 'id_tutore1'];
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
            isset($data['id_tutore2']) ? (int)$data['id_tutore2'] : null,
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Persona creata con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) 
    {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione della persona.'], 500);
    }
}
/*
http PUT https://turbo-acorn-4jpv7r9jj6rr24wr-3000.app.github.dev/api/persona --raw 
'{
        "id_persona": 1,
        "nome": "prova",
        "cognome": "prova",
        "data_nascita": "2000-00-00",
        "luogo_nascita": "prova",
        "citta_residenza": "prova",
        "via_residenza": "prova",
        "cap_residenza": "00000",
        "telefono": "0",
        "id_tutore1": 2,
        "id_tutore2": null
}
'
 */

function update_persona($db, $data)
{
    $required_fields = ['id_persona', 'nome', 'cognome', 'data_nascita', 'luogo_nascita', 'citta_residenza', 'via_residenza', 'cap_residenza', 'telefono', 'id_tutore1'];
    if (!validate_required_fields($data, $required_fields)) 
        {
        return;
    }

    try 
    {
        $sql = <<<EOD
        UPDATE Persona SET nome = ?, cognome = ?, data_nascita = ?, luogo_nascita = ?, citta_residenza = ?, via_residenza = ?, cap_residenza = ?, telefono = ?, id_tutore1 = ?, id_tutore2 = ? 
        WHERE id_persona = ?
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
            isset($data['id_tutore2']) ? (int)$data['id_tutore2'] : null,
            (int)$data['id_persona'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Persona aggiornata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) 
    {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
/*
http DELETE https://turbo-acorn-4jpv7r9jj6rr24wr-3000.app.github.dev/api/persona --raw 
'{
        "id_persona": 15
       
}'
*/
function delete_persona($db, $data)
{
    $required_fields = ['id_persona'];
    if (!validate_required_fields($data, $required_fields)) 
    {
        return;
    }

    try 
    {
        $sql = "DELETE FROM Persona WHERE id_persona = ?";
        $affected_rows = $db->query($sql, [(int)$data['id_persona']]);

        json_response([
            'success' => true,
            'message' => 'Persona eliminata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) 
    {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
