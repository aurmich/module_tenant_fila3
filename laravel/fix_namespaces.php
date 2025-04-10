<?php

/**
 * Script di correzione automatica dei namespace - Progetto SaluteOra.
 * 
 * Questo script corregge i problemi di namespace più comuni nei moduli Laraxot,
 * allineandoli con lo standard PSR-4 e risolvendo i conflitti.
 * 
 * ATTENZIONE: Eseguire backup prima di utilizzare questo script.
 */

declare(strict_types=1);

// Configurazione
$modulesPath = __DIR__ . '/Modules';
$backupDir = __DIR__ . '/namespace_backup_' . date('Ymd_His');
$logFile = __DIR__ . '/namespace_fixes.log';
$dryRun = false; // Modalità di applicazione delle modifiche attiva

// Statistiche
$totalFiles = 0;
$modifiedFiles = 0;
$errorFiles = 0;

// Inizializzazione log
$log = "=== CORREZIONE NAMESPACE SALUTEORA ===\n\n";
$log .= "Data esecuzione: " . date('Y-m-d H:i:s') . "\n";
$log .= "Modalità: " . ($dryRun ? "Simulazione (dry run)" : "Modifica effettiva") . "\n\n";

// Crea directory di backup
if (!$dryRun && !is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
    $log .= "Directory di backup creata: $backupDir\n";
}

/**
 * Funzione per esplorare ricorsivamente le directory e trovare i file PHP.
 */
function scanDirectoryForPhpFiles(string $dir): array {
    $results = [];
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            $results = array_merge($results, scanDirectoryForPhpFiles($path));
        } else if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $results[] = $path;
        }
    }
    
    return $results;
}

/**
 * Funzione per estrarre il namespace e la classe da un file PHP.
 */
function extractNamespaceAndClass(string $filePath): ?array {
    $content = file_get_contents($filePath);
    if ($content === false) {
        return null;
    }

    // Estrazione namespace
    $namespacePattern = '/namespace\s+([^;]+);/';
    preg_match($namespacePattern, $content, $namespaceMatches);
    $namespace = $namespaceMatches[1] ?? null;

    // Estrazione classe/interfaccia/trait
    $classPattern = '/\b(?:class|interface|trait|enum)\s+([a-zA-Z0-9_]+)/';
    preg_match($classPattern, $content, $classMatches);
    $className = $classMatches[1] ?? null;

    if (!$namespace) {
        return null;
    }

    return [
        'namespace' => $namespace,
        'className' => $className,
        'content' => $content
    ];
}

/**
 * Funzione per determinare il namespace corretto in base al percorso del file.
 */
function getCorrectNamespace(string $filePath, string $modulesPath): string {
    // Estrai il percorso relativo dal percorso moduli
    $relativePath = str_replace($modulesPath, '', $filePath);
    $relativeDir = dirname($relativePath);
    
    // Rimuovi lo slash iniziale se presente
    $relativeDir = ltrim($relativeDir, '/');
    
    // Estrai il nome del modulo (primo segmento del percorso)
    $pathParts = explode('/', $relativeDir);
    $moduleName = $pathParts[0] ?? '';
    
    // Costruisci il namespace atteso secondo PSR-4
    $expectedNamespaceParts = [];
    $expectedNamespaceParts[] = 'Modules';
    $expectedNamespaceParts[] = $moduleName;
    
    // Mappatura di nomi di directory al formato corretto per namespace
    $directoryNamespaceMap = [
        'app' => 'App',
        'database' => 'Database',
        'http' => 'Http',
        'providers' => 'Providers',
        'models' => 'Models',
        'controllers' => 'Controllers',
        'middleware' => 'Middleware',
        'traits' => 'Traits',
        'events' => 'Events',
        'listeners' => 'Listeners',
        'filament' => 'Filament',
        'resources' => 'Resources',
        'pages' => 'Pages',
        'widgets' => 'Widgets',
        'actions' => 'Actions',
        'datas' => 'Datas',
        'migrations' => 'Migrations',
        'seeders' => 'Seeders',
        'factories' => 'Factories',
        'jobs' => 'Jobs',
        'services' => 'Services',
        'src' => 'Src',
        'forms' => 'Forms',
        'components' => 'Components',
        'support' => 'Support',
    ];
    
    // Aggiungi le directory rimanenti (escluso il modulo)
    for ($i = 1; $i < count($pathParts); $i++) {
        $part = $pathParts[$i];
        $part = $directoryNamespaceMap[strtolower($part)] ?? $part;
        $expectedNamespaceParts[] = $part;
    }
    
    return implode('\\', $expectedNamespaceParts);
}

/**
 * Funzione per correggere il namespace in un file.
 */
function fixNamespace(string $filePath, string $modulesPath, string $backupDir, bool $dryRun): array {
    global $log;
    
    $extracted = extractNamespaceAndClass($filePath);
    if (!$extracted) {
        return [
            'modified' => false,
            'error' => 'Impossibile estrarre namespace/classe'
        ];
    }
    
    $oldNamespace = $extracted['namespace'];
    $newNamespace = getCorrectNamespace($filePath, $modulesPath);
    
    // Se il namespace è già corretto, non fare nulla
    if ($oldNamespace === $newNamespace) {
        return [
            'modified' => false,
            'error' => null
        ];
    }
    
    $content = $extracted['content'];
    $newContent = str_replace(
        "namespace $oldNamespace;",
        "namespace $newNamespace;",
        $content
    );
    
    // Crea backup del file originale
    if (!$dryRun) {
        $relativePath = str_replace($modulesPath, '', $filePath);
        $backupPath = $backupDir . $relativePath;
        $backupDirPath = dirname($backupPath);
        
        if (!is_dir($backupDirPath)) {
            mkdir($backupDirPath, 0755, true);
        }
        
        if (!copy($filePath, $backupPath)) {
            return [
                'modified' => false,
                'error' => "Impossibile creare backup: $backupPath"
            ];
        }
        
        // Scrivi le modifiche al file
        if (file_put_contents($filePath, $newContent) === false) {
            return [
                'modified' => false,
                'error' => "Impossibile scrivere il file: $filePath"
            ];
        }
    }
    
    return [
        'modified' => true,
        'oldNamespace' => $oldNamespace,
        'newNamespace' => $newNamespace,
        'error' => null
    ];
}

// Inizio della correzione
$log .= "Scansione directory: $modulesPath\n\n";

$phpFiles = scanDirectoryForPhpFiles($modulesPath);
$totalFiles = count($phpFiles);

$log .= "Totale file PHP trovati: $totalFiles\n\n";
$log .= "=== CORREZIONI INIZIATE ===\n\n";

foreach ($phpFiles as $filePath) {
    $result = fixNamespace($filePath, $modulesPath, $backupDir, $dryRun);
    
    if ($result['error']) {
        $errorFiles++;
        $log .= "ERRORE - $filePath: {$result['error']}\n";
    } else if ($result['modified']) {
        $modifiedFiles++;
        $log .= "MODIFICATO - $filePath:\n";
        $log .= "  Namespace vecchio: {$result['oldNamespace']}\n";
        $log .= "  Namespace nuovo: {$result['newNamespace']}\n\n";
    }
}

// Riepilogo
$log .= "\n=== RIEPILOGO ===\n\n";
$log .= "File PHP analizzati: $totalFiles\n";
$log .= "File modificati: $modifiedFiles\n";
$log .= "File con errori: $errorFiles\n";

// Salvataggio log
file_put_contents($logFile, $log);

echo "Correzione namespace completata. Riepilogo:\n";
echo "- File PHP analizzati: $totalFiles\n";
echo "- File modificati: $modifiedFiles\n";
echo "- File con errori: $errorFiles\n";
echo "Log completo salvato in: $logFile\n";

if ($dryRun) {
    echo "\nATTENZIONE: Esecuzione in modalità simulazione (dry run).\n";
    echo "Nessuna modifica è stata applicata ai file.\n";
    echo "Per applicare le modifiche, impostare \$dryRun = false nel codice.\n";
}
