<?php

return [
    'navigation' => [
        'name' => 'Attività',
        'plural' => 'Attività',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Monitoraggio delle attività di sistema',
        ],
        'label' => 'Attività',
        'sort' => 60,
        'icon' => 'activity-activity-animated',
    ],
    'fields' => [
        'user' => [
            'label' => 'Utente',
            'name' => 'Nome',
            'email' => 'Email',
            'role' => 'Ruolo',
        ],
        'action' => [
            'label' => 'Azione',
            'created' => 'Creato',
            'updated' => 'Modificato',
            'deleted' => 'Eliminato',
            'viewed' => 'Visualizzato',
            'downloaded' => 'Scaricato',
            'uploaded' => 'Caricato',
            'logged_in' => 'Accesso',
            'logged_out' => 'Uscita',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'type' => 'Tipo',
            'id' => 'ID',
            'name' => 'Nome',
        ],
        'description' => 'Descrizione',
        'ip_address' => 'Indirizzo IP',
        'user_agent' => 'User Agent',
        'created_at' => 'Data',
        'properties' => [
            'label' => 'Proprietà',
            'old' => 'Vecchio Valore',
            'new' => 'Nuovo Valore',
        ],
    ],
    'filters' => [
        'user' => 'Utente',
        'action' => 'Azione',
        'subject_type' => 'Tipo Oggetto',
        'date_range' => 'Intervallo Date',
        'ip_address' => 'Indirizzo IP',
    ],
    'actions' => [
        'view_details' => 'Visualizza Dettagli',
        'export' => 'Esporta',
        'clear_old' => 'Pulisci Vecchie',
    ],
    'messages' => [
        'no_activities' => 'Nessuna attività trovata',
        'cleared' => 'Attività vecchie eliminate con successo',
        'exported' => 'Attività esportate con successo',
    ],
    'export' => [
        'formats' => [
            'csv' => 'CSV',
            'excel' => 'Excel',
            'pdf' => 'PDF',
        ],
        'columns' => [
            'date' => 'Data',
            'user' => 'Utente',
            'action' => 'Azione',
            'subject' => 'Oggetto',
            'ip' => 'IP',
        ],
    ],
];
