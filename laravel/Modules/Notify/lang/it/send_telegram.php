<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio Telegram',
    ],
    'navigation' => [
        'name' => 'Invio Telegram',
        'plural' => 'Invio Telegram',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Funzionalità per l\'invio di messaggi attraverso Telegram',
        ],
        'label' => 'Invio Telegram',
        'icon' => 'notify-telegram-animated',
        'sort' => 50,
    ],
    'fields' => [
        'chat_id' => [
            'label' => 'ID Chat',
        ],
        'message' => [
            'label' => 'Messaggio',
        ],
        'parse_mode' => [
            'label' => 'Formato',
            'options' => [
                'text' => 'Testo semplice',
                'html' => 'HTML',
                'markdown' => 'Markdown',
            ],
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia Messaggio',
            'success' => 'Messaggio inviato con successo',
            'error' => 'Errore durante l\'invio del messaggio',
        ],
        'preview' => [
            'label' => 'Anteprima',
        ],
    ],
];
