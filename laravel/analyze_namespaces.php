<?php

/**
 * Script di analisi namespace - Progetto SaluteOra.
 * 
 * Questo script analizza tutti i file PHP nei moduli Laraxot
 * per identificare problemi di autoloading, conflitti di namespace
 * e non conformità con lo standard PSR-4.
 */

declare(strict_types=1);

// Configurazione
$modulesPath = __DIR__ . '/Modules';
$outputFile = __DIR__ . '/namespace_analysis.txt';

// Contatori
$totalFiles = 0;
$filesWithNamespace = 0;
$filesWithPsr4Issues = 0;

// Array per il tracciamento
$namespaces = [];
$classMaps = [];
$potentialConflicts = [];
$psr4Issues = [];

// Intestazione output
$output = "=== ANALISI NAMESPACE SALUTEORA ===\n\n";
$output .= "Data esecuzione: " . date('Y-m-d H:i:s') . "\n\n";

// Funzione per estrarre il namespace e nome classe dai file PHP
function extractNamespaceAndClass(string $filePath): ?array
{
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

    if (!$namespace || !$className) {
        return null;
    }

    return [
        'namespace' => $namespace,
        'className' => $className,
        'fullName' => $namespace . '\\' . $className
    ];
}

// Funzione per verificare conformità PSR-4
function checkPsr4Compliance(string $filePath, string $modulesPath, array $namespaceInfo): bool
{
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
    
    // Aggiungi le directory rimanenti (escluso il modulo)
    for ($i = 1; $i < count($pathParts); $i++) {
        $expectedNamespaceParts[] = $pathParts[$i];
    }
    
    $expectedNamespace = implode('\\', $expectedNamespaceParts);
    
    // Confronta con il namespace effettivo
    $actualNamespace = $namespaceInfo['namespace'];
    
    // Verifica eccezioni comuni (strutture non standard ma accettabili)
    $exceptions = [
        // Convenzioni Laravel che fanno eccezione al PSR-4 standard
        '/\bapp\b/i' => '/\bApp\b/',  // app dovrebbe essere App
        '/\bhttp\b/i' => '/\bHttp\b/',  // http dovrebbe essere Http
        '/\bproviders\b/i' => '/\bProviders\b/',  // providers dovrebbe essere Providers
    ];
    
    foreach ($exceptions as $pattern => $replacement) {
        $expectedNamespace = preg_replace($pattern, $replacement, $expectedNamespace);
    }
    
    return $actualNamespace === $expectedNamespace;
}

// Scansione ricorsiva delle directory
function scanDirectoryForPhpFiles(string $dir) {
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

// Inizio scansione directory
if (!is_dir($modulesPath)) {
    $output .= "ERRORE: Directory moduli non trovata: $modulesPath\n";
    file_put_contents($outputFile, $output);
    echo $output;
    exit(1);
}

$output .= "Scansione directory: $modulesPath\n\n";

$phpFiles = scanDirectoryForPhpFiles($modulesPath);
$totalFiles = count($phpFiles);

$output .= "Totale file PHP trovati: $totalFiles\n\n";
$output .= "=== ANALISI IN CORSO ===\n\n";

// Analisi file
foreach ($phpFiles as $filePath) {
    $namespaceInfo = extractNamespaceAndClass($filePath);
    
    // Salta file senza namespace o classe definita
    if (!$namespaceInfo) {
        continue;
    }
    
    $filesWithNamespace++;
    
    // Verifica conformità PSR-4
    $isPsr4Compliant = checkPsr4Compliance($filePath, $modulesPath, $namespaceInfo);
    
    if (!$isPsr4Compliant) {
        $filesWithPsr4Issues++;
        $psr4Issues[$filePath] = [
            'actual' => $namespaceInfo['namespace'],
            'class' => $namespaceInfo['className']
        ];
    }
    
    // Traccia namespace e classi
    $fullName = $namespaceInfo['fullName'];
    $className = $namespaceInfo['className'];
    
    if (!isset($classMaps[$className])) {
        $classMaps[$className] = [];
    }
    
    $classMaps[$className][] = [
        'namespace' => $namespaceInfo['namespace'],
        'path' => $filePath
    ];
    
    $namespaces[$namespaceInfo['namespace']] = ($namespaces[$namespaceInfo['namespace']] ?? 0) + 1;
}

// Identifica potenziali conflitti di classe
foreach ($classMaps as $className => $instances) {
    if (count($instances) > 1) {
        $potentialConflicts[$className] = $instances;
    }
}

// Genera report
$output .= "File con namespace definito: $filesWithNamespace/$totalFiles\n";
$output .= "File con problemi PSR-4: $filesWithPsr4Issues\n\n";

// Elenco problemi PSR-4
if (!empty($psr4Issues)) {
    $output .= "=== PROBLEMI PSR-4 ===\n\n";
    
    foreach ($psr4Issues as $filePath => $info) {
        $relativePath = str_replace($modulesPath, 'Modules', $filePath);
        $output .= "File: $relativePath\n";
        $output .= "  Namespace attuale: {$info['actual']}\n";
        $output .= "  Classe: {$info['class']}\n\n";
    }
}

// Elenco potenziali conflitti
if (!empty($potentialConflicts)) {
    $output .= "=== POTENZIALI CONFLITTI DI CLASSE ===\n\n";
    
    foreach ($potentialConflicts as $className => $instances) {
        $output .= "Classe: $className\n";
        
        foreach ($instances as $instance) {
            $relativePath = str_replace($modulesPath, 'Modules', $instance['path']);
            $output .= "  - Namespace: {$instance['namespace']}\n";
            $output .= "    File: $relativePath\n";
        }
        
        $output .= "\n";
    }
}

// Salva report
file_put_contents($outputFile, $output);

echo "Analisi completata. Report salvato in: $outputFile\n";
