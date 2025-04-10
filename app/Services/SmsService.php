<?php

declare(strict_types=1);

namespace Modules\Notify\Services;

use Illuminate\Support\Str;

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
            self::$instance = new self();
        }

        return self::$instance;
    }

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

    public function mergeVars(array $vars): self
    {
        $this->vars = array_merge($this->vars, $vars);

        return $this;
    }

    public function send(): self
    {
        $class = '\Modules\Notify\Services\SmsEngines\\'.Str::studly($this->driver).'Engine';
        $instance = $class::make()
            ->setLocalVars($this->vars)
            ->send();

        $this->mergeVars($instance->getVars());

        return $this;
    }

    public function getVars(): array
    {
        return $this->vars;
    }
}
