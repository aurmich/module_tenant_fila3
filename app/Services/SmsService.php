<?php

declare(strict_types=1);

namespace Modules\Notify\Services;

use Illuminate\Support\Str;
<<<<<<< HEAD
use Webmozart\Assert\Assert;

/**
 * Classe per l'invio di SMS.
 */
class SmsService
{
    // ---------CSS------------
    public ?string $to = null;

    public ?string $from = null;

    public ?string $body = null;
    
    /**
     * Variabili per il template SMS.
     *
     * @var array<string, mixed>
     */
    public array $vars = [];

    /**
     * Driver per l'invio degli SMS.
     */
    public string $driver = 'netfun';

    private static ?self $instance = null;

    /**
     * Ottiene un'istanza singleton della classe.
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
=======

// ---------CSS------------

/**
 * Class SmsService.
 */
class SmsService
{
    public ?string $from = null;

    public string $to;

    public string $driver = 'netfun';

    public ?string $body = null;

    public array $vars = [];

    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if (! self::$instance instanceof self) {
>>>>>>> origin/dev
            self::$instance = new self();
        }

        return self::$instance;
    }

<<<<<<< HEAD
    /**
     * Unisce le variabili con quelle esistenti.
     *
     * @param array<string, mixed> $vars
     */
=======
    public static function make(): self
    {
        return static::getInstance();
    }

    public function setLocalVars(array $vars): self
    {
        foreach ($vars as $k => $v) {
            $this->{$k} = $v;
        }
        $this->vars = array_merge($this->vars, $vars);

        return $this;
    }

>>>>>>> origin/dev
    public function mergeVars(array $vars): self
    {
        $this->vars = array_merge($this->vars, $vars);

        return $this;
    }

<<<<<<< HEAD
    /**
     * Invia l'SMS utilizzando il driver configurato.
     */
    public function send(): self
    {
        $engineClassName = '\Modules\Notify\Services\SmsEngines\\'.Str::studly($this->driver).'Engine';
        
        // Verifichiamo che la classe esista
        if (!class_exists($engineClassName)) {
            throw new \RuntimeException("La classe del motore SMS {$engineClassName} non esiste");
        }
        
        // Verifichiamo che la classe abbia il metodo make
        if (!method_exists($engineClassName, 'make')) {
            throw new \RuntimeException("La classe {$engineClassName} non implementa il metodo make()");
        }
        
        // Creiamo l'istanza in modo sicuro
        $instance = $engineClassName::make();
        
        // Verifichiamo che l'istanza sia un oggetto
        if (!is_object($instance)) {
            throw new \RuntimeException("Il metodo make() di {$engineClassName} non ha restituito un oggetto");
        }
        
        // Verifichiamo che l'istanza abbia i metodi necessari
        foreach (['setLocalVars', 'send', 'getVars'] as $method) {
            if (!method_exists($instance, $method)) {
                throw new \RuntimeException("L'istanza di {$engineClassName} non implementa il metodo {$method}()");
            }
        }
        
        // Utilizziamo reflection per chiamare i metodi in modo sicuro
        try {
            $reflectionClass = new \ReflectionClass($instance);
            
            // Chiamiamo setLocalVars
            $setLocalVarsMethod = $reflectionClass->getMethod('setLocalVars');
            $setLocalVarsMethod->invoke($instance, $this->vars);
            
            // Chiamiamo send
            $sendMethod = $reflectionClass->getMethod('send');
            $sendMethod->invoke($instance);
            
            // Chiamiamo getVars
            $getVarsMethod = $reflectionClass->getMethod('getVars');
            $result = $getVarsMethod->invoke($instance);
            
            // Verifichiamo che il risultato sia un array
            if (!is_array($result)) {
                $result = [];
            }
            
            // Convertiamo l'array in array<string, mixed>
            /** @var array<string, mixed> $typedResult */
            $typedResult = [];
            foreach ($result as $key => $value) {
                if (is_string($key)) {
                    $typedResult[$key] = $value;
                }
            }
            
            $this->mergeVars($typedResult);
        } catch (\ReflectionException $e) {
            throw new \RuntimeException("Errore durante la chiamata dei metodi: " . $e->getMessage());
        }
=======
    public function send(): self
    {
        $class = '\Modules\Notify\Services\SmsEngines\\'.Str::studly($this->driver).'Engine';
        $instance = $class::make()
            ->setLocalVars($this->vars)
            ->send();

        $this->mergeVars($instance->getVars());
>>>>>>> origin/dev

        return $this;
    }

<<<<<<< HEAD
    /**
     * Ottiene le variabili.
     *
     * @return array<string, mixed>
     */
=======
>>>>>>> origin/dev
    public function getVars(): array
    {
        return $this->vars;
    }
}
