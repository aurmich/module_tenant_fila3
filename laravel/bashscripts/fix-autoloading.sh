#!/bin/bash

# Colori per gli output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
RESET='\033[0m'

WORKSPACE="/var/www/html/saluteora/laravel"
COMPOSER_FILE="$WORKSPACE/composer.json"
BACKUP_DIR="$WORKSPACE/composer_backup_$(date +%Y%m%d_%H%M%S)"
BACKUP_FILE="$BACKUP_DIR/composer.json"

echo -e "${BLUE}=== Script di Correzione dei Problemi di Autoloading in composer.json ===${RESET}"
echo -e "${YELLOW}Questo script correggerà la configurazione di autoloading in composer.json${RESET}"
echo -e "${YELLOW}Backup del file originale in: $BACKUP_FILE${RESET}"

# Crea directory di backup
mkdir -p "$BACKUP_DIR"

# Crea il file di log
LOG_FILE="$WORKSPACE/composer_fix_$(date +%Y%m%d_%H%M%S).log"
touch "$LOG_FILE"

echo "===== Inizio correzione composer.json: $(date) =====" > "$LOG_FILE"

# Backup del file originale
cp "$COMPOSER_FILE" "$BACKUP_FILE"
echo "File composer.json originale copiato in $BACKUP_FILE" >> "$LOG_FILE"
cat "$COMPOSER_FILE" >> "$LOG_FILE"

# Funzione per verificare se un JSON è valido
validate_json() {
    local file="$1"
    if jq empty "$file" 2>/dev/null; then
        return 0
    else
        return 1
    fi
}

echo -e "${BLUE}Verificando il file composer.json originale...${RESET}"
if validate_json "$COMPOSER_FILE"; then
    echo -e "${GREEN}Il file composer.json originale è valido.${RESET}"
    echo "Il file composer.json originale è valido." >> "$LOG_FILE"
else
    echo -e "${RED}ERRORE: Il file composer.json originale non è valido. Impossibile procedere.${RESET}"
    echo "ERRORE: Il file composer.json originale non è valido. Impossibile procedere." >> "$LOG_FILE"
    exit 1
fi

# Verifica se il file contiene la configurazione problematica
echo -e "${BLUE}Verificando la presenza della configurazione problematica...${RESET}"
if grep -q '"Modules\\\\"' "$COMPOSER_FILE"; then
    echo -e "${YELLOW}Trovata configurazione problematica: \"Modules\\\\\": \"Modules/\"${RESET}"
    echo "Trovata configurazione problematica: \"Modules\\\\\": \"Modules/\"" >> "$LOG_FILE"

    # Creare un file temporaneo per la modifica
    TMP_FILE=$(mktemp)
    
    # Utilizzare jq per manipolare il JSON in modo sicuro
    jq '.autoload["psr-4"] |= with_entries(select(.key != "Modules\\\\"))' "$COMPOSER_FILE" > "$TMP_FILE"
    
    if validate_json "$TMP_FILE"; then
        mv "$TMP_FILE" "$COMPOSER_FILE"
        echo -e "${GREEN}Rimossa configurazione problematica da composer.json${RESET}"
        echo "Rimossa configurazione problematica da composer.json" >> "$LOG_FILE"
    else
        echo -e "${RED}ERRORE: La modifica ha prodotto un JSON non valido. Ripristino il file originale.${RESET}"
        echo "ERRORE: La modifica ha prodotto un JSON non valido. Ripristino il file originale." >> "$LOG_FILE"
        cp "$BACKUP_FILE" "$COMPOSER_FILE"
        rm "$TMP_FILE"
        exit 1
    fi
else
    echo -e "${GREEN}Nessuna configurazione problematica trovata.${RESET}"
    echo "Nessuna configurazione problematica trovata." >> "$LOG_FILE"
fi

# Verifica se minimum-stability è impostato correttamente
echo -e "${BLUE}Verificando la configurazione di minimum-stability...${RESET}"
STABILITY=$(jq -r '.["minimum-stability"]' "$COMPOSER_FILE")

if [[ "$STABILITY" != "dev" ]]; then
    echo -e "${YELLOW}minimum-stability è impostato a \"$STABILITY\". Modificando in \"dev\"...${RESET}"
    echo "minimum-stability è impostato a \"$STABILITY\". Modificando in \"dev\"..." >> "$LOG_FILE"
    
    # Creare un file temporaneo per la modifica
    TMP_FILE=$(mktemp)
    
    # Utilizzare jq per modificare minimum-stability
    jq '.["minimum-stability"] = "dev"' "$COMPOSER_FILE" > "$TMP_FILE"
    
    if validate_json "$TMP_FILE"; then
        mv "$TMP_FILE" "$COMPOSER_FILE"
        echo -e "${GREEN}minimum-stability modificato in \"dev\"${RESET}"
        echo "minimum-stability modificato in \"dev\"" >> "$LOG_FILE"
    else
        echo -e "${RED}ERRORE: La modifica ha prodotto un JSON non valido. Ripristino il file originale.${RESET}"
        echo "ERRORE: La modifica ha prodotto un JSON non valido. Ripristino il file originale." >> "$LOG_FILE"
        cp "$BACKUP_FILE" "$COMPOSER_FILE"
        rm "$TMP_FILE"
        exit 1
    fi
else
    echo -e "${GREEN}minimum-stability è già impostato correttamente a \"dev\".${RESET}"
    echo "minimum-stability è già impostato correttamente a \"dev\"." >> "$LOG_FILE"
fi

# Verifica le dipendenze di Filament (se necessario)
echo -e "${BLUE}Verificando le dipendenze di Filament...${RESET}"
if ! jq -e '.require["filament/filament"]' "$COMPOSER_FILE" >/dev/null 2>&1; then
    echo -e "${YELLOW}Filament non è presente nelle dipendenze. Considerare di aggiungerlo manualmente:${RESET}"
    echo -e "${YELLOW}composer require filament/filament:^3.1 filament/forms:^3.1 filament/tables:^3.1${RESET}"
    echo "Filament non è presente nelle dipendenze. Considerare di aggiungerlo manualmente." >> "$LOG_FILE"
fi

# Salva il file composer.json modificato nel log
echo "===== File composer.json modificato =====" >> "$LOG_FILE"
cat "$COMPOSER_FILE" >> "$LOG_FILE"

echo -e "${BLUE}===== Rigenerazione dell'autoloader =====${RESET}"
echo "===== Rigenerazione dell'autoloader =====" >> "$LOG_FILE"

# Esegui composer dump-autoload
if cd "$WORKSPACE" && composer dump-autoload -o; then
    echo -e "${GREEN}Autoloader rigenerato con successo.${RESET}"
    echo "Autoloader rigenerato con successo." >> "$LOG_FILE"
else
    echo -e "${RED}ERRORE: Impossibile rigenerare l'autoloader.${RESET}"
    echo "ERRORE: Impossibile rigenerare l'autoloader." >> "$LOG_FILE"
fi

echo "===== Fine correzione composer.json: $(date) =====" >> "$LOG_FILE"

echo -e "${GREEN}Processo completato. Log salvato in: $LOG_FILE${RESET}"
echo -e "${YELLOW}Un backup del file originale è stato creato in: $BACKUP_FILE${RESET}"
echo -e "${YELLOW}Si consiglia di testare l'applicazione prima di confermare le modifiche.${RESET}"

echo -e "${BLUE}===== Riepilogo delle modifiche =====${RESET}"
diff -u "$BACKUP_FILE" "$COMPOSER_FILE" | grep -E "^(\+|\-)" | grep -v "@@" | tail -n +3 