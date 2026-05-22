<?php
// ==========================================
// TEST DELLA ROTTA GET TIPOLOGIA 
// Comando per replicare il test con HTTPie:
// http GET http://localhost:8080/api/tipologia
// ==========================================
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

// ==========================================
// TEST DELLA ROTTA POST TIPOLOGIA
// Comando per replicare il test con HTTPie:
// http POST http://localhost:3000/api/tipologia nome="prova Unita" descrizione="prova unità scout"
// ==========================================
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

// ==========================================
// TEST DELLA ROTTA PUT TIPOLOGIA 
// Comando per replicare il test con HTTPie:
// http PUT http://localhost:3000/api/tipologia id_tipologia=1 nome="provaa" descrizione="prova1"
// ==========================================
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

// ==========================================
// TEST DELLA ROTTA DELETE TIPOLOGIA 
// Comando per replicare il test con HTTPie:
// http DELETE http://localhost:3000/api/tipologia id_tipologia:=20
// ==========================================
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