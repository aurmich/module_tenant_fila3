#!/bin/bash

# Script per risolvere conflitti di merge in file PHP
# Risolve automaticamente i conflitti mantenendo la versione più recente (e4940e9b)

for file in $(grep -l "<<<<<<< HEAD" $(find laravel/Modules/Broker/app/Filament/Clusters/AltriCluster/Resources -type f -name "*.php"))
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

echo "Tutti i conflitti sono stati risolti!" 