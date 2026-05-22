#!/bin/sh
set -e

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"
SCHEMA_FILE="$PROJECT_ROOT/src/api/db/schema.sql"
DATA_FILE="$PROJECT_ROOT/src/api/db/data.sql"

if command -v mysqladmin >/dev/null 2>&1; then
  READY_CMD='mysqladmin ping -h db -u root -proot --ssl=0 --silent'
elif command -v mysql >/dev/null 2>&1; then
  READY_CMD='mysql -h db -u root -proot --ssl=0 -e "SELECT 1" >/dev/null 2>&1'
else
  echo "mysqlclient o mysqladmin non trovato. Ricostruisci il devcontainer o installa il client MySQL/MariaDB."
  exit 1
fi

printf "Waiting for MariaDB to become available..."
MAX_ATTEMPTS=60
attempts=0
while ! sh -c "$READY_CMD"; do
  attempts=$((attempts + 1))
  if [ "$attempts" -ge "$MAX_ATTEMPTS" ]; then
    printf "\nMariaDB non è disponibile dopo $MAX_ATTEMPTS tentativi.\n"
    echo "Comando usato: $READY_CMD"
    exit 1
  fi
  printf "."
  sleep 2
done
printf "\nMariaDB is ready.\n"

if [ ! -f "$SCHEMA_FILE" ] || [ ! -f "$DATA_FILE" ]; then
  echo "File SQL mancanti: $SCHEMA_FILE o $DATA_FILE"
  exit 1
fi

printf "Esecuzione Drop e ricreazione Schema...\n"
mysql -h db -u root -proot --ssl=0 --default-character-set=utf8mb4 < "$SCHEMA_FILE"
printf "Schema caricato con successo.\n"

printf "Esecuzione Seeding dei dati...\n"
mysql -h db -u root -proot --ssl=0 --default-character-set=utf8mb4 < "$DATA_FILE"
printf "Database spianato e ripopolato con successo!\n"