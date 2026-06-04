# xampp
Indice:
[Codice](doc/Codice.md)
[Convenzioni](doc/Convenzioni.md)
[Git](doc/GIT.md)


## 🌐 Panoramica Environment Codespaces

Questo repository configura un ambiente di sviluppo completo in GitHub Codespaces con PHP 8.4, Apache, MariaDB e phpMyAdmin, ottimizzato per sviluppo web full-stack.

### ✅ Componenti principali

- `.devcontainer/`: configurazione per Codespaces con Docker Compose multi-servizio.
- `src/`: codice PHP dell'applicazione (document root del web server).

---

## 🧩 Aspetti chiave della configurazione
scout-admin-ws
### Ambiente containerizzato
- **PHP 8.4 + Apache**: immagine custom con estensioni essenziali (MySQL, PDO, ZIP) e Xdebug per debugging.
- **MariaDB 11.3**: database persistente con volume dedicato; credenziali preconfigurate (root/root, user/user).
- **phpMyAdmin**: interfaccia web per gestione database, accessibile su porta 8080.
- **Document root**: impostato su `src/` per isolare il codice applicativo.

### Integrazione VS Code
- Estensioni automatiche: PHP Debug (Xdebug) e Intelephense per intellisense avanzato.
- Porte forwardate: 3000 per l'app PHP, 8080 per phpMyAdmin.
- Sicurezza Git: directory marcata come sicura per evitare warning.

### Persistenza dati
- Volume MariaDB montato localmente in `.devcontainer/mariadb_data/` per mantenere dati tra riavvii.

---

## ▶️ Accesso ai servizi

- Applicazione PHP: `http://localhost:3000`
- phpMyAdmin: `http://localhost:8080`
- Database: host `db`, database `root_db`, utenti `root` o `user`

---

## 🛠️ Note di sviluppo

- Modifica il codice in `src/`; le modifiche sono riflesse immediatamente grazie al volume montato.
- Usa Composer per dipendenze PHP (già installato nel container).
- Per debugging, configura Xdebug nell'estensione VS Code PHP Debug.
- Il container PHP ha Apache con mod_rewrite abilitato per URL rewriting.

---

## 📌 Comandi utili

- Avvia manualmente: `docker compose -f .devcontainer/docker-compose.yml up --build`
- Arresta: `docker compose -f .devcontainer/docker-compose.yml down`
- Accesso container: `docker compose -f .devcontainer/docker-compose.yml exec php-app bash`

---

## 📁 Struttura del progetto

```
scout-admin-ws-MM71/
├── .devcontainer/
│   ├── Dockerfile
│   ├── devcontainer.json
│   ├── docker-compose.yml
│   └── init-db.sh
├── doc/
│   ├── Codice.md
│   ├── Convenzioni.md
│   └── GIT.md
├── src/
│   ├── api/
│   │   ├── db/
│   │   │   ├── schema.sql
│   │   │   └── data.sql
│   │   └── php/
│   │       ├── core/
│   │       │   ├── Database.php
│   │       │   ├── helpers.php
│   │       │   ├── index.php
│   │       │   └── router.php
│   │       ├── handlers/
│   │       └── routes.php
│   └── public/
│       ├── index.html
│       ├── account.html
│       ├── account.js
│       ├── branca.html
│       ├── iscrizione.html
│       ├── iscrizione.js
│       └── main.js
└── README.md
```

---

## 🗄️ Tabelle del database

| Tabella | Descrizione |
|---|---|
| `Account` | Credenziali di accesso, collegato a `Persona` |
| `Persona` | Anagrafica degli iscritti, con riferimento ai tutori |
| `Branca` | Fasce d'età (es. Lupetti, Esploratori...) |
| `Unita` | Unità scout, appartenenti a una Branca |
| `Iter` | Percorso formativo associato a una Branca |
| `Attivita` | Attività organizzate, con luogo e data |
| `Iscrizione` | Associazione Persona ↔ Unità per anno associativo |
| `Servizio` | Ruolo di una Persona in una Unità |
| `Tipologia` | Tipo di servizio (es. Capo, Membro...) |
| `Pagamento` | Pagamento legato a un'iscrizione |
| `Partecipa` | Relazione Attività ↔ Unità |

---

# 🔄 Procedura: Aggiornare il proprio Codespace e caricare le modifiche

Questa procedura va seguita quando si è **rimasti indietro** rispetto alla versione
del branch principale e si hanno delle modifiche locali da caricare.

---

## 📋 Passaggi

### 1. 🔍 Controlla lo stato attuale
```bash
git status
```
> Mostra lo stato del tuo repository locale rispetto al branch remoto:
> file modificati, aggiunte in staging, commit non ancora pushate, ecc.
> ⚠️ **Attenzione:** `git status` **non** mostra le nuove commit fatte da altri,
> per vederle è necessario eseguire prima `git fetch`!

---

### 2. 🌐 Controlla le nuove commit remote
```bash
git fetch
```
> Scarica le informazioni sulle ultime modifiche dal repository remoto,
> **senza applicarle** al tuo codice locale.
> Utile per vedere se qualche compagno ha pushato nuove commit sul branch
> prima di procedere con il proprio lavoro.

---

### 3. 📦 Metti da parte le tue modifiche
```bash
git stash
```
> Salva **temporaneamente** le tue modifiche locali in una zona di "parcheggio"
> (lo stash), così puoi aggiornare il branch senza conflitti immediati.

---

### 4. ⬇️ Scarica l'ultima versione del branch
```bash
git pull
```
> Scarica e integra le modifiche più recenti dal repository remoto (GitHub)
> nel tuo Codespace locale. A differenza di `git fetch`, applica subito
> le modifiche al tuo codice.

---

### 5. 🔃 Ripristina le tue modifiche
```bash
git stash pop
```
> Recupera le modifiche messe da parte con `git stash` e le applica
> sopra alla versione aggiornata del branch.

---

### 6. ⚠️ Risolvi eventuali conflitti (es. Merge Conflict)
> Se Git non riesce ad unire automaticamente le modifiche, segnalerà un
> **conflitto**. Su **VS Code / GitHub Codespaces** apparirà una notifica
> sui file in conflitto: aprili e clicca su **"Resolve in Merge Editor"** 🖊️
> Il Merge Editor mostrerà 3 pannelli:
> - **Incoming** → modifiche del branch remoto (del compagno) 
> - **Current** → tue modifiche locali
> - **Result** → risultato finale che puoi editare liberamente
>
> Accetta le modifiche che vuoi mantenere, poi salva e prosegui.
>
> <details>
> <summary>💡 Alternativa da terminale</summary>
>
> I conflitti si presentano così nei file:
> ```
> <<<<<<< HEAD
> // tuo codice
> =======
> // codice del branch remoto
> >>>>>>> nome-branch
> ```
> Modifica manualmente il file scegliendo quale codice tenere,
> poi salva e prosegui.
> </details>

---

### 7. ➕ Aggiungi i file modificati allo staging
```bash
git add *
```
> Aggiunge **tutti** i file modificati all'area di staging, ovvero li prepara
> per la commit successiva.
> ⚠️ **Attenzione:** `git add` è necessario solo se hai **nuovi file** non ancora
> tracciati da Git, o dopo aver risolto un conflitto. Se hai modificato solo
> file già tracciati e usato `git stash pop`, Git li gestisce automaticamente.

---

### 8. 💾 Crea la commit con le tue modifiche
```bash
git commit -m "nome modifica"
```
> Registra ufficialmente le tue modifiche nella cronologia del repository,
> con un messaggio descrittivo che spiega cosa hai fatto.

---

### 9. 🚀 Carica le modifiche su GitHub
```bash
git push
```
> Carica la tua commit sul repository remoto, rendendola disponibile
> a tutti i componenti del gruppo!

---

## 🗑️ Cancellare l'ultimo commit mantenendo le modifiche

```bash
git reset --soft HEAD~1
```
> Rimuove l'ultimo commit dalla cronologia, ma mantiene tutte le modifiche
> nei tuoi file locali, pronti per essere committati di nuovo.
> ⚠️ **Attenzione:** se si vuole rimuovere più commit, ripete il comando
> il numero di volte necessario.
---

## 🔀 Nomenclatura rotte e handlers

### Standard rotte API

Le rotte seguono il pattern `/api/<nome_tabella>` e ogni metodo HTTP corrisponde a un'operazione CRUD su una delle tabelle del DB (con nome al singolare).

| Rotta | Metodo HTTP | Operazione | File handler |
|---|---|---|---|
| `/api/branca` | `GET` | Lettura | `read_branca.php` |
| `/api/branca` | `POST` | Creazione | `create_branca.php` |
| `/api/branca` | `PUT` | Aggiornamento | `update_branca.php` |
| `/api/branca` | `DELETE` | Eliminazione | `delete_branca.php` |

### Regola di nomenclatura

```
<operazione_crud>_<nome_tabella>.php
```

I verbi CRUD utilizzati sono: `create`, `read`, `update`, `delete`.

**Esempi:**
- `create_branca.php`
- `read_partecipa.php`
- `update_utente.php`
- `delete_evento.php`

---
## 📁 Organizzazione degli handlers

Ogni handler è un file PHP dedicato collocato in `src/api/php/handlers/`.

```
src/
└── api/
    └── php/
        └── handlers/
            ├── account.php
            ├── attivita.php
            ├── authentication.php
            ├── branca.php
            ├── iscrizione.php
            ├── iter.php
            ├── pagamento.php
            ├── partecipa.php
            ├── persona.php
            ├── registrazione.php
            ├── servizio.php
            ├── tipologia.php
            └── unita.php
```
## 🔀 Pull Request

> Una Pull Request è come consegnare un lavoro al professore per la revisione:
> carichi le tue modifiche su un branch separato e chiedi al responsabile
> del progetto di approvarle prima che vengano unite al `main`.
> In questo contesto didattico, utilizziamo un branch dedicato per ogni gruppo,
> che viene mantenuto attivo per tutto il progetto e non viene eliminato dopo il merge.

### ⌨️ Comandi

#### 1. 🌿 Crea e/o spostati sul branch del gruppo (se non esiste già)
```bash
git checkout -b nome-del-tuo-gruppo
```
> Es: `git checkout -b admin`

---

#### 2. 💾 Aggiungi e committa le modifiche
```bash
git add *
git commit -m "descrizione modifica"
```

---

#### 3. 🚀 Carica il branch su GitHub
```bash
git push origin nome-del-tuo-gruppo
```
> Es: `git push origin admin`

---

#### 4. 🖥️ Apri la Pull Request su GitHub
> Vai su GitHub, clicca il banner **"Compare & pull request"**,
> aggiungi una descrizione e conferma con **"Create pull request"**.
> A questo punto il professore (o il responsabile) potrà revisionare
> e approvare le modifiche cliccando **"Merge pull request"**.

---

#### 5. ✅ Dopo l'approvazione, torna sul main e aggiornati
```bash
git checkout main
git pull
```
---

> **Nota:** A differenza del workflow standard, i branch dei gruppi vengono mantenuti attivi
> per permettere aggiornamenti continui e facilitare la logistica didattica.

---


## 👨‍👨‍👦‍👦 Composizione gruppi

- Admin: [🗿n1k06](https://github.com/N1k06/), [⛰️pental74](https://github.com/pental74)
- 404BrainNotFound: [💅TavianTorbian](https://github.com/TavianTorbian)​, [🏋🏻Thumad](https://github.com/Thumad)​
- 500FatalError: [👮🏼‍♀️Giulia431-creator](https://github.com/Giulia431-creator), [👨🏼‍🍳candolone](https://github.com/candolone)
- CompilaEPrega: [🧅st10951-cloud](https://github.com/st10951-cloud), ​​[🐰st10700-eng](https://github.com/st10700-eng), [🦊st10845-spec](https://github.com/st10845-spec)
- IPellari:[🙊LucaTons](https://github.com/LucaTons), [🕴st10936-dev](https://github.com/st10936-dev), [​👩🏿‍🦽‍➡️​ithrybr07](https://github.com/ithrybr07)
- MM71:[🐳st10769](https://github.com/st10769),[🐕ionnis07](https://github.com/ionnis07),[🐎st10964](https://github.com/st10964)
- Tantamelloni: [🐫BomboIone](https://github.com/BomboIone), [🐔Jack9x21](https://github.com/Jack9x21), [🐦‍⬛Manux17](https://github.com/Manux17)
- TheInvincibles: [🤴Leoprince07](https://github.com/Leoprince07/), [👑Nicogaldelli](https://github.com/Nicogaldelli/)
