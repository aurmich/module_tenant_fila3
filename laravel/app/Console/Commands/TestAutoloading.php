<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestAutoloading extends Command
{
    protected $signature = 'test:autoloading';
    protected $description = 'Test autoloading delle classi principali';

    public function handle()
    {
        $this->info('Test autoloading delle classi principali...');
        
        $classes = [
            \Modules\Xot\Providers\XotServiceProvider::class,
            \Modules\Lang\Providers\LangServiceProvider::class,
            \Modules\Tenant\Providers\TenantServiceProvider::class,
            \Modules\User\Providers\UserServiceProvider::class,
            \Modules\Media\Providers\MediaServiceProvider::class,
            \Modules\UI\Providers\UIServiceProvider::class,
            \Modules\Gdpr\Providers\GdprServiceProvider::class,
            \Modules\Patient\Providers\PatientServiceProvider::class,
        ];
        
        $success = true;
        
        foreach ($classes as $class) {
            try {
                $this->info("Testing {$class}... ");
                $reflection = new \ReflectionClass($class);
                $this->info("✅ Classe caricata correttamente!");
            } catch (\Throwable $e) {
                $this->error("❌ Errore: {$e->getMessage()}");
                $success = false;
            }
        }
        
        if ($success) {
            $this->info('Tutte le classi caricate correttamente!');
        } else {
            $this->error('Alcune classi non sono state caricate. Controlla gli errori sopra riportati.');
        }
    }
} 