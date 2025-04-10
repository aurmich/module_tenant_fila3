#!/bin/bash

# Controlla se è stato fornito un file di input
if [ $# -ne 1 ]; then
    echo "Utilizzo: $0 <file_input>"
    exit 1
fi

me=$( readlink -f -- "$0")

INPUT_FILE="$1"
# Controlla se il file esiste
if [ ! -f "$INPUT_FILE" ]; then
    echo "Errore: Il file $INPUT_FILE non esiste"
    exit 1
fi

# Inizializza l'array associativo per tutti i sottmoduli
declare -A submodules_array
index=0
while IFS= read -r line; do
    # Salta righe vuote e commenti
    [[ -z "$line" || "$line" =~ ^[[:space:]]*# ]] && continue
    
    # Rimuovi spazi e CR
    line=$(echo "$line" | tr -d '\r' | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')
    
    # Estrai i valori path e url
    if [[ "$line" =~ ^path\ *=\ *(.+)$ ]]; then
        current_path="${BASH_REMATCH[1]}"
    elif [[ "$line" =~ ^url\ *=\ *(.+)$ && -n "$current_path" ]]; then
        current_url="${BASH_REMATCH[1]}"
        
        # Chiamata esterna allo script di sincronizzazione
<<<<<<< HEAD
        submodules_array.push(['path' => "$current_path", 'url' => "$current_url"]);
=======
        submodules_array[$index]['path']=$current_path
        submodules_array[$index]['path']=$current_path
        ((index++))
>>>>>>> af282639 (.)
        
        # Pulizia: reset delle variabili per il prossimo modulo
        current_path=""
        current_url=""
    fi
done < "$INPUT_FILE"
