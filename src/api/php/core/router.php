<?php

/**
 * Funzione di Routing Semplificata
 *
 * @param array $routes La mappa di tutte le rotte disponibili (da routes.php).
 * @param string $method Il metodo HTTP della richiesta (es. 'GET', 'POST').
 * @param string $uri L'URI della richiesta (es. '/api/utenti').
 * @param object $db L'istanza del nostro oggetto Database.
 */
function route($routes, $method, $uri, $db) {
    // 1. Pulizia dell'URI: estraiamo il percorso e rimuoviamo gli slash agli estremi
    $uriClean = trim(parse_url($uri, PHP_URL_PATH), '/');

    // Controlliamo se esiste il metodo richiesto nella mappa delle rotte
    if (isset($routes[$method])) {
        
        foreach ($routes[$method] as $routePattern => $handler) {
            // Puliamo anche la rotta definita per avere un confronto equo
            $routeClean = trim($routePattern, '/');

            // 2. Confronto esatto: dato che non ci sono parametri dinamici, 
            // la stringa dell'URI deve essere identica alla rotta.
            if ($uriClean === $routeClean) {
                
                if (function_exists($handler)) {
                    header('Content-Type: application/json');
                    
                    // 3. Estrazione dei dati JSON dal body (per TUTTI i metodi)
                    $rawData = file_get_contents('php://input');
                    $data = json_decode($rawData, true);
                    
                    // Se il body è vuoto o il JSON non è valido, assicurati di passare un array vuoto
                    if (!is_array($data)) {
                        $data = [];
                    }

                    // 4. Esecuzione dell'handler: passiamo il DB e i dati estratti
                    $handler($db, $data);
                    return;
                }
            }
        }
    }

    // Nessuna rotta trovata
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Endpoint non trovato.']);
}