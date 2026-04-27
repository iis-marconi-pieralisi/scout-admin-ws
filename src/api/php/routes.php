<?php

/**
 * Router
 *
 * Mappa  METHOD + URI  →  handler function.
 * Le rotte con :id catturano il parametro dall'URI e lo passano all'handler.
 */

require_once 'handlers.php';

// ---------------------------------------------------------------------------
// Tabella delle rotte
// ---------------------------------------------------------------------------
$routes = [

    // ── Branche ────────────────────────────────────────────────────────────
    ['GET',    '/api/branche',          'read_branche'],
    ['POST',   '/api/branche',          'create_branche'],
    ['PUT',    '/api/branche',          'update_branche'],
    ['DELETE', '/api/branche',          'delete_branche'],

    // ── Ordini ─────────────────────────────────────────────────────────────
    ['GET',    '/api/orders',           'get_orders_join'],

    // ── Prodotti ───────────────────────────────────────────────────────────
    ['GET',    '/api/products',         'generic_table_handler'],
    ['POST',   '/api/products',         'create_product'],
    ['PUT',    '/api/products/:id',     'update_product'],

    // ── Utenti ─────────────────────────────────────────────────────────────
    ['GET',    '/api/users',            'generic_table_handler'],

    // ── Test ───────────────────────────────────────────────────────────────
    ['GET',    '/api/test',             'mostra_messaggio_di_prova'],
];

// ---------------------------------------------------------------------------
// Dispatch
// ---------------------------------------------------------------------------
$method = $_SERVER['REQUEST_METHOD'];
$uri    = strtok($_SERVER['REQUEST_URI'], '?');

foreach ($routes as [$routeMethod, $routePattern, $handler]) {

    if ($routeMethod !== $method) continue;

    // Converte :id in gruppo regex  es. /api/products/:id → #^/api/products/([^/]+)$#
    $regex = '#^' . preg_replace('/:([a-zA-Z_]+)/', '([^/]+)', $routePattern) . '$#';

    if (preg_match($regex, $uri, $matches)) {
        array_shift($matches);   // rimuove il match completo, restano solo i :param
        $handler($db, ...$matches);
        exit;
    }
}

json_response(['error' => 'Rotta non trovata.'], 404);