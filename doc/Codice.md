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

* connessione database
* funzioni comuni
* gestione base routing

---

## 🗄️ Database layer

Il database viene gestito tramite un layer centralizzato.

Caratteristiche:

* connessione unica
* riutilizzo query
* gestione errori uniforme

---

## 📡 API structure

Ogni endpoint rappresenta una risorsa.

Esempio logico:

* `/api/persona`
* `/api/branca`

Ogni endpoint supporta operazioni CRUD.

---

## 🔁 Handler system

Ogni handler:

* riceve input HTTP
* valida dati
* esegue query
* restituisce JSON

Non deve contenere logica di routing.

---

## 📤 Response system

Tutte le risposte seguono uno standard unico:

```json
{
  "status": "success",
  "data": {}
}
```

---

## ⚠️ Error handling

Errori gestiti sempre lato backend:

* input non valido
* query fallite
* risorse non trovate

---

## 🌍 Apache & rewrite

Il sistema usa `mod_rewrite` per:

* rimuovere `index.php` dall’URL
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

//sezione in progresso 