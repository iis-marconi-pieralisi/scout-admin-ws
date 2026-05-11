#!/bin/bash

# Verifica se il file contributors.txt esiste
if [ ! -f contributors.txt ]; then
    echo "Errore: il file contributors.txt non è stato trovato."
    exit 1
fi

# Legge il file riga per riga
while IFS= read -r autore || [ -n "$autore" ]; do
    [[ -z "${autore// }" ]] && continue

    clean_name=$(echo "$autore" | xargs)
    filename_safe=$(echo "$clean_name" | tr ' ' '_')
    output_file="contrib_${filename_safe}.log"

    echo "Estrazione dati per: $clean_name..."

    # Ottiene la lista degli hash dei commit dell'autore
    commits=$(git log --all --author="$clean_name" --pretty=format:"%H")

    if [ -z "$commits" ]; then
        echo "  -> Nessun commit trovato per $clean_name. Salto."
        continue
    fi

    # 1. Crea il file e inserisce l'intestazione principale con il nome autore
    echo "########################################################################" > "$output_file"
    echo "LOG CONTRIBUTI PER AUTORE: $clean_name" >> "$output_file"
    echo "GENERATO IL: $(date '+%Y-%m-%d %H:%M')" >> "$output_file"
    echo "########################################################################" >> "$output_file"
    echo -e "\n" >> "$output_file"

    # Cicla su ogni commit
    echo "$commits" | while read -r commit_hash; do
        [ -z "$commit_hash" ] && continue

        # 2. Intestazione del singolo commit
        git log -1 --pretty=format:"[COMMIT %h] - %ad - %s" --date=short "$commit_hash" >> "$output_file"
        echo -e "\n------------------------------------------------------------------------" >> "$output_file"

        # 3. Codice prodotto (solo righe aggiunte, pulite dal simbolo +)
        git show "$commit_hash" --no-prefix | grep "^+" | grep -v "^+++" | sed 's/^+//' >> "$output_file"
        
        echo -e "\n" >> "$output_file"
    done

    echo "  -> Generato: $output_file"

done < contributors.txt

echo "Processo completato correttamente."
