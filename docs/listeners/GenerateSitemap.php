<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Support\Str;
use samdark\sitemap\Sitemap;
use TightenCo\Jigsaw\Jigsaw;

class GenerateSitemap
{
    private array $exclude = [
        '/assets/*',
        '*/favicon.ico',
        '*/404',
    ];

    public function handle(Jigsaw $jigsaw): void
    {
        $baseUrl = $jigsaw->getConfig('baseUrl');

        if (! $baseUrl) {
            echo "\nTo generate a sitemap.xml file, please specify a 'baseUrl' in config.php.\n\n";

            return;
        }

<<<<<<< HEAD
        $sitemap = new Sitemap($jigsaw->getDestinationPath() . '/sitemap.xml');
=======
        $sitemap = new Sitemap($jigsaw->getDestinationPath().'/sitemap.xml');
>>>>>>> 99e52f1 (first)

        collect($jigsaw->getOutputPaths())
            ->reject(fn ($path) => $this->isExcluded($path))->each(
                static function (string $path) use ($baseUrl, $sitemap): void {
<<<<<<< HEAD
                    $sitemap->addItem(rtrim((string) $baseUrl, '/') . $path, time(), Sitemap::DAILY);
=======
                    $sitemap->addItem(rtrim((string) $baseUrl, '/').$path, time(), Sitemap::DAILY);
>>>>>>> 99e52f1 (first)
                }
            );

        $sitemap->write();
    }

    public function isExcluded($path)
    {
        return Str::is($this->exclude, $path);
    }
}