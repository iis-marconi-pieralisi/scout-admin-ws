# 📏 Standard di sviluppo del progetto

Questo documento definisce le regole di coerenza del codice per mantenere il progetto leggibile, scalabile e uniforme.

---

# 🧠 Principio guida

Il codice deve essere:

- prevedibile
- coerente
- facilmente leggibile da chiunque del team

---

# 🏗️ Architettura logica

Il progetto segue una separazione logica:

- core → logica centrale
- API → esposizione dati
- DB → persistenza
- frontend → interfaccia utente

---

# 🧾 Naming semantico

## Regola fondamentale

👉 I nomi devono descrivere il comportamento, non l'implementazione

---

## PHP files

✔ corretto:
- `create_persona.php`
- `update_attivita.php`

❌ scorretto:
- `file1.php`
- `test.php`

---

## Variabili PHP

Devono essere descrittive, in camelCase:

```php
$utenteAttivo
$idPersona
$listaPartecipanti
```

---

## Variabili JS

Stesse regole del PHP, in camelCase:

```js
let accountCache
let iscrizioneFormMode
const API_ACCOUNT
```

Le costanti API usano UPPER_SNAKE_CASE:

```js
const API_ISCRIZIONE = '/api/iscrizione'
const API_PERSONA = '/api/persona'
```

---

## Funzioni JS

Il nome deve indicare l'azione e la risorsa:

✔ corretto:
- `fetchAccounts()`
- `renderIscrizioni()`
- `deleteIscrizioneRow()`

❌ scorretto:
- `doStuff()`
- `handle()`

---

## Funzioni PHP handler

Il nome segue il pattern `<verbo>_<risorsa>`:

✔ corretto:
- `read_branca`
- `create_iscrizione`
- `delete_persona`

❌ scorretto:
- `branca_get`
- `handleReq`

---

# 🧬 Struttura dati

## JSON sempre coerente

Tutte le API devono rispettare:

```json
{
  "status": "success|error",
  "data": {},
  "message": ""
}
```

---

## Campi obbligatori

Ogni handler dichiara esplicitamente i campi richiesti:

```php
$required_fields = ['nome', 'cognome', 'data_nascita'];
if (!validate_required_fields($data, $required_fields)) {
    return;
}
```

---

## Cast dei tipi

I parametri devono essere castati prima dell'uso:

```php
(int)$data['id_persona']
(bool)$data['approvazione_capo']
```

---

# ⚙️ Logica backend

Regole:

- ogni file deve avere UNA responsabilità
- niente logica duplicata tra handler
- database access sempre centralizzato tramite `Database::getInstance()`
- mai accedere al DB direttamente fuori dalla classe `Database`

---

# 🎨 Logica frontend

Regole:

- ogni pagina ha il proprio file JS dedicato
- le funzioni condivise vanno in `main.js`
- niente logica inline negli `onclick` HTML oltre alla chiamata alla funzione
- usare sempre `escapeHtml()` e `escapeAttr()` prima di inserire dati nel DOM

---

# 🧪 Error handling

Mai fare:

- echo di errori grezzi
- crash senza risposta JSON
- `console.log` lasciati nel codice in produzione

Sempre lato backend:

```json
{
  "status": "error",
  "message": "descrizione controllata"
}
```

Sempre lato frontend:

```js
try {
    const result = await apiRequest(method, url, payload)
    showResponse(result)
} catch (error) {
    handleFetchError(error)
}
```

---

# 🧼 Pulizia codice

- niente codice morto
- niente funzioni inutilizzate
- rimuovere debug prima del commit
- niente `var_dump`, `print_r`, `console.log` nel codice finale

---

# 📌 Commit rules

Formato:

```
type: descrizione
```

Tipi:

- feat
- fix
- refactor
- docs

---

# 🚫 Anti-pattern

- logica dentro HTML
- query SQL duplicate
- endpoint senza controllo input
- fetch senza gestione errori
- variabili con nomi generici (`$a`, `$x`, `data2`)
- handler che fanno più di una cosa
