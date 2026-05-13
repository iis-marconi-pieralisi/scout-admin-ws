#!/bin/bash

OUTPUT_FINALE="report_completo_contributors.log"

# Rimuove il file se esiste già per evitare duplicati
rm -f "$OUTPUT_FINALE"

echo "Unificazione dei log in corso..."

# Trova tutti i file che iniziano per contrib_ e finiscono con .log
lista_file=$(ls contrib_*.log 2>/dev/null)

if [ -z "$lista_file" ]; then
    echo "Errore: nessun file 'contrib_*.log' trovato. Generali prima con l'altro script."
    exit 1
fi

# Crea l'intestazione del file globale
echo "========================================================================" >> "$OUTPUT_FINALE"
echo "REPORT AGGREGATO DI TUTTI I CONTRIBUTORI" >> "$OUTPUT_FINALE"
echo "DATA DI GENERAZIONE: $(date '+%Y-%m-%d %H:%M')" >> "$OUTPUT_FINALE"
echo "========================================================================" >> "$OUTPUT_FINALE"
echo -e "\n" >> "$OUTPUT_FINALE"

# Cicla sui file trovati e li appende
for file in $lista_file; do
    autore_formattato=$(echo "$file" | sed 's/^contrib_//;s/\.log$//;s/_/ /g')
    
    echo "Aggiungendo log di: $autore_formattato..."
    
    echo ">>>>>>>>>>>>>>>>>>>> INIZIO SEZIONE: $autore_formattato <<<<<<<<<<<<<<<<<<<<" >> "$OUTPUT_FINALE"
    cat "$file" >> "$OUTPUT_FINALE"
    echo -e "\n" >> "$OUTPUT_FINALE"
    echo ">>>>>>>>>>>>>>>>>>>> FINE SEZIONE: $autore_formattato <<<<<<<<<<<<<<<<<<<<<<" >> "$OUTPUT_FINALE"
    echo -e "\n\n" >> "$OUTPUT_FINALE"
done

echo "Processo completato! Il file unificato è: $OUTPUT_FINALE"
