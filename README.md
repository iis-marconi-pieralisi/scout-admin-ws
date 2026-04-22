# xampp

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

---

### 2. 📦 Metti da parte le tue modifiche
```bash
git stash
```
> Salva **temporaneamente** le tue modifiche locali in una zona di "parcheggio" 
> (lo stash), così puoi aggiornare il branch senza conflitti immediati.

---

### 3. ⬇️ Scarica l'ultima versione del branch
```bash
git pull
```
> Scarica e integra le modifiche più recenti dal repository remoto (GitHub)
> nel tuo Codespace locale.

---

### 4. 🔃 Ripristina le tue modifiche
```bash
git stash pop
```
> Recupera le modifiche messe da parte con `git stash` e le applica 
> sopra alla versione aggiornata del branch.

---

### 5. ⚠️ Risolvi eventuali conflitti (es. Merge Conflict)
> Se Git non riesce ad unire automaticamente le modifiche, segnalerà un
> **conflitto**. Dovrai aprire i file in conflitto e scegliere manualmente 
> quale versione del codice tenere (o combinarle).
> I conflitti si presentano così nei file:
> ```
> <<<<<<< HEAD
> // tuo codice
> =======
> // codice del branch remoto
> >>>>>>> nome-branch
> ```
> Una volta risolti tutti i conflitti, salva i file e prosegui.

---

### 6. 💾 Crea la commit con le tue modifiche
```bash
git commit -m "nome modifica"
```
> Registra ufficialmente le tue modifiche nella cronologia del repository,
> con un messaggio descrittivo che spiega cosa hai fatto.

---

### 7. 🚀 Carica le modifiche su GitHub
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
> Rimuove l'ultimo commit dalla cronologia, ma **mantiene tutte le modifiche**
> nei tuoi file locali, pronti per essere committati di nuovo.
> ⚠️ **Attenzione:** se si vuole rimuovere più commit, ripete il comando il numero di volte necessario
> 
> - `--soft` → mantiene le modifiche in staging (già pronte per la commit) ✅
> - `HEAD~1` → indica "torna indietro di 1 commit" 🔙
>
> ⚠️ **Attenzione:** se hai già fatto `git push`, dovrai usare `git push --force`
> per sovrascrivere il branch remoto. Fallo **solo** se sei sicuro e,
> in un progetto di gruppo, **avvisa sempre i tuoi compagni** prima! 🚨

---

## 👨‍👨‍👦‍👦 Composizione gruppi

- Admin: [🗿n1k06](https://github.com/N1k06/), [⛰️pental74](https://github.com/pental74)
- 404BrainNotFound: [💅TavianTorbian](https://github.com/TavianTorbian)​, [🏋🏻Thumad](https://github.com/Thumad)​
- 500FatalError: [Giulia431-creator](https://github.com/Giulia431-creator), [candolone](https://github.com/candolone)
- CompilaEPrega: [🧅st10951-cloud](https://github.com/st10951-cloud), ​​[🐰st10700-eng](https://github.com/st10700-eng), [🦊st10845-spec](https://github.com/st10845-spec)
- IPellari:[🙊LucaTons](https://github.com/LucaTons), [🕴st10936-dev](https://github.com/st10936-dev), [​👩🏿‍🦽‍➡️​ithrybr07](https://github.com/ithrybr07)
- MM71:[🐳st10769](https://github.com/st10769),[🐕ionnis07](https://github.com/ionnis07),[🐎st10964](https://github.com/st10964)
- Tantamelloni: [🐫BomboIone](https://github.com/BomboIone), [🐔Jack9x21](https://github.com/Jack9x21), [🐦‍⬛Manux17](https://github.com/Manux17)
- TheInvincibles: [🤴Leoprince07](https://github.com/Leoprince07/), [👑Nicogaldelli](https://github.com/Nicogaldelli/)