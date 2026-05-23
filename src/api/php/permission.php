<?php
    session_start();
        
    // array associativo: [tabella][tipologia] => array di metodi CRUD consentiti
    // C = Create, R = Read, U = Update, D = Delete, + = operazioni estese (non solo se stesso)
    $permessi = [
        'account' => [
            'minorenne'        => [],               
            'maggiorenne'      => ['C','R','U','D'],
            'aiuto_capo_unita' => ['C','R','U','D'],
            'capo_unita'       => ['C','R','U','D'],
            'aiuto_capo_gruppo'=> ['C','R','U','D'],
            'capo_gruppo'      => ['C','R','U','D'],
        ],
        'persona' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['C','R','U','D'],
            'aiuto_capo_unita' => ['R','+'],
            'capo_unita'       => ['C','R','U','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','+'],
            'capo_gruppo'      => ['C','R','U','+'],
        ],
        'iscrizione' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['R','+'],
            'capo_unita'       => ['C','R','U','D','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','D','+'],
            'capo_gruppo'      => ['C','R','U','D','+'],
        ],
        'iter' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['C','R','U','D','+'],
            'capo_unita'       => ['C','R','U','D','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','D','+'],
            'capo_gruppo'      => ['C','R','U','D','+'],
        ],
        'pagamento' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['R','+'],
            'capo_unita'       => ['C','R','U','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','+'],
            'capo_gruppo'      => ['C','R','U','+'],
        ],
        'servizio' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['R','+'],
            'capo_unita'       => ['R','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','D','+'],
            'capo_gruppo'      => ['C','R','U','D','+'],
        ],
        'tipologia' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['R','+'],
            'capo_unita'       => ['R','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','D','+'],
            'capo_gruppo'      => ['C','R','U','D','+'],
        ],
        'unita' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['C','R','U','D','+'],
            'capo_unita'       => ['C','R','U','D','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','D','+'],
            'capo_gruppo'      => ['C','R','U','D','+'],
        ],
        'branca' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['R','+'],
            'capo_unita'       => ['R','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','D','+'],
            'capo_gruppo'      => ['C','R','U','D','+'],
        ],
        'attivita' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['R','+'],
            'capo_unita'       => ['C','R','U','D','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','D','+'],
            'capo_gruppo'      => ['C','R','U','D','+'],
        ],
        'partecipa' => [
            'minorenne'        => ['R'],
            'maggiorenne'      => ['R'],
            'aiuto_capo_unita' => ['R','+'],
            'capo_unita'       => ['C','R','U','D','+'],
            'aiuto_capo_gruppo'=> ['C','R','U','D','+'],
            'capo_gruppo'      => ['C','R','U','D','+'],
        ],
    ];

    function permesso($tabella, $metodo)
    {
        global $permessi;   // per accedere alla variabile globale sopra

        if (!isset($_SESSION['tipologia']))
        {
            return false; // non autenticato
        }

        $tipologia = $_SESSION['tipologia'];

        if (!isset($permessi[$tabella]))
        {
            return false; // tabella non esistente
        }

        return in_array($metodo, $permessi[$tabella][$tipologia], true);
    }
