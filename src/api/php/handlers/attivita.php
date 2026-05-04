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

function update_attivita($db){
    try {
        $sql = "UPDATE Attivita SET id_attivita = ? , nome = ? , descrizione = ? , luogo _partenza = ? , luogo_arrivo = ? , data = ? , id_persona = ? WHERE id_attivita = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function delete_attivita($db){
    try {
        $sql = "DELETE FROM Attivita WHERE id_attivita = ?";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}

function create_attivita($db){
    try {
        $sql = "INSERT INTO Attivita VALUES (nome, descrizione, luogo _partenza, luogo_arrivo, data, id_persona)";
        $results = $db->query($sql);
        json_response($results);
    } catch (Exception $e) {
        json_response(['error' => 'Errore interno del server.'], 500);
    }
}