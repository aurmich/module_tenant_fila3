<?php

return [
    'resource' => [
        'name' => 'Invio Email',
    ],
    'navigation' => [
        'name' => 'Invio Email',
        'plural' => 'Invio Email',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Funzionalità per l\'invio di email attraverso il sistema di notifiche',
        ],
        'label' => 'Invio Email',
        'icon' => 'notify-email-animated',
        'sort' => 49,
    ],
    'fields' => [
        'to' => [
            'label' => 'Destinatario',
        ],
        'subject' => [
            'label' => 'Oggetto',
        ],
        'body_html' => [
            'label' => 'Contenuto HTML',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia Email',
            'success' => 'Email inviata con successo',
            'error' => 'Errore durante l\'invio dell\'email',
        ],
        'preview' => [
            'label' => 'Anteprima',
        ],
    ],
];
