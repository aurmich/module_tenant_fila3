<?php

/**
 * @see https://github.com/protonemedia/laravel-ffmpeg
 */

declare(strict_types=1);

namespace Modules\Media\Actions\Image;

// use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\QueueableAction\QueueableAction;

class Merge
{
    use QueueableAction;

    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    public function execute(array $filenames, string $filenameOut): void
    {
        $manager = app(ImageManager::class);
        $width = 0;
        $height = 0;

        // Prima passata per calcolare le dimensioni totali
        foreach ($filenames as $filename) {
            $img = $manager->read(public_path($filename));
            $width += $img->width();
            $height = max($height, $img->height());
        }

        // Crea un'immagine vuota con le dimensioni calcolate
        $img_canvas = $manager->create($width, $height);

        // Seconda passata per inserire le immagini
        $delta = 0;
        foreach ($filenames as $filename) {
            $img = $manager->read(public_path($filename));
            $img_canvas->place($img, 'top-left', $delta, 0);
            $delta += $img->width();
        }

        $img_canvas->save(public_path().'/'.$filenameOut, 100);
    }
}
