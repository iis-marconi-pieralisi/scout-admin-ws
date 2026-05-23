<?php
/*
    TEST DELLA ROTTA GET TIPOLOGIA 
    http GET https://probable-adventure-4jpv7r9q6jwwcj545-3000.app.github.dev/api/tipologia
*/
function read_tipologia($db, $data)
{
    try 
    {
        $sql = "SELECT * FROM Tipologia";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) 
    {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

/*
    TEST DELLA ROTTA POST TIPOLOGIA
    http POST https://probable-adventure-4jpv7r9q6jwwcj545-3000.app.github.dev/api/tipologia --raw ' {
    "id_tipologia": 11,
    "nome": "prova utente ",
    "descrizione": "prova"
  }'
*/
function create_tipologia($db, $data)
{
    $required_fields = ['nome', 'descrizione'];
    if (!validate_required_fields($data, $required_fields)) 
    {
        return;
    }

    try 
    {
        $sql = <<<EOD
        INSERT INTO Tipologia (nome, descrizione)
        VALUES (?, ?)
        EOD;

        $params = [$data['nome'],$data['descrizione'],];
        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Tipologia creata con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) 
    {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

/* TEST DELLA ROTTA PUT TIPOLOGIA 
    http PUT https://probable-adventure-4jpv7r9q6jwwcj545-3000.app.github.dev/api/tipologia --raw ' {
    "id_tipologia": 11,
    "nome": "prova utente ",
    "descrizione": "prova 2"
  }'
*/
function update_tipologia($db, $data)
{
    $required_fields = ['id_tipologia', 'nome', 'descrizione'];
    if (!validate_required_fields($data, $required_fields)) 
    {
        return;
    }

    try 
    {
        $sql = <<<EOD
        UPDATE Tipologia SET nome = ?, descrizione = ?
        WHERE id_tipologia = ?
        EOD;
        $params = [
            $data['nome'],
            $data['descrizione'],
            (int)$data['id_tipologia'],
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => 'Tipologia aggiornata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) 
    {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

/*
 TEST DELLA ROTTA DELETE TIPOLOGIA 
 http DELETE https://probable-adventure-4jpv7r9q6jwwcj545-3000.app.github.dev/api/tipologia --raw ' 
 {
    "id_tipologia": 12,
    "nome": "prova utente2 ",
    "descrizione": "prova 3"
  }'
*/
function delete_tipologia($db, $data)
{
    $required_fields = ['id_tipologia'];
    if (!validate_required_fields($data, $required_fields)) 
    {
        return;
    }

    try 
    {
        $sql = <<<EOD
        DELETE FROM Tipologia WHERE id_tipologia = ?
        EOD;
        $affected_rows = $db->query($sql, [(int)$data['id_tipologia']]);

        json_response([
            'success' => true,
            'message' => 'Tipologia eliminata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) 
    {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}