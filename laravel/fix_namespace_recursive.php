<?php

declare(strict_types=1);

/**
 * Script per correggere ricorsivamente i namespace nei file dei moduli Laraxot.
 * 
 * Questo script analizza tutti i file PHP nei moduli e corregge i namespace che includono
 * erroneamente "App" nel percorso, rendendoli conformi alla configurazione PSR-4 definita
 * nei composer.json dei moduli.
 */

// Configurazione iniziale
$modulesDir = __DIR__ . '/Modules';
$backup = true; // Se true, crea un backup dei file prima di modificarli
$dryRun = false; // Se true, mostra solo le modifiche senza applicarle

// Controllo dei parametri da riga di comando
if (in_array('--no-backup', $argv)) {
    $backup = false;
    echo "Modalità backup disabilitata.\n";
}

if (in_array('--dry-run', $argv)) {
    $dryRun = true;
    echo "Modalità dry-run attivata. Nessuna modifica verrà applicata.\n";
}

// Funzione per ottenere tutti i moduli
function getModules(string $modulesDir): array {
    $modules = [];
    $dir = new DirectoryIterator($modulesDir);
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            $moduleName = $fileinfo->getFilename();
            // Ignora directory che non sono moduli
            if (file_exists($modulesDir . '/' . $moduleName . '/module.json')) {
                $modules[] = $moduleName;
            }
        }
    }
    return $modules;
}

// Funzione per verificare e correggere i namespace nei file PHP
function fixNamespaces(string $modulesDir, string $moduleName, bool $backup = true, bool $dryRun = false): int {
    $moduleDir = $modulesDir . '/' . $moduleName;
    $appDir = $moduleDir . '/app';
    
    if (!is_dir($appDir)) {
        echo "Directory 'app' non trovata nel modulo $moduleName. Skipping.\n";
        return 0;
    }
    
    $fixedCount = 0;
    
    // Ottieni tutti i file PHP ricorsivamente
    $phpFiles = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($appDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($phpFiles as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filepath = $file->getRealPath();
            $content = file_get_contents($filepath);
            
            // Cerca il namespace errato del tipo Modules\ModuleName\App\
            if (preg_match('/namespace\s+Modules\\\\' . $moduleName . '\\\\App\\\/i', $content)) {
                $newContent = preg_replace(
                    '/namespace\s+Modules\\\\' . $moduleName . '\\\\App\\\\/i',
                    'namespace Modules\\' . $moduleName . '\\',
                    $content
                );
                
                if ($newContent !== $content) {
                    $relPath = str_replace($modulesDir . '/', '', $filepath);
                    echo "Fixing namespace in: $relPath\n";
                    
                    if (!$dryRun) {
                        if ($backup) {
                            file_put_contents($filepath . '.bak', $content);
                        }
                        file_put_contents($filepath, $newContent);
                    }
                    
                    $fixedCount++;
                }
            }
        }
    }
    
    return $fixedCount;
}

// Esecuzione principale
echo "Iniziando la correzione dei namespace nei moduli Laraxot...\n";
$modules = getModules($modulesDir);

if (empty($modules)) {
    die("Nessun modulo trovato in $modulesDir\n");
}

echo "Moduli trovati: " . implode(', ', $modules) . "\n\n";

$totalFixed = 0;
foreach ($modules as $moduleName) {
    echo "Analisi del modulo $moduleName...\n";
    $fixed = fixNamespaces($modulesDir, $moduleName, $backup, $dryRun);
    $totalFixed += $fixed;
    echo "File corretti nel modulo $moduleName: $fixed\n\n";
}

echo "Completato. Totale file corretti: $totalFixed\n";

if ($dryRun) {
    echo "ATTENZIONE: Modalità dry-run attiva. Nessuna modifica è stata applicata.\n";
    echo "Esegui nuovamente lo script senza --dry-run per applicare le modifiche.\n";
} else if ($totalFixed > 0) {
    echo "È consigliabile eseguire 'composer dump-autoload' per aggiornare l'autoloader.\n";
}
