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

PER COMMITTARE IN CASO DI PRIMA COMMIT
git add *
git commit -m “ “
git push


PER COMMITTARE IN CASO DI ALTRA COMMIT
git stash
git pull
git stash pop
git add *
git commit -m “ “
git push


PRIMA DI INIZIARE A LAVORARE BISOGNA SEMPRE FARE
git pull


---
```
  ROTTA      METODO HTTP    NOME HANDLER(php)
/api/branche --> Post    --> create-branche  
             --> Get     --> read-branche
             --> Delete  --> delete-branche
             --> Pot     --> update-branche 
Nome Handler<verbo_crud>_<nome_tabella>.php
```
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
