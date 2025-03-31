<?php

return [
    'channels' => [
        'mail' => [
            'driver' => 'mail',
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'noreply@saluteora.it'),
                'name' => env('MAIL_FROM_NAME', 'SaluteOra'),
            ],
        ],
        'database' => [
            'driver' => 'database',
            'table' => 'notifications',
        ],
        'broadcast' => [
            'driver' => 'broadcast',
        ],
    ],
    'default_channel' => 'mail',
    'queue' => [
        'enabled' => true,
        'connection' => env('QUEUE_CONNECTION', 'database'),
    ],
    'templates' => [
        'appointment_reminder' => [
            'subject' => 'Promemoria Appuntamento',
            'body' => 'Gentile {patient_name}, le ricordiamo l\'appuntamento del {appointment_date} presso {dentist_name}.',
        ],
        'document_expiry' => [
            'subject' => 'Scadenza Documento',
            'body' => 'Gentile {patient_name}, il documento {document_name} scadrà il {expiry_date}.',
        ],
        'isee_update' => [
            'subject' => 'Aggiornamento ISEE',
            'body' => 'Gentile {patient_name}, il suo ISEE è stato aggiornato. Nuovo valore: {isee_value}.',
        ],
    ],
]; 