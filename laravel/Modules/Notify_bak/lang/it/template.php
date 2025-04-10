<?php

return [
    'navigation' => [
        'group' => 'Sistema',
        'label' => 'Template Notifiche',
        'icon' => 'notify-template-animated',
        'sort' => 48,
        'description' => 'Gestione dei modelli per le notifiche',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome identificativo del template',
            'placeholder' => 'es: Notifica Scadenza',
            'help' => 'Inserisci un nome descrittivo per il template',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => 'Descrizione del template',
            'placeholder' => 'es: Template per le notifiche di scadenza',
            'help' => 'Breve descrizione dello scopo del template',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'tooltip' => 'Oggetto della notifica',
            'placeholder' => 'es: Promemoria: {event_name}',
            'help' => 'Puoi usare le variabili tra parentesi graffe',
        ],
        'body' => [
            'label' => 'Corpo',
            'tooltip' => 'Contenuto del messaggio',
            'placeholder' => 'es: Gentile {user_name},\n\nTi ricordiamo che...',
            'help' => 'Il contenuto principale della notifica. Supporta HTML per le email.',
        ],
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Tipo di notifica',
            'help' => 'Seleziona il tipo di notifica per cui usare questo template',
            'options' => [
                'email' => [
                    'label' => 'Email',
                    'tooltip' => 'Template per notifiche email',
                ],
                'sms' => [
                    'label' => 'SMS',
                    'tooltip' => 'Template per messaggi SMS',
                ],
                'push' => [
                    'label' => 'Push',
                    'tooltip' => 'Template per notifiche push',
                ],
                'telegram' => [
                    'label' => 'Telegram',
                    'tooltip' => 'Template per messaggi Telegram',
                ],
            ],
        ],
        'variables' => [
            'label' => 'Variabili disponibili',
            'tooltip' => 'Variabili che possono essere utilizzate nel template',
            'help' => 'Usa queste variabili per personalizzare il contenuto',
            'sections' => [
                'user' => [
                    'label' => 'Utente',
                    'tooltip' => 'Variabili relative all\'utente',
                    'variables' => [
                        'name' => [
                            'label' => 'Nome utente',
                            'tooltip' => '{user_name} - Nome completo dell\'utente',
                        ],
                        'email' => [
                            'label' => 'Email utente',
                            'tooltip' => '{user_email} - Indirizzo email dell\'utente',
                        ],
                    ],
                ],
                'notification' => [
                    'label' => 'Notifica',
                    'tooltip' => 'Variabili relative alla notifica',
                    'variables' => [
                        'title' => [
                            'label' => 'Titolo notifica',
                            'tooltip' => '{notification_title} - Titolo della notifica',
                        ],
                        'message' => [
                            'label' => 'Messaggio notifica',
                            'tooltip' => '{notification_message} - Messaggio della notifica',
                        ],
                        'date' => [
                            'label' => 'Data notifica',
                            'tooltip' => '{notification_date} - Data della notifica',
                        ],
                    ],
                ],
            ],
        ],
        'is_active' => [
            'label' => 'Attivo',
            'tooltip' => 'Stato di attivazione del template',
            'help' => 'Solo i template attivi possono essere utilizzati',
        ],
    ],
    'actions' => [
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Visualizza anteprima del template',
            'icon' => 'heroicon-o-eye',
            'color' => 'primary',
        ],
        'test' => [
            'label' => 'Invia test',
            'tooltip' => 'Invia una notifica di test usando questo template',
            'icon' => 'heroicon-o-paper-airplane',
            'color' => 'info',
            'confirmation' => [
                'title' => 'Conferma test',
                'message' => 'Vuoi inviare una notifica di test usando questo template?',
                'confirm' => 'Sì, invia test',
                'cancel' => 'No, annulla',
            ],
        ],
        'duplicate' => [
            'label' => 'Duplica',
            'tooltip' => 'Crea una copia di questo template',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'success',
            'confirmation' => [
                'title' => 'Conferma duplicazione',
                'message' => 'Vuoi creare una copia di questo template?',
                'confirm' => 'Sì, duplica',
                'cancel' => 'No, annulla',
            ],
        ],
    ],
    'messages' => [
        'preview_title' => [
            'title' => 'Anteprima Template',
            'message' => 'Questa è un\'anteprima di come apparirà la notifica',
        ],
        'test_sent' => [
            'title' => 'Test Inviato',
            'message' => 'La notifica di test è stata inviata con successo',
        ],
        'duplicated' => [
            'title' => 'Template Duplicato',
            'message' => 'Il template è stato duplicato con successo',
        ],
    ],
];
