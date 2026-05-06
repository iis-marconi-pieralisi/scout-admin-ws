<?php
function read_attivita($db){
    try {
        $sql = "SELECT * FROM Attivita ORDER BY data DESC";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function create_attivita($db){
    try {
        $sql = "INSERT INTO Attivita VALUES (nome, descrizione, luogo _partenza, luogo_arrivo, data, id_persona)";
    }
    catch(Exception $e)
    {}
}
function update_attivita($db){
    try {
        $sql = "UPDATE Attivita SET id_attivita = ? , nome = ? , descrizione = ? , luogo _partenza = ? , luogo_arrivo = ? , data = ? , id_persona = ? WHERE id_attivita = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
        $sql = "INSERT INTO Iter VALUES (NULL, ?, ?, ?)";

        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            $data['description'],  // 2° ? -> description (stringa),
            (int)$data['branca']         //3° ? -> branca(int)
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Iter aggiornato (Nome e Branca).",
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione dell\' iter. '], 500);
    }
}
