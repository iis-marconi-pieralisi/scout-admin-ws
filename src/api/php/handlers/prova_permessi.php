<?php
    require_once __DIR__ . '/../permission.php';

    function prova_permesso()
    {
        var_dump(permesso('persona', 'R'));    // false (NO SESSIONE)

        // simula il login
        $_SESSION['tipologia'] = 'minorenne';
        var_dump(permesso('account', 'R'));    // false  (NO ACCESSO)
        var_dump(permesso('persona', 'R'));    // true
        var_dump(permesso('persona', 'C'));    // false

        $_SESSION['tipologia'] = 'capo_unita';
        var_dump(permesso('account', 'D'));    // true
        var_dump(permesso('iscrizione', 'D')); // true
        var_dump(permesso('servizio', 'C'));   // false  

        $_SESSION['tipologia'] = 'capo_gruppo';
        var_dump(permesso('servizio', 'C'));    // true
        var_dump(permesso('ciambella', 'C'));   // false (tabella inesistente)


        $_SESSION['tipologia'] = 'aiuto_capo_unita';
        var_dump(permesso('account', 'C'));     // true
        var_dump(permesso('partecipa', 'D'));   // false

        session_abort(); // termina la sessione, messa perchè rimaneva 'aiuto_capo_unita' per le prove successive
    }

    