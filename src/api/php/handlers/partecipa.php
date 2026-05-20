<?php
/* test rotta GET (respons 200 ok)
[
  {
    "id_attivita": 5,
    "id_unita": 1
  },
  {
    "id_attivita": 5,
    "id_unita": 2
  },
  {
    "id_attivita": 2,
    "id_unita": 3
  },
  {
    "id_attivita": 5,
    "id_unita": 3
  },
  {
    "id_attivita": 3,
    "id_unita": 4
  },
  {
    "id_attivita": 5,
    "id_unita": 4
  },
  {
    "id_attivita": 1,
    "id_unita": 5
  },
  {
    "id_attivita": 2,
    "id_unita": 5
  },
  {
    "id_attivita": 4,
    "id_unita": 5
  },
  {
    "id_attivita": 5,
    "id_unita": 5
  },
  {
    "id_attivita": 4,
    "id_unita": 6
  },
  {
    "id_attivita": 5,
    "id_unita": 6
  },
  {
    "id_attivita": 1,
    "id_unita": 7
  },
  {
    "id_attivita": 3,
    "id_unita": 7
  },
  {
    "id_attivita": 4,
    "id_unita": 7
  }
]


{ test rotta POST (respons 200 ok)
  "success": true,
  "message": "Partecipazione creata con successo.",
  "affected_rows": 1
}


{ test rotta PUT (respons 200 ok)
  "success": true,
  "message": "Partecipazione aggiornata con successo.",
  "affected_rows": 1
}


{ test rotta DELETE (respons 200 ok)
  "success": true,
  "message": "Partecipazione eliminata con successo.",
  "affected_rows": 1
}
*/
function read_partecipa($db, $data)
{
    try {
        if (!empty($data['id_attivita']) && !empty($data['id_unita'])) {
            $sql = "SELECT * FROM Partecipa WHERE id_attivita = ? AND id_unita = ?";
            $params = [
                (int)$data['id_attivita'],
                (int)$data['id_unita'],
            ];
            $results = $db->query($sql, $params);
        } else {
            $sql = "SELECT * FROM Partecipa";
            $results = $db->query($sql);
        }

        if (empty($results)) {
            json_response(['error' => 'Partecipazione non trovata.'], 404);
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
            'success' => true,
            'message' => 'Partecipazione creata con successo.',
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
        $sql = <<<EOD
        UPDATE Partecipa SET id_attivita = ?, id_unita = ? 
        WHERE id_attivita = ? AND id_unita = ?
        EOD;
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
            'success' => true,
            'message' => 'Partecipazione aggiornata con successo.',
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
            'success' => true,
            'message' => 'Partecipazione eliminata con successo.',
            'affected_rows' => $affected_rows,
        ]);
    } catch (Exception $e) {
        error_log($e->getMessage());
        json_response(['error' => 'Errore durante l\'eliminazione della partecipazione.'], 500);
    }
}
