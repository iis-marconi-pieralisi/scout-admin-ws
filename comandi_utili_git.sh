## Comandi utili per git da copia incollare sul terminale al bisogno

# Effettuare un commit e push
git add *
git commit -m “<message>”
git push

# Effettuare un commit dopo che un altro autore ha fatto un push
git stash
git pull
git stash pop # potrebbe essere necessario risolvere conflitti
git add *
git commit -m “<message>”
git push

# Prima di iniziare a lavorare prendere le ultime modifiche
git fetch
git pull
