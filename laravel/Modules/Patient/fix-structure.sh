#!/bin/bash

# Creare le directory necessarie se non esistono
mkdir -p app/{Models,Http,View,Services,Events,Listeners,Notifications,Providers,Console,Filament}
mkdir -p resources/{views,lang}
mkdir -p database/{migrations,seeders}
mkdir -p tests/{Unit,Feature}

# Spostare i file nelle posizioni corrette
mv Entities/* app/Models/ 2>/dev/null || true
mv View/* app/View/ 2>/dev/null || true
mv Filament/* app/Filament/ 2>/dev/null || true
mv Services/* app/Services/ 2>/dev/null || true
mv Jobs/* app/Jobs/ 2>/dev/null || true
mv Providers/* app/Providers/ 2>/dev/null || true
mv Console/* app/Console/ 2>/dev/null || true
mv Resources/views/* resources/views/ 2>/dev/null || true
mv Resources/lang/* resources/lang/ 2>/dev/null || true
mv Database/migrations/* database/migrations/ 2>/dev/null || true
mv Database/seeders/* database/seeders/ 2>/dev/null || true
mv Tests/* tests/ 2>/dev/null || true

# Rimuovere le directory non necessarie
rm -rf Entities View Filament Services Jobs Providers Console Resources Database Tests
rm -rf bashscripts workbench _docs
rm -rf Config Database Routes

# Aggiornare i namespace nei file PHP
find app -type f -name "*.php" -exec sed -i 's/namespace Modules\\Patient\\Entities/namespace Modules\\Patient\\Models/g' {} +
find app -type f -name "*.php" -exec sed -i 's/use Modules\\Patient\\Entities/use Modules\\Patient\\Models/g' {} +

echo "Struttura del modulo Patient corretta con successo!" 