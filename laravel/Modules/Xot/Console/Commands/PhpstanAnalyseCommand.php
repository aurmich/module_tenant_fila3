<?php

declare(strict_types=1);

/**
 * Questo file è parte del modulo Xot e definisce un comando Artisan personalizzato
 * per eseguire l'analisi PHPStan sul codice del progetto.
 *
 * Il comando permette di:
 * - Analizzare specifici file o directory con PHPStan
 * - Specificare il livello di rigore dell'analisi (da 1 a 10)
 * - Configurare il limite di memoria utilizzabile
 * - Abilitare Xdebug per il debugging
 * - Disabilitare la barra di progresso
 * - Specificare un file di configurazione personalizzato
 * - Eseguire una simulazione (dry run) senza eseguire effettivamente l'analisi
 *
 * Esempio di utilizzo:
 * ```
 * php artisan phpstan:analyse app/Models --level=5 --memory=1G
 * ```
 *
 * Nota: Questo comando viene registrato automaticamente tramite il metodo registerCommands()
 * nel XotBaseServiceProvider. Affinché appaia nell'elenco dei comandi, è necessario che:
 * 1. Il modulo Xot sia correttamente installato e registrato in Laravel
 * 2. Il namespace e il percorso del file siano corretti
 * 3. La classe estenda XotBaseCommand
 */

namespace Modules\Xot\Console\Commands;

use Illuminate\Support\Facades\Process;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Comando per eseguire l'analisi PHPStan sul codice del progetto.
 * 
 * Questo comando crea un wrapper intorno al comando CLI di PHPStan,
 * permettendo di eseguirlo direttamente tramite Artisan con opzioni configurabili.
 */
class PhpstanAnalyseCommand extends XotBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'phpstan:analyse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esegue PHPStan per analizzare il codice PHP con livello configurabile';

    /**
     * Esegue l'analisi PHPStan su file o directory specifici.
     *
     * @return int Il codice di uscita del processo
     */
    public function handle(): int
    {
        // Verifica se il comando è disponibile
        $registeredCommands = array_keys($this->getLaravel()->make('Illuminate\Contracts\Console\Kernel')->all());
        if (!in_array($this->name, $registeredCommands, true)) {
            $this->error("Il comando {$this->name} non è registrato correttamente.");
            $this->info("Verificare che il modulo Xot sia correttamente installato e configurato.");
            return 1;
        }

        /** @var array<int,string>|string $paths */
        $paths = $this->argument('paths');

        /** @var int $level */
        $level = (int)($this->option('level') ?? 9);

        /** @var string $memory */
        $memory = is_string($this->option('memory')) ? $this->option('memory') : '2G';

        /** @var bool $isXdebug */
        $isXdebug = (bool)$this->option('xdebug');
        $xdebug = $isXdebug ? '--xdebug' : '';

        /** @var bool $isNoProgress */
        $isNoProgress = (bool)$this->option('no-progress');
        $noProgress = $isNoProgress ? '--no-progress' : '';

        /** @var string|null $config */
        $config = $this->option('config');
        $configPath = $config !== null && is_string($config) ? "--configuration={$config}" : '';

        $pathsString = is_array($paths) ? implode(' ', $paths) : (string)$paths;

        // Validazione del percorso PHPStan
        $phpstanExecutable = base_path('vendor/bin/phpstan');

        if (!file_exists($phpstanExecutable)) {
            $this->error('PHPStan non è stato trovato. Assicurati che sia installato tramite Composer.');
            return 1;
        }

        $baseCommand = sprintf(
            '%s analyse %s --level=%d --memory-limit=%s %s %s %s',
            $phpstanExecutable,
            $pathsString,
            $level,
            $memory,
            $xdebug,
            $noProgress,
            $configPath
        );

        $this->info("Esecuzione PHPStan a livello {$level}");
        $this->info("Comando: {$baseCommand}");

        /** @var bool $isDryRun */
        $isDryRun = (bool)$this->option('dry-run');
        if ($isDryRun) {
            $this->info("Questa è una simulazione (dry-run): il comando non verrà eseguito.");
            $this->info("Per eseguire effettivamente il comando, rimuovere l'opzione --dry-run");
            return 0;
        }

        // Esegui il processo
        $result = Process::run($baseCommand);

        // Mostra l'output
        $output = $result->output();
        $this->info($output);

        // Restituisci lo status code del processo
        $exitCode = $result->exitCode();
        return $exitCode !== null ? $exitCode : 1;
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, array{0: string, 1: int, 2: string}>
     */
    protected function getArguments(): array
    {
        return [
            ['paths', InputArgument::IS_ARRAY, 'I percorsi dei file o delle directory da analizzare'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array<int, array{0: string, 1: string|null, 2: int, 3: string, 4: int|string|bool|null}>
     */
    protected function getOptions(): array
    {
        return [
            ['level', 'l', InputOption::VALUE_OPTIONAL, 'Livello di analisi PHPStan (1-10, default: 9)', 9],
            ['memory', 'm', InputOption::VALUE_OPTIONAL, 'Limite di memoria per PHPStan', '2G'],
            ['xdebug', 'x', InputOption::VALUE_NONE, 'Abilita Xdebug per il debugging', null],
            ['no-progress', 'p', InputOption::VALUE_NONE, 'Non mostrare la barra di progresso', null],
            ['config', 'c', InputOption::VALUE_OPTIONAL, 'Percorso al file di configurazione PHPStan', null],
            ['dry-run', 'd', InputOption::VALUE_NONE, 'Mostra solo il comando senza eseguirlo', null],
        ];
    }
}
