#!/bin/bash

LOG_FILE="subtree_sync.log"

# Funzione per loggare messaggi
log() {
    local message="$1"
    echo "📆 $(date '+%Y-%m-%d %H:%M:%S') - $message" | tee -a "$LOG_FILE"
}

# Funzione per gestire gli errori
handle_error() {
    local error_message="$1"
    log "❌ Errore: $error_message"
    exit 1
}