#!/bin/bash

# Validate input
if [ $# -ne 2 ]; then
    echo "Usage: $0 <path> <remote_repo>"
    exit 1
fi

# Input parameters
LOCAL_PATH="$1"
REMOTE_REPO="$2"
REMOTE_BRANCH=$(git symbolic-ref --short HEAD 2>/dev/null || echo "main")
TEMP_BRANCH=$(basename "$LOCAL_PATH")-temp
# Simple error handling function
die() {
    echo "$1" >&2
    exit 1
}

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

# Sync subtree
pull_subtree() {
    find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;
    git add -A
    git commit -am "."
    git push -u origin "$REMOTE_BRANCH"
    
    git fetch "$REMOTE_REPO" "$REMOTE_BRANCH" --depth=1
    if(! git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH"  --squash)
    then
        if(! git subtree pull -P "$LOCAL_PATH" "$REMOTE_REPO" "$REMOTE_BRANCH")    
        then
            git fetch "$REMOTE_REPO" "$REMOTE_BRANCH" --depth=1
            git merge -s subtree FETCH_HEAD  --allow-unrelated-histories
        fi
    fi

    
    git rebase --rebase-merges --strategy subtree "$REMOTE_BRANCH"
    #git rebase --preserve-merges "$REMOTE_BRANCH" 
}

# Run sync
pull_subtree

echo "Subtree $LOCAL_PATH synchronized successfully with $REMOTE_REPO"