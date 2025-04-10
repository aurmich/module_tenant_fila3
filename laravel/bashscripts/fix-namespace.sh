#!/bin/bash

# Colori per gli output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
RESET='\033[0m'

WORKSPACE="/var/www/html/saluteora/laravel"
MODULES_DIR="$WORKSPACE/Modules"
BACKUP_DIR="$WORKSPACE/namespace_backup_$(date +%Y%m%d_%H%M%S)"

echo -e "${BLUE}=== Script di Correzione dei Namespace nei Moduli Laraxot ===${RESET}"
echo -e "${YELLOW}Questo script correggerà i namespace non conformi nei moduli Laraxot${RESET}"
echo -e "${YELLOW}Backup dei file originali in: $BACKUP_DIR${RESET}"

# Crea directory di backup
mkdir -p "$BACKUP_DIR"

# Crea il file di log
LOG_FILE="$WORKSPACE/namespace_fix_$(date +%Y%m%d_%H%M%S).log"
touch "$LOG_FILE"

echo "===== Inizio correzione namespace: $(date) =====" > "$LOG_FILE"

# Funzione per elaborare un singolo modulo
process_module() {
    local module_name="$1"
    local module_dir="$MODULES_DIR/$module_name"
    local backup_module_dir="$BACKUP_DIR/$module_name"
    
    echo -e "${BLUE}Elaborazione modulo: $module_name${RESET}"
    echo "Elaborazione modulo: $module_name" >> "$LOG_FILE"
    
    # Crea backup del modulo
    mkdir -p "$backup_module_dir"
    cp -R "$module_dir"/* "$backup_module_dir"
    
    # Conta file PHP nel modulo
    local php_files_count=$(find "$module_dir" -type f -name "*.php" | wc -l)
    echo -e "${YELLOW}Trovati $php_files_count file PHP nel modulo $module_name${RESET}"
    
    # Cerca file con namespace Modules\ModuleName\App\
    local files_to_fix=$(grep -l "namespace Modules\\\\$module_name\\\\App\\\\" $(find "$module_dir" -type f -name "*.php"))
    local count_to_fix=$(echo "$files_to_fix" | grep -v "^$" | wc -l)
    
    echo -e "${YELLOW}Trovati $count_to_fix file da correggere nel modulo $module_name${RESET}"
    echo "Trovati $count_to_fix file da correggere nel modulo $module_name" >> "$LOG_FILE"
    
    if [ "$count_to_fix" -gt 0 ]; then
        echo "$files_to_fix" | while read -r file; do
            if [ -z "$file" ]; then
                continue
            fi
            
            # Backup del file originale nel log
            echo "--- File originale: $file ---" >> "$LOG_FILE"
            cat "$file" >> "$LOG_FILE"
            echo "" >> "$LOG_FILE"
            
            # Sostituisci namespace Modules\ModuleName\App\ con Modules\ModuleName\
            sed -i "s/namespace Modules\\\\$module_name\\\\App\\\\/namespace Modules\\\\$module_name\\\\/g" "$file"
            
            # Aggiorna anche use statement
            sed -i "s/use Modules\\\\$module_name\\\\App\\\\/use Modules\\\\$module_name\\\\/g" "$file"
            
            # Log del file modificato
            echo "--- File modificato: $file ---" >> "$LOG_FILE"
            cat "$file" >> "$LOG_FILE"
            echo "" >> "$LOG_FILE"
            
            echo -e "${GREEN}Corretto: $file${RESET}"
        done
    else
        echo -e "${GREEN}Nessun file da correggere nel modulo $module_name${RESET}"
    fi
    
    # Verifica errori residui
    local remaining_errors=$(grep -r "namespace Modules\\\\$module_name\\\\App\\\\" "$module_dir" --include="*.php" | wc -l)
    if [ "$remaining_errors" -gt 0 ]; then
        echo -e "${RED}Attenzione: $remaining_errors riferimenti a namespace errati rimasti nel modulo $module_name${RESET}"
        echo "Attenzione: $remaining_errors riferimenti a namespace errati rimasti nel modulo $module_name" >> "$LOG_FILE"
    else
        echo -e "${GREEN}Correzione namespace completata per il modulo $module_name${RESET}"
        echo "Correzione namespace completata per il modulo $module_name" >> "$LOG_FILE"
    fi
}

# Controlla se è stato specificato un modulo specifico
if [ -n "$1" ]; then
    if [ -d "$MODULES_DIR/$1" ]; then
        process_module "$1"
    else
        echo -e "${RED}Modulo $1 non trovato in $MODULES_DIR${RESET}"
        exit 1
    fi
else
    # Processa tutti i moduli
    for module_dir in "$MODULES_DIR"/*; do
        if [ -d "$module_dir" ]; then
            module_name=$(basename "$module_dir")
            process_module "$module_name"
        fi
    done
fi

echo -e "${BLUE}===== Analisi dei risultati =====${RESET}"
echo "===== Analisi dei risultati =====" >> "$LOG_FILE"

# Crea un file di analisi dei namespace
ANALYSIS_FILE="$WORKSPACE/namespace_analysis.txt"
echo "Analisi dei namespace nei moduli Laraxot" > "$ANALYSIS_FILE"
echo "Data: $(date)" >> "$ANALYSIS_FILE"
echo "" >> "$ANALYSIS_FILE"

find "$MODULES_DIR" -type f -name "*.php" | sort | while read -r file; do
    namespace=$(grep "^namespace" "$file" | head -1 | sed -e 's/namespace //' -e 's/;$//')
    class=$(grep "class " "$file" | head -1 | awk '{print $2}' | sed 's/{//')
    
    if [ -n "$namespace" ] && [ -n "$class" ]; then
        echo "File: $(echo "$file" | sed "s|$WORKSPACE/||")" >> "$ANALYSIS_FILE"
        echo "  Namespace attuale: $namespace" >> "$ANALYSIS_FILE"
        echo "  Classe: $class" >> "$ANALYSIS_FILE"
        echo "" >> "$ANALYSIS_FILE"
    fi
done

echo -e "${GREEN}Analisi dei namespace completata. Risultati salvati in: $ANALYSIS_FILE${RESET}"
echo "Analisi dei namespace completata. Risultati salvati in: $ANALYSIS_FILE" >> "$LOG_FILE"

echo -e "${BLUE}===== Pulizia autoloader =====${RESET}"
echo "===== Pulizia autoloader =====" >> "$LOG_FILE"

# In un ambiente reale, eseguiremmo questi comandi:
echo "Per applicare le modifiche, eseguire manualmente i seguenti comandi:"
echo -e "${YELLOW}cd $WORKSPACE${RESET}"
echo -e "${YELLOW}composer dump-autoload -o${RESET}"

echo "===== Fine correzione namespace: $(date) =====" >> "$LOG_FILE"

echo -e "${GREEN}Processo completato. Log salvato in: $LOG_FILE${RESET}"
echo -e "${YELLOW}Un backup dei file originali è stato creato in: $BACKUP_DIR${RESET}"
echo -e "${YELLOW}Si consiglia di testare l'applicazione prima di confermare le modifiche.${RESET}" 