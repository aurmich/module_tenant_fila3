#!/bin/bash

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

# Funzione per sincronizzare un modulo
sync_module() {
    local path="$1"
    local url="$2"
    
    log "----------------------------------------"
    log "📂 Path: $path"
    log "🔗 URL: $url"
    log "🌿 Branch: $current_branch"
    
    # Fetch con history limitata
    log "📥 Fetch con history ridotta (depth=$DEPTH)..."
    if ! git fetch --depth=$DEPTH "$url" "$current_branch"; then
        log "⚠️ Fetch fallito per $url."
        return 1
    fi
    
    # Se la cartella esiste, aggiorna il subtree
    if [[ -d "$path" ]]; then
        log "🔄 Aggiornamento subtree esistente..."
        
        # Pull con --squash per aggiornare il subtree
        if git subtree pull --prefix="$path" "$url" "$current_branch" --squash -m "Sync subtree $path"; then
            log "✅ Pull completato per $path."
        else
            log "⚠️ Pull fallito per $path a causa di conflitti. Tentativo di risoluzione..."
            git rm -r --cached "$path"
            git commit -am "Remove $path per risolvere conflitti" || true
            if git subtree add --prefix="$path" "$url" "$current_branch" --squash -m "Re-add subtree $path"; then
                log "✅ Subtree riaggiunto dopo la risoluzione dei conflitti."
            else
                log "❌ Impossibile riaggiungere il subtree $path."
                return 1
            fi
        fi
    else
        log "➕ Aggiunta nuovo subtree con history minima..."
        if git subtree add --prefix="$path" "$url" "$current_branch" --squash -m "Add subtree $path"; then
            log "✅ Subtree aggiunto per $path."
        else
            log "❌ Impossibile aggiungere il subtree $path."
            return 1
        fi
    fi
    
    # Crea un branch temporaneo per pushare solo il commit attuale (history minima)
    local split_branch="split-${path//\//-}"
    log "🌳 Creazione branch temporaneo: $split_branch"
    if git subtree split --prefix="$path" -b "$split_branch"; then
        log "✅ Branch temporaneo creato: $split_branch"
        
        # Push del branch temporaneo al repository remoto
        if git push "$url" "$split_branch:$current_branch"; then
            log "✅ Push completato per $path."
            git branch -d "$split_branch"
        else
            log "⚠️ Push fallito per $path. Tentativo di merge con il branch remoto..."
            git fetch "$url" "$current_branch"
            git checkout "$split_branch"
            git merge --no-ff "remotes/$url/$current_branch" -m "Merge con il branch remoto"
            if git push "$url" "$split_branch:$current_branch"; then
                log "✅ Push completato dopo il merge."
                git branch -d "$split_branch"
            else
                log "❌ Impossibile completare il push. Controlla i permessi o il branch remoto."
                return 1
            fi
        fi
    else
        log "⚠️ Split fallito per $path, il push non sarà effettuato."
        return 1
    fi
    
    return 0
}

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
        
        # Sincronizza il modulo
        if ! sync_module "$current_path" "$current_url"; then
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
