#!/bin/bash


source ./bashscripts/lib/custom.sh
# Includi lo script di parsing
source ./bashscripts/lib/parse_gitmodules_ini.sh

# Chiama la funzione
parse_gitmodules gitmodules.ini

me=$( readlink -f -- "$0")
script_dir=$(dirname "$me")

total=${submodules_array["total"]}
for ((i=0; i<total; i++)); do
    path=${submodules_array["path_${i}"]}
    url=${submodules_array["url_${i}"]}
    echo "---------"
    echo "Submodule $i:"
    echo "  📁 Path: $path"
    echo "  🌐 URL: $url"
    script="$script_dir/git_pull_subtree.sh"
    chmod +x "$script"
    sed -i -e 's/\r$//' "$script"
    
    # Chiamata esterna allo script di sincronizzazione
    log "🔄 Pull modulo: $path"
    if ! "$script" "$path" "$url" ; then
        log "⚠️ Pull fallita per $path."
    fi
done
<<<<<<< HEAD:git_pull_subtrees.sh
=======
me=$( readlink -f -- "$0")
script_dir=$(dirname "$me")

# Script per sincronizzare git subtree con ottimizzazione della history
CONFIG_FILE="gitmodules.ini"
DEPTH=1  # Limita la profondità della history scaricata
LOG_FILE="subtree_sync.log"

# Funzione per loggare messaggi
log() {
    local message="$1"
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $message" | tee -a "$LOG_FILE"
}

# Funzione per gestire gli errori
handle_error() {
    local error_message="$1"
    log "❌ Errore: $error_message"
    exit 1
}

# Verifica che il file di configurazione esista
if [[ ! -f $CONFIG_FILE ]]; then
    handle_error "File $CONFIG_FILE non trovato!"
fi

# Ottieni il branch corrente
current_branch=$(git symbolic-ref --short HEAD 2>/dev/null || echo "main")
log "🌿 Branch corrente: $current_branch"

# Processa le righe del file di configurazione
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
        script="$script_dir/git_pull_subtree.sh"
        chmod +x "$script"
        sed -i -e 's/\r$//' "$script"
        
        # Chiamata esterna allo script di sincronizzazione
        log "🔄 Sincronizzazione modulo: $current_path"
        if ! "$script" "$current_path" "$current_url" ; then
            log "⚠️ Sincronizzazione fallita per $current_path."
        fi
        
        # Pulizia: reset delle variabili per il prossimo modulo
        current_path=""
        current_url=""
    fi
done < "$CONFIG_FILE"

# Esegui git gc per mantenere il repository leggero
log "🧹 Pulizia del repository..."
git gc --prune=now --aggressive

log "✅ Sincronizzazione completata con history ottimizzata!"
>>>>>>> b1ca4c93 (Squashed 'bashscripts/' changes from c21599d..019cc70)
=======
>>>>>>> 23b8d6b6 (.):bashscripts/git_pull_subtrees.sh
