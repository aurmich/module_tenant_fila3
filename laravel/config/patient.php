<?php

return [
    'name' => 'Patient',
    'description' => 'Gestione dei pazienti',
    'models' => [
        'patient' => \Modules\Patient\Models\Patient::class,
        'document' => \Modules\Patient\Models\Document::class,
        'anamnesis' => \Modules\Patient\Models\Anamnesis::class,
    ],
    'resources' => [
        'patient' => \Modules\Patient\Filament\Resources\PatientResource::class,
        'document' => \Modules\Patient\Filament\Resources\DocumentResource::class,
        'anamnesis' => \Modules\Patient\Filament\Resources\AnamnesisResource::class,
    ],
    'routes' => [
        'web' => [
            'prefix' => 'patient',
            'middleware' => ['web', 'auth', 'role:doctor|admin'],
        ],
        'api' => [
            'prefix' => 'api/v1/patient',
            'middleware' => ['api', 'auth:sanctum'],
        ],
    ],
    'notifications' => [
        'appointment_reminder' => [
            'enabled' => true,
            'template' => 'patient::notifications.appointment_reminder',
        ],
        'document_expiry' => [
            'enabled' => true,
            'template' => 'patient::notifications.document_expiry',
        ],
        'isee_update' => [
            'enabled' => true,
            'template' => 'patient::notifications.isee_update',
        ],
    ],
    'filesystem' => [
        'disk' => 'public',
        'path' => 'patients',
    ],
]; 