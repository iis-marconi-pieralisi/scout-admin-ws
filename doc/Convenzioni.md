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

---

# 🧾 Naming semantico

## Regola fondamentale

👉 I nomi devono descrivere il comportamento, non l’implementazione

---

## PHP files

✔ corretto:
- `create_persona.php`
- `update_attivita.php`

❌ scorretto:
- `file1.php`
- `test.php`

---

## Variabili

Devono essere descrittive:

```php
$utenteAttivo
$idPersona
$listaPartecipanti
```

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

# ⚙️ Logica backend

Regole:

- ogni file deve avere UNA responsabilità
- niente logica duplicata tra handler
- database access sempre centralizzato

---

# 🧪 Error handling

Mai fare:

- echo di errori grezzi
- crash senza risposta JSON

Sempre:

```json
{
  "status": "error",
  "message": "descrizione controllata"
}
```

---

# 🧼 Pulizia codice

- niente codice morto
- niente funzioni inutilizzate
- rimuovere debug prima del commit

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