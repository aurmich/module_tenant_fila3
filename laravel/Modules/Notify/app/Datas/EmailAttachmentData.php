<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class EmailAttachmentData extends Data
{
    public string $name;

    public string $contentType;

    private string $content;

    public function __construct(
        string $content,
        string $name = 'attachment.pdf',
        string $contentType = 'application/pdf'
    ) {
        $this->content = $content;
        $this->name = $name;
        $this->contentType = $contentType;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
