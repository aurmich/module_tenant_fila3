<?php

declare(strict_types=1);

namespace Modules\Notify\Services;

use Illuminate\Support\Str;
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
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Factory method to create an instance.
     */
    public static function make(): self
    {
        return static::getInstance();
    }

    /**
     * Sets local variables and merges them with the vars array.
     * 
     * @param array<string, mixed> $vars
     */
    public function setLocalVars(array $vars): self
    {
        foreach ($vars as $k => $v) {
            if (property_exists($this, $k)) {
                $this->{$k} = $v;
            }
        }
        $this->vars = array_merge($this->vars, $vars);

        return $this;
    }

    /**
     * Unisce le variabili con quelle esistenti.
     *
     * @param array<string, mixed> $vars
     */
    public function mergeVars(array $vars): self
    {
        $this->vars = array_merge($this->vars, $vars);

        return $this;
    }

    /**
     * Invia l'SMS utilizzando il driver configurato.
     */
    public function send(): self
    {
        $engineClassName = '\\Modules\\Notify\\Services\\SmsEngines\\' . Str::studly($this->driver) . 'Engine';
        
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

        try {
            // Approccio semplificato senza reflection
            $instance->setLocalVars($this->vars)->send();
            $result = $instance->getVars();
            
            // Verifichiamo che il risultato sia un array
            if (!is_array($result)) {
                $result = [];
            }
            
            $this->mergeVars($result);
        } catch (\Exception $e) {
            throw new \RuntimeException("Errore durante l'invio dell'SMS: " . $e->getMessage());
        }

        return $this;
    }
}
