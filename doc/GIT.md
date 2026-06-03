# 🔀 Gestione Git nel progetto

Questo documento descrive il flusso di lavoro Git utilizzato nel progetto, con focus su collaborazione, conflitti e qualità del codice.

---

# 🧭 Filosofia del workflow

Il progetto utilizza un workflow collaborativo basato su:

- sviluppo parallelo su branch separati
- integrazione tramite Pull Request
- protezione del branch principale (`main`)

L'obiettivo è evitare modifiche dirette su `main` e garantire codice verificato.

---

# 🌿 Strategia branch

- `main` → versione stabile del progetto
- branch di lavoro → uno per ogni gruppo (es. `MM71`)
- merge solo tramite Pull Request

---

# ⚠️ Conflitti Git: cause reali

Un conflitto avviene quando:

- due sviluppatori modificano la stessa riga
- un file viene modificato in due branch diversi
- una merge avviene senza aggiornamento del branch

---

# 🧨 Tipi di conflitto

## 1. Merge conflict
Durante `git merge` o `git pull`

## 2. Rebase conflict
Durante riallineamento storico commit

---

# 🛠️ Risoluzione professionale

Quando appare un conflitto:

1. Identificare il file coinvolto
2. Analizzare le due versioni
3. NON scegliere automaticamente una delle due
4. Riscrivere la logica finale coerente

---

# 🧠 Regola importante

👉 Il codice finale NON deve essere "una delle due versioni", ma una versione corretta e unificata.

---

# 📦 Uso di stash (scenario reale)

Usato quando:

- devi aggiornare il branch ma hai lavoro incompleto

```bash
git stash
git pull
git stash pop
```

---

# 🚀 Pull Request

Le Pull Request servono a:

- revisionare codice
- evitare inserimenti diretti nel main
- discutere modifiche

---

# 📝 Messaggi di commit

Formato obbligatorio:

```
type: descrizione breve
```

Tipi:

- `feat` → nuova funzionalità
- `fix` → correzione bug
- `refactor` → riscrittura senza cambiare comportamento
- `docs` → solo documentazione

✔ corretto:
- `feat: aggiunto handler read_branca`
- `fix: corretto cast id_persona in iscrizione`

❌ scorretto:
- `modifica`
- `aggiornato roba`
- `wip`

---

# 🌿 Gestione branch del gruppo

Il branch del gruppo viene mantenuto attivo per tutto il progetto.

Per spostarsi sul branch:

```bash
git checkout MM71
```

Per crearlo se non esiste:

```bash
git checkout -b MM71
```

Per pushare:

```bash
git push origin MM71
```

---

# 🔁 Flusso completo consigliato

Prima di iniziare a lavorare:

```bash
git fetch
git stash
git pull
git stash pop
```

Dopo aver fatto le modifiche:

```bash
git add *
git commit -m "type: descrizione"
git push origin MM71
```

Poi aprire la Pull Request su GitHub.

---

# 📌 Best practice

- mai pushare codice non testato
- mai risolvere conflitti senza leggere il codice
- fare commit piccoli e logici
- un commit = una cosa sola
- non committare file di configurazione locali (già in `.gitignore`)
