#!/bin/bash

# Script per eseguire PHPStan incrementalmente sui moduli di SaluteOra
# Aumenta gradualmente il livello di analisi e corregge gli errori trovati

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Livello iniziale
CURRENT_LEVEL=1
MAX_LEVEL=9

# Creare la directory per i log
mkdir -p logs/phpstan

echo -e "${BLUE}Analisi incrementale PHPStan per SaluteOra${NC}"

while [ $CURRENT_LEVEL -le $MAX_LEVEL ]; do
    echo -e "${YELLOW}Avvio analisi PHPStan livello $CURRENT_LEVEL${NC}"
    
    # Aggiornare il livello nel file di configurazione
    sed -i "s/level: [0-9]/level: $CURRENT_LEVEL/g" phpstan.neon
    
    # Eseguire PHPStan e salvare l'output in un file
    LOG_FILE="logs/phpstan/level_${CURRENT_LEVEL}.log"
    ./vendor/bin/phpstan analyse --configuration=phpstan.neon > $LOG_FILE 2>&1
    
    # Verificare il risultato
    if grep -q "\[ERROR\]" $LOG_FILE; then
        ERROR_COUNT=$(grep "\[ERROR\]" $LOG_FILE | grep -oE "[0-9]+ errors" | grep -oE "[0-9]+")
        echo -e "${RED}Trovati $ERROR_COUNT errori al livello $CURRENT_LEVEL${NC}"
        echo -e "${YELLOW}Controlla il file $LOG_FILE per i dettagli${NC}"
        
        # Generare un file baseline per questo livello
        echo -e "${BLUE}Generazione baseline per livello $CURRENT_LEVEL${NC}"
        ./vendor/bin/phpstan analyse --configuration=phpstan.neon --generate-baseline=phpstan-baseline-level-$CURRENT_LEVEL.neon
        
        # Aggiornare il file di configurazione per includere il baseline
        if ! grep -q "phpstan-baseline-level-$CURRENT_LEVEL.neon" phpstan.neon; then
            sed -i "/includes:/a \    - phpstan-baseline-level-$CURRENT_LEVEL.neon" phpstan.neon
        fi
        
        echo -e "${YELLOW}Baseline generato. Risolvi gli errori manualmente prima di passare al livello successivo.${NC}"
        echo -e "${YELLOW}Quando sei pronto, rimuovi il baseline dal file phpstan.neon e rilancia questo script.${NC}"
        break
    else
        echo -e "${GREEN}Nessun errore trovato al livello $CURRENT_LEVEL!${NC}"
        CURRENT_LEVEL=$((CURRENT_LEVEL+1))
        echo -e "${BLUE}Passaggio al livello $CURRENT_LEVEL${NC}"
    fi
done

if [ $CURRENT_LEVEL -gt $MAX_LEVEL ]; then
    echo -e "${GREEN}Congratulazioni! Il codice ha superato tutti i livelli di analisi di PHPStan!${NC}"
fi 