# 🧠 Architettura del sistema

Il progetto è suddiviso in due macro-sezioni principali:

* Backend
* Frontend

---

# ⚙️ Backend

## 🌐 Routing engine

Il routing non è automatico ma gestito manualmente tramite:

* router personalizzato
* mappa rotte → file handler

Questo permette controllo totale sugli endpoint.

---

## 🧭 Request lifecycle

Ogni richiesta passa per:

1. Apache intercetta richiesta
2. `.htaccess` riscrive URL
3. router interpreta endpoint
4. viene chiamato handler corretto
5. viene eseguita query
6. risposta JSON

---

## 🧱 Core system

Il core contiene la logica centrale del sistema.

Responsabilità:

* connessione database (`Database.php`)
* funzioni comuni (`helpers.php`)
* gestione base routing (`router.php`)
* punto di ingresso (`index.php`)

---

## 🗄️ Database layer

Il database viene gestito tramite la classe `Database` (Singleton).

Caratteristiche:

* connessione unica per tutta la richiesta
* prepared statements automatici contro SQL injection
* binding dinamico dei tipi (`i`, `d`, `s`)
* restituisce array per SELECT, `affected_rows` per INSERT/UPDATE/DELETE

---

## 📡 API structure

Ogni endpoint rappresenta una risorsa del database.

Endpoint disponibili:

* `/api/account`
* `/api/attivita`
* `/api/branca`
* `/api/iscrizione`
* `/api/iter`
* `/api/pagamento`
* `/api/partecipa`
* `/api/persona`
* `/api/servizio`
* `/api/tipologia`
* `/api/unita`

Endpoint speciali:

* `/api/auth` → autenticazione utente
* `/api/registration` → registrazione nuovo utente

Ogni endpoint supporta operazioni CRUD.

---

## 🔁 Handler system

Ogni handler:

* riceve input HTTP
* valida campi obbligatori tramite `validate_required_fields()`
* esegue query con prepared statements
* restituisce JSON

Non deve contenere logica di routing.

---

## 📤 Response system

Tutte le risposte seguono uno standard unico:

```json
{
  "success": true,
  "message": "...",
  "affected_rows": 1
}
```

Per i SELECT viene restituito direttamente l'array di risultati.

---

## ⚠️ Error handling

Errori gestiti sempre lato backend:

* input non valido → 400
* credenziali errate → 401
* risorse non trovate → 404
* query fallite → 500

---

## 🔐 Autenticazione

Il sistema di login (`authenticate_user`):

* verifica email e password con `password_verify()`
* controlla la tipologia di servizio per l'anno corrente
* se il ruolo è `Membro`, distingue automaticamente tra `Maggiorenne` e `Minorenne` in base alla data di nascita
* avvia sessione con `session_start()` e salva `username` e `tipologie`

La registrazione (`registration`):

* crea `Persona` e `Account` in sequenza atomica
* la password viene hashata con `password_hash()` e `PASSWORD_BCRYPT`

---

## 🌍 Apache & rewrite

Il sistema usa `mod_rewrite` per:

* rimuovere `index.php` dall'URL
* gestire endpoint puliti

---

## 📦 Dipendenze

Composer viene usato solo per:

* gestione librerie PHP
* autoload classi

---

## 🧠 Concetto chiave backend

Il sistema backend è:

* modulare
* separato per responsabilità
* scalabile per nuove API

---

# 🎨 Frontend

## 📄 Pagine disponibili

Le pagine si trovano in `src/public/`:

* `index.html` → login
* `account.html` → gestione account
* `iscrizione.html` → gestione iscrizioni
* `branca.html` → gestione branche

---

## 🧩 Struttura JS

Ogni pagina ha un file JS dedicato.

File condiviso:

* `main.js` → helpers comuni a tutte le pagine

File specifici per pagina:

* `account.js` → logica CRUD per account
* `iscrizione.js` → logica CRUD per iscrizioni

---

## 🛠️ Helpers condivisi (`main.js`)

Funzioni disponibili ovunque:

* `getById(id)` → shortcut per `getElementById`
* `getValue(id)` / `setValue(id, value)` → lettura/scrittura campi
* `getChecked(id)` / `setChecked(id, value)` → checkbox
* `resetForm(id)` → reset form
* `showResponse(message, isError)` → mostra risposta API a schermo
* `handleFetchError(error)` → gestione errori fetch
* `apiRequest(method, url, body)` → chiamata API generica con JSON
* `escapeHtml(value)` / `escapeAttr(value)` → sicurezza XSS

---

## 🔁 Pattern pagine CRUD

Ogni pagina JS segue lo stesso pattern:

1. fetch iniziale dei dati al caricamento pagina
2. render della tabella con `renderXxx(items)`
3. form in modalità `create` o `edit`
4. modifica inline diretta nella riga della tabella
5. salvataggio con `PUT`, creazione con `POST`, eliminazione con `DELETE`
6. refresh automatico della tabella dopo ogni operazione

---

## 📋 Gestione form

Il form può essere in due modalità:

* `create` → bottone "Crea", colore primario
* `edit` → bottone "Modifica", colore info

Il cambio modalità aggiorna titolo e bottone dinamicamente.

---

## 🔒 Sicurezza XSS

Tutti i valori inseriti nella tabella passano per:

* `escapeHtml()` → per il contenuto visibile
* `escapeAttr()` → per gli attributi dei tag HTML

---

## 🧠 Concetto chiave frontend

Il frontend è:

* stateless (nessun dato salvato localmente)
* orientato alle API (tutto passa per fetch)
* separato per pagina con helpers condivisi
