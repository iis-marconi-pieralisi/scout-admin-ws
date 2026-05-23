<?php
/*
http POST https://potential-rotary-phone-69x55vrqx5qgh5w56-3000.app.github.dev/api/partecipa pippo==4 --raw '{
  "id_attivita":"3",
  "id_unita":"3"
}'*/
/*
http DELETE https://potential-rotary-phone-69x55vrqx5qgh5w56-3000.app.github.dev/api/partecipa pippo==4 --raw '{
  "id_attivita":"3",
  "id_unita":"3"
}'*/
/*
http PUT https://potential-rotary-phone-69x55vrqx5qgh5w56-3000.app.github.dev/api/partecipa pippo==4 --raw '{
  "id_attivita":"5",
  "id_unita":"5",
  "new_id_attivita":"1",
  "new_id_unita":"2"
}'*/
/*
http GET https://potential-rotary-phone-69x55vrqx5qgh5w56-3000.app.github.dev/api/partecipa --raw ''*/

function read_partecipa($db, $data)
{
    try {
        $has_attivita = !empty($data['id_attivita']);
        $has_unita    = !empty($data['id_unita']);
 
        if ($has_attivita && $has_unita) {
            // Lettura per chiave primaria composta
            $sql = "SELECT * FROM Partecipa WHERE id_attivita = ? AND id_unita = ?";
            $params = [
                (int)$data['id_attivita'],
                (int)$data['id_unita'],
            ];
            $results = $db->query($sql, $params);
 
            if (empty($results)) {
                json_response(['error' => 'Partecipazione non trovata.'], 404);
                return;
            }
        } elseif (!$has_attivita && !$has_unita) {
            // Fetch-all: tabella vuota è un risultato valido, non un errore
            $sql     = "SELECT * FROM Partecipa";
            $results = $db->query($sql);
        } else {
            // Un solo campo presente: input ambiguo, rifiutato esplicitamente
            json_response(['error' => 'Specificare entrambi id_attivita e id_unita.'], 400);
            return;
        }
 
        json_response($results);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante il recupero delle partecipazioni.'], 500);
    }
}
 
function create_partecipa($db, $data)
{
    $required_fields = ['id_attivita', 'id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }
 
    try {
        $sql = "INSERT INTO Partecipa (id_attivita, id_unita) VALUES (?, ?)";
        $params = [
            (int)$data['id_attivita'],
            (int)$data['id_unita'],
        ];
 
        $affected_rows = $db->query($sql, $params);
 
        json_response([
            'success'       => true,
            'message'       => 'Partecipazione creata con successo.',
            'affected_rows' => $affected_rows,
        ], 201);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante la creazione della partecipazione.'], 500);
    }
}
 
function update_partecipa($db, $data)
{
    $required_fields = ['id_attivita', 'id_unita', 'new_id_attivita', 'new_id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }
 
    try {
        $sql = "UPDATE Partecipa SET id_attivita = ?, id_unita = ? WHERE id_attivita = ? AND id_unita = ?";
        $params = [
            (int)$data['new_id_attivita'],
            (int)$data['new_id_unita'],
            (int)$data['id_attivita'],
            (int)$data['id_unita'],
        ];
 
        $affected_rows = $db->query($sql, $params);
 
        if ($affected_rows === 0) {
            json_response(['error' => 'Partecipazione non trovata.'], 404);
            return;
        }
 
        json_response([
            'success'       => true,
            'message'       => 'Partecipazione aggiornata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'aggiornamento della partecipazione.'], 500);
    }
}
 
function delete_partecipa($db, $data)
{
    $required_fields = ['id_attivita', 'id_unita'];
    if (!validate_required_fields($data, $required_fields)) {
        return;
    }
 
    try {
        $sql = "DELETE FROM Partecipa WHERE id_attivita = ? AND id_unita = ?";
        $params = [
            (int)$data['id_attivita'],
            (int)$data['id_unita'],
        ];
 
        $affected_rows = $db->query($sql, $params);
 
        if ($affected_rows === 0) {
            json_response(['error' => 'Partecipazione non trovata.'], 404);
            return;
        }
 
        json_response([
            'success'       => true,
            'message'       => 'Partecipazione eliminata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'eliminazione della partecipazione.'], 500);
    }
}
