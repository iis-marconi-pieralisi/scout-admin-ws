<?php

// core/index.php

// Mostra tutti gli errori - utile in fase di sviluppo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Carica i file necessari nell'ordine corretto

// Funzioni helper condivise (json_response, generic_table_handler)
require_once __DIR__ . '/helpers.php';

// La mappa delle rotte (risale di un livello)
require_once __DIR__ . '/../routes.php';

// La funzione di routing (nella stessa cartella)
require_once __DIR__ . '/router.php';

// Il nostro helper per il database (nella stessa cartella)
require_once __DIR__ . '/Database.php';

// Crea l'istanza del DB una sola volta
$db = Database::getInstance();

// 2. Recupera le informazioni sulla richiesta attuale

// Il metodo HTTP (GET, POST, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// L'URI della richiesta, senza eventuali parametri GET (es. /api/utenti da /api/utenti?id=1)
$uri = strtok($_SERVER['REQUEST_URI'], '?');

// Chiama la funzione route(), passandole la mappa, il metodo, l'URI e ora anche il DB
route($routes, $method, $uri, $db);
