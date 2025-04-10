#!/bin/bash

# Script per risolvere tutti i conflitti di merge in vari tipi di file
# Risolve automaticamente i conflitti mantenendo la versione più recente (e4940e9b)

echo "Risolvendo conflitti nei file PHP attivi..."

# 1. Risolvi conflitti nei file PHP standard (non backup) - suddiviso per directory per evitare "Argument list too long"
DIRS_TO_CHECK=("laravel/Modules/Broker/app/Models" "laravel/Modules/Broker/app/Http" "laravel/Modules/Broker/app/Filament")

for dir in "${DIRS_TO_CHECK[@]}"; do
  if [ -d "$dir" ]; then
    echo "Checking directory: $dir"
    for file in $(find "$dir" -type f -name "*.php" -not -name "*.old" -not -name "*.to_cluster" | xargs grep -l "<<<<<<< HEAD" 2>/dev/null)
    do
      echo "Fixing conflicts in $file"
      
      # Rimuove le righe di marcatura del conflitto e mantiene la versione "dopo il merge"
      sed -i -e '/^<<<<<<< HEAD$/d' \
             -e '/^=======$/d' \
             -e '/^>>>>>>> e4940e9b (first)$/d' \
             -e 's/namespace Modules\\Broker\\Filament\\Resources/namespace Modules\\Broker\\Filament\\Clusters\\AltriCluster\\Resources/' \
             -e 's/use Modules\\Broker\\Filament\\Resources\\/use Modules\\Broker\\Filament\\Clusters\\AltriCluster\\Resources\\/' \
             "$file"
    done
  fi
done

echo "Risolvendo conflitti nei file .to_cluster..."

# 2. Risolvi conflitti nei file .to_cluster (migrazione in corso)
for file in $(find laravel -type f -name "*.to_cluster" | xargs grep -l "<<<<<<< HEAD" 2>/dev/null)
do
  echo "Fixing conflicts in $file"
  
  # Rimuove le righe di marcatura del conflitto e mantiene la versione "dopo il merge"
  sed -i -e '/^<<<<<<< HEAD$/d' \
         -e '/^=======$/d' \
         -e '/^>>>>>>> e4940e9b (first)$/d' \
         -e 's/namespace Modules\\Broker\\Filament\\Resources/namespace Modules\\Broker\\Filament\\Clusters\\AltriCluster\\Resources/' \
         -e 's/use Modules\\Broker\\Filament\\Resources\\/use Modules\\Broker\\Filament\\Clusters\\AltriCluster\\Resources\\/' \
         "$file"
done

echo "Rimuovendo backup file con conflitti..."

# 3. Elimina i file .old con conflitti (sono backup)
find laravel -type f -name "*.old" | xargs grep -l "<<<<<<< HEAD" 2>/dev/null | while read file; do
  echo "Removing old backup file with conflicts: $file"
  rm "$file"
done

echo "Risolvendo conflitti in altri file (documentazione, etc.)..."

# 4. Conflitti in file di documentazione o altro
# Escludi i file .git e directory laravel già processate
find . -type f -not -path "*/.git/*" -not -path "*/laravel/*" | xargs grep -l "<<<<<<< HEAD" 2>/dev/null | while read file; do
  echo "Fixing conflicts in documentation or other file: $file"
  
  # Rimuove le righe di marcatura del conflitto e mantiene la versione "dopo il merge"
  sed -i -e '/^<<<<<<< HEAD$/d' \
         -e '/^=======$/d' \
         -e '/^>>>>>>> e4940e9b (first)$/d' \
         "$file"
done

echo "Tutti i conflitti sono stati risolti!" 