<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

/**
 * Class FirebaseNotificationData
 * Data Transfer Object per le notifiche Firebase
 */
class FirebaseNotificationData extends Data
{
    /**
     * @param string $title Titolo della notifica
     * @param string $body Corpo della notifica
     * @param array<string, string> $data Dati aggiuntivi per la notifica
     */
    public function __construct(
        public string $title,
        public string $body,
        public array $data = []
    ) {
        // Validazione dei dati
        if (!is_array($this->data)) {
            $this->data = [];
        }
    }
}
