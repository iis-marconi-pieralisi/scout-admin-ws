<?php
function read_pagamento($db){
    try {
        $sql = "SELECT * FROM Pagamento ORDER BY data DESC";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}
function create_pagamento($db){
    try {
        $sql = "INSERT INTO Pagamento VALUES (importo, metodo, data)";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }

        // 3. Query SQL
        // Usiamo i ? perché il tuo helper usa mysqli::prepare
        $sql = "UPDATE Iter SET name = ?, branca = ?, description = ? WHERE id_iter = ?";

        $params = [
            $data['name'],          // 1° ? -> name (stringa)
            (int)$data['branca'],   // 2° ? -> branca (int)
            $data['description'],   // 3° ? -> description (stringa)
            (int)$id                // 4° ? -> id_iter (cast a int per bindare come 'i')
        ];

        $affected_rows = $db->query($sql, $params);

        json_response([
            'success' => true,
            'message' => "Iter aggiornato (Nome e Branca).",
            'affected_rows' => $affected_rows
        ]);
}
function update_pagamento($db){
    try {
        $sql = "UPDATE Pagamento SET id_pagamento = ? , importo = ? , metodo = ?, data = ? WHERE id_pagamento = ?";
        $results = $db->query($sql);
        json_response($results);
    }
    catch(Exception $e)
    {}
}
function delete_pagamento($db){
    try {
        $sql = "DELETE FROM Pagamento WHERE id_pagamento = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
        // Log dell'errore server (opzionale)
        // error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento dell\'iter.'], 500);
    }
}
