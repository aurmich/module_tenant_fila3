<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> de24ed2 (fix: auto resolve conflict)
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per ottenere il nome del tenant basato sul server name.
 */
<<<<<<< HEAD
=======
=======
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
class GetTenantNameAction
{
    use QueueableAction;

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> de24ed2 (fix: auto resolve conflict)
    /**
     * Esegue l'action per ottenere il nome del tenant.
     *
     * @return string Il nome del tenant
     */
    public function execute(): string
    {
<<<<<<< HEAD
=======
=======
    public function execute(): string
    {
        // $default = env('APP_URL');
>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
        $default = config('app.url');
        if (! \is_string($default)) {
            $default = 'localhost';
        }

        $default = Str::after($default, '//');

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> de24ed2 (fix: auto resolve conflict)
        $server_name = $this->getServerName($default);
        $server_name = Str::of($server_name)->replace('www.', '')->toString();

        /** @var Collection<int, string> $parts */
        $parts = collect(explode('.', $server_name))
            ->map(static fn (string $item): string => Str::slug($item))
            ->reverse()
            ->values();

        // Prova il percorso completo
        $config_file = $this->buildConfigPath($parts);
        if (file_exists($config_file)) {
            return $parts->implode('/');
        }

        // Prova il percorso senza l'ultimo segmento se ci sono più di 2 parti
        if ($parts->count() > 2) {
            /** @var Collection<int, string> $shortened_parts */
            $shortened_parts = $parts->slice(0, -1);
            $config_file = $this->buildConfigPath($shortened_parts);
            if (file_exists($config_file)) {
                return $shortened_parts->implode('/');
            }
        }

        // Fallback al default
        $default_path = str_replace('.', '/', $default);
        if ($default_path !== '' && file_exists(base_path('config/'.$default_path))) {
            return $default_path;
        }

        return 'localhost';
    }

    /**
     * Ottiene il nome del server con fallback al default.
     *
     * @param string $default Il valore di default da usare
     * @return string Il nome del server
     */
    private function getServerName(string $default): string
    {
        if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] !== '127.0.0.1' && is_string($_SERVER['SERVER_NAME'])) {
            return $_SERVER['SERVER_NAME'];
<<<<<<< HEAD
=======
=======
        $server_name = $default;
        if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] !== '127.0.0.1') {
            // $server_name = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];
            $server_name = $_SERVER['SERVER_NAME'];
        }
        if (! is_string($server_name)) {
            $server_name = $default;
        }
        $server_name = Str::of($server_name)->replace('www.', '')->toString();

        $tmp = collect(explode('.', $server_name))
            ->map(
                static fn ($item) => Str::slug($item)
            )->reverse()
            ->values();

        $config_file = config_path($tmp->implode(\DIRECTORY_SEPARATOR));

        if (file_exists($config_file)) {
            return $tmp->implode('/');
        }

        $config_file = config_path($tmp->slice(0, -1)->implode(\DIRECTORY_SEPARATOR));
        if (file_exists($config_file) && $tmp->count() > 2) {
            return $tmp->slice(0, -1)->implode('/');
        }

        // default

        $default = str_replace('.', '/', $default);
        if (! file_exists(base_path('config/'.$default))) {
            return 'localhost';
        }

        if ($default === '') {
            return 'localhost';
>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
        }

        return $default;
    }
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> de24ed2 (fix: auto resolve conflict)

    /**
     * Costruisce il percorso di configurazione.
     *
     * @param Collection<int, string> $parts Le parti del percorso
     * @return string Il percorso completo
     */
    private function buildConfigPath(Collection $parts): string
    {
        return config_path($parts->implode(DIRECTORY_SEPARATOR));
    }
<<<<<<< HEAD
=======
=======
>>>>>>> 9f73f2a (.)
>>>>>>> de24ed2 (fix: auto resolve conflict)
}
