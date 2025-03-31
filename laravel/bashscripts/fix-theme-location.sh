#!/bin/bash

# Colori per gli output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
RESET='\033[0m'

WORKSPACE="/var/www/html/saluteora/laravel"
SOURCE_DIR="$WORKSPACE/Modules/ThemeOne"
TARGET_DIR="$WORKSPACE/Themes/One"
BACKUP_DIR="$WORKSPACE/theme_backup_$(date +%Y%m%d_%H%M%S)"

echo -e "${BLUE}=== Script di Correzione del Posizionamento del Tema ===${RESET}"
echo -e "${YELLOW}Questo script sposterà il tema dalla directory errata alla directory corretta${RESET}"
echo -e "${YELLOW}Backup del tema originale in: $BACKUP_DIR${RESET}"

# Crea directory di backup
mkdir -p "$BACKUP_DIR"

# Crea il file di log
LOG_FILE="$WORKSPACE/theme_fix_$(date +%Y%m%d_%H%M%S).log"
touch "$LOG_FILE"

echo "===== Inizio correzione posizionamento tema: $(date) =====" > "$LOG_FILE"

# Verifica se la directory sorgente esiste
if [ ! -d "$SOURCE_DIR" ]; then
    echo -e "${RED}ERRORE: La directory sorgente $SOURCE_DIR non esiste.${RESET}"
    echo "ERRORE: La directory sorgente $SOURCE_DIR non esiste." >> "$LOG_FILE"
    exit 1
fi

# Crea la directory target se non esiste
mkdir -p "$(dirname "$TARGET_DIR")"

# Backup del tema originale
echo -e "${BLUE}Creazione backup del tema originale...${RESET}"
cp -R "$SOURCE_DIR" "$BACKUP_DIR/ThemeOne"
echo "Backup del tema creato in $BACKUP_DIR/ThemeOne" >> "$LOG_FILE"

# Conteggio dei file PHP da aggiornare
PHP_FILES=$(find "$SOURCE_DIR" -type f -name "*.php" | wc -l)
echo -e "${YELLOW}Trovati $PHP_FILES file PHP nel tema${RESET}"
echo "Trovati $PHP_FILES file PHP nel tema" >> "$LOG_FILE"

# Conteggio dei file con namespace da aggiornare
NAMESPACE_FILES=$(grep -r "namespace Modules\\\\ThemeOne" "$SOURCE_DIR" --include="*.php" | wc -l)
echo -e "${YELLOW}Trovati $NAMESPACE_FILES file con namespace da aggiornare${RESET}"
echo "Trovati $NAMESPACE_FILES file con namespace da aggiornare" >> "$LOG_FILE"

# Aggiornamento dei namespace nei file PHP
echo -e "${BLUE}Aggiornamento dei namespace nei file PHP...${RESET}"
find "$SOURCE_DIR" -type f -name "*.php" | while read -r file; do
    # Backup del file originale nel log
    echo "--- File originale: $file ---" >> "$LOG_FILE"
    cat "$file" >> "$LOG_FILE"
    echo "" >> "$LOG_FILE"
    
    # Modifica del namespace
    sed -i 's/namespace Modules\\ThemeOne/namespace Themes\\One/g' "$file"
    
    # Modifica degli use statement
    sed -i 's/use Modules\\ThemeOne/use Themes\\One/g' "$file"
    
    # Log del file modificato
    echo "--- File modificato: $file ---" >> "$LOG_FILE"
    cat "$file" >> "$LOG_FILE"
    echo "" >> "$LOG_FILE"
done

# Aggiornamento dei riferimenti al tema in altri file del progetto
echo -e "${BLUE}Ricerca di riferimenti al tema in altri file del progetto...${RESET}"
REFERENCES=$(grep -r "Modules\\\\ThemeOne" "$WORKSPACE" --include="*.php" --exclude-dir="$SOURCE_DIR" | wc -l)
echo -e "${YELLOW}Trovati $REFERENCES riferimenti al tema in altri file${RESET}"
echo "Trovati $REFERENCES riferimenti al tema in altri file" >> "$LOG_FILE"

# Elenca i file che contengono riferimenti al tema
grep -r "Modules\\\\ThemeOne" "$WORKSPACE" --include="*.php" --exclude-dir="$SOURCE_DIR" -l > "$WORKSPACE/theme_references.txt"
echo "Lista dei file con riferimenti al tema salvata in $WORKSPACE/theme_references.txt" >> "$LOG_FILE"

# Avvisa l'utente sui file che potrebbero dover essere aggiornati manualmente
if [ "$REFERENCES" -gt 0 ]; then
    echo -e "${YELLOW}ATTENZIONE: Alcuni file contengono riferimenti al vecchio namespace del tema.${RESET}"
    echo -e "${YELLOW}Questi riferimenti dovranno essere aggiornati manualmente.${RESET}"
    echo -e "${YELLOW}La lista dei file è disponibile in $WORKSPACE/theme_references.txt${RESET}"
fi

# Spostamento del tema nella posizione corretta
echo -e "${BLUE}Spostamento del tema nella posizione corretta...${RESET}"
if [ -d "$TARGET_DIR" ]; then
    echo -e "${RED}ATTENZIONE: La directory target $TARGET_DIR esiste già.${RESET}"
    echo -e "${RED}Lo script non sovrascriverà automaticamente la directory esistente.${RESET}"
    echo "ATTENZIONE: La directory target $TARGET_DIR esiste già." >> "$LOG_FILE"
    echo "Lo script non sovrascriverà automaticamente la directory esistente." >> "$LOG_FILE"
    
    read -p "Vuoi sovrascrivere la directory esistente? (s/n): " overwrite
    if [ "$overwrite" = "s" ]; then
        rm -rf "$TARGET_DIR"
        mv "$SOURCE_DIR" "$TARGET_DIR"
        echo -e "${GREEN}Tema spostato con successo in $TARGET_DIR${RESET}"
        echo "Tema spostato con successo in $TARGET_DIR" >> "$LOG_FILE"
    else
        echo -e "${YELLOW}Operazione annullata. Il tema non è stato spostato.${RESET}"
        echo "Operazione annullata. Il tema non è stato spostato." >> "$LOG_FILE"
        exit 0
    fi
else
    mv "$SOURCE_DIR" "$TARGET_DIR"
    echo -e "${GREEN}Tema spostato con successo in $TARGET_DIR${RESET}"
    echo "Tema spostato con successo in $TARGET_DIR" >> "$LOG_FILE"
fi

# Verifica delle modifiche nel composer.json per gestire il tema
echo -e "${BLUE}Verificando se ci sono modifiche necessarie in composer.json...${RESET}"
if grep -q "\"Modules\\\\\\\\ThemeOne\\\\\\\\\"" "$WORKSPACE/composer.json"; then
    echo -e "${YELLOW}ATTENZIONE: composer.json contiene riferimenti a Modules\\ThemeOne.${RESET}"
    echo -e "${YELLOW}Si consiglia di aggiornare il file composer.json manualmente.${RESET}"
    echo "ATTENZIONE: composer.json contiene riferimenti a Modules\\ThemeOne." >> "$LOG_FILE"
    echo "Si consiglia di aggiornare il file composer.json manualmente." >> "$LOG_FILE"
fi

# Suggerimento per i service provider
echo -e "${BLUE}Verifica del service provider del tema...${RESET}"
if grep -q "Modules\\\\ThemeOne\\\\Providers" "$WORKSPACE/config/app.php"; then
    echo -e "${YELLOW}ATTENZIONE: Trovato service provider del tema in config/app.php.${RESET}"
    echo -e "${YELLOW}Si consiglia di aggiornarlo da 'Modules\\ThemeOne\\Providers\\...' a 'Themes\\One\\Providers\\...'${RESET}"
    echo "ATTENZIONE: Trovato service provider del tema in config/app.php." >> "$LOG_FILE"
    echo "Si consiglia di aggiornarlo da 'Modules\\ThemeOne\\Providers\\...' a 'Themes\\One\\Providers\\...'" >> "$LOG_FILE"
fi

# Rigenerazione dell'autoloader
echo -e "${BLUE}Rigenerazione dell'autoloader...${RESET}"
if cd "$WORKSPACE" && composer dump-autoload -o; then
    echo -e "${GREEN}Autoloader rigenerato con successo.${RESET}"
    echo "Autoloader rigenerato con successo." >> "$LOG_FILE"
else
    echo -e "${RED}ERRORE: Impossibile rigenerare l'autoloader.${RESET}"
    echo "ERRORE: Impossibile rigenerare l'autoloader." >> "$LOG_FILE"
fi

echo "===== Fine correzione posizionamento tema: $(date) =====" >> "$LOG_FILE"

echo -e "${GREEN}Processo completato. Log salvato in: $LOG_FILE${RESET}"
echo -e "${YELLOW}Un backup del tema originale è stato creato in: $BACKUP_DIR/ThemeOne${RESET}"
echo -e "${YELLOW}Si consiglia di testare l'applicazione prima di confermare le modifiche.${RESET}"

# Riassunto delle operazioni eseguite
echo -e "${BLUE}===== Riassunto delle operazioni eseguite =====${RESET}"
echo -e "1. Backup del tema creato in: ${GREEN}$BACKUP_DIR/ThemeOne${RESET}"
echo -e "2. Aggiornati namespace in ${GREEN}$PHP_FILES${RESET} file PHP"
echo -e "3. Trovati ${YELLOW}$REFERENCES${RESET} riferimenti al tema in altri file (vedi $WORKSPACE/theme_references.txt)"
echo -e "4. Tema spostato in: ${GREEN}$TARGET_DIR${RESET}"
echo -e "5. Autoloader rigenerato"
echo -e "${BLUE}===== Operazioni manuali necessarie =====${RESET}"
echo -e "1. Verifica i riferimenti al tema in altri file elencati in $WORKSPACE/theme_references.txt"
echo -e "2. Aggiorna i service provider in config/app.php"
echo -e "3. Aggiorna il file composer.json se necessario" 