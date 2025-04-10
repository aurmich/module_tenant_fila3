<?php

return [
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Job',
        'plural' => 'Jobs',
        'group' => [
            'name' => 'Jobs',
            'description' => 'Gestione dei processi in background',
        ],
        'label' => 'jobs',
        'sort' => 30,
        'icon' => 'job.navigation',
    ],
    'fields' => [
        'id' => ['label' => 'ID', 'tooltip' => 'Identificatore univoco del job'],
        'queue' => ['label' => 'Coda', 'tooltip' => 'La coda a cui appartiene il job'],
        'payload' => ['label' => 'Payload', 'tooltip' => 'Dati associati al job'],
        'attempts' => ['label' => 'Tentativi', 'tooltip' => 'Numero di tentativi per eseguire il job'],
        'reserved_at' => ['label' => 'Riservato il', 'tooltip' => 'Data e ora in cui il job è stato riservato'],
        'available_at' => ['label' => 'Disponibile il', 'tooltip' => 'Data e ora in cui il job è diventato disponibile'],
        'created_at' => ['label' => 'Creato il', 'tooltip' => 'Data di creazione del job'],
        'status' => ['label' => 'Stato', 'tooltip' => 'Stato attuale del job'],
        'progress' => ['label' => 'Progresso', 'tooltip' => 'Percentuale di completamento del job'],
        'type' => ['label' => 'Tipo', 'tooltip' => 'Tipo di job (e.g., importazione, esportazione)'],
        'name' => ['label' => 'Nome', 'tooltip' => 'Nome del job'],
        'description' => ['label' => 'Descrizione', 'tooltip' => 'Descrizione del job', 'placeholder' => 'Inserisci una descrizione'],
        'guard_name' => ['label' => 'Guard', 'tooltip' => 'Guardiano del job'],
        'permissions' => ['label' => 'Permessi', 'tooltip' => 'Permessi associati al job'],
        'updated_at' => ['label' => 'Aggiornato il', 'tooltip' => 'Data dell’ultimo aggiornamento del job'],
        'first_name' => ['label' => 'Nome', 'tooltip' => 'Nome del responsabile'],
        'last_name' => ['label' => 'Cognome', 'tooltip' => 'Cognome del responsabile'],
        'select_all' => [
            'label' => 'Seleziona Tutti',
            'tooltip' => 'Seleziona tutti gli elementi disponibili',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa',
            'tooltip' => 'Importa dati da un file',
            'icon' => 'import-icon',
            'color' => 'blue',
            'fields' => [
                'import_file' => ['label' => 'Seleziona un file XLS o CSV da caricare', 'placeholder' => 'Seleziona il file da caricare'],
            ],
        ],
        'export' => [
            'label' => 'Esporta',
            'tooltip' => 'Esporta dati in un file',
            'icon' => 'export-icon',
            'color' => 'green',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => ['label' => 'Nome area', 'tooltip' => 'Nome dell’area da esportare'],
                'parent_name' => ['label' => 'Nome area livello superiore', 'tooltip' => 'Nome dell’area principale'],
            ],
        ],
        'run' => [
            'label' => 'Esegui',
            'icon' => 'play',
            'color' => 'green',
            'modal' => [
                'heading' => 'Esegui Job',
                'description' => 'Vuoi eseguire questo job?',
            ],
            'messages' => [
                'success' => 'Job avviato con successo',
            ],
        ],
        'stop' => [
            'label' => 'Ferma',
            'icon' => 'pause',
            'color' => 'red',
            'modal' => [
                'heading' => 'Ferma Job',
                'description' => 'Vuoi fermare questo job?',
            ],
            'messages' => [
                'success' => 'Job fermato con successo',
            ],
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'trash',
            'color' => 'red',
            'modal' => [
                'heading' => 'Elimina Job',
                'description' => 'Sei sicuro di voler eliminare questo job?',
            ],
            'messages' => [
                'success' => 'Job eliminato con successo',
            ],
        ],
    ],
    'messages' => [
        'no_jobs' => 'Nessun job presente',
        'job_started' => 'Job avviato',
        'job_stopped' => 'Job fermato',
        'job_completed' => 'Job completato',
        'job_failed' => 'Job fallito',
    ],
    'statuses' => [
        'pending' => 'In Attesa',
        'processing' => 'In Elaborazione',
        'completed' => 'Completato',
        'failed' => 'Fallito',
        'stopped' => 'Fermato',
    ],
    'types' => [
        'import' => 'Importazione',
        'export' => 'Esportazione',
        'process' => 'Elaborazione',
        'notification' => 'Notifica',
        'cleanup' => 'Pulizia',
    ],
];
