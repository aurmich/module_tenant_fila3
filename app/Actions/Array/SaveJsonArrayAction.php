<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Array;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class SaveJsonArrayAction
{
    use QueueableAction;

    public function execute(array $data, string $filename): bool
    {
        $content = \Safe\json_encode($data, JSON_PRETTY_PRINT);
        //if ($content === false) {
        //    return false;
        //}
        return (bool) \Safe\file_put_contents($filename, $content);
    }
}
