<?php

return [
    'tenant_model' => \Modules\Tenant\Models\Tenant::class,
    'id_generator' => \Modules\Tenant\TenantIdGenerator::class,
    'domain_model' => \Modules\Tenant\Models\Domain::class,
    'central_domains' => [
        '127.0.0.1',
        'localhost',
        env('APP_DOMAIN', 'saluteora.local'),
    ],
    'database' => [
        'central_connection' => env('DB_CONNECTION', 'mysql'),
        'template_tenant_connection' => null,
    ],
    'cache' => [
        'tag_base' => 'tenant',
    ],
    'filesystem' => [
        'suffix_base' => 'tenant',
        // Disks which should be suffixed with a tenant id
        'disks' => [
            'local',
            'public',
            // 's3',
        ],
        'root_override' => [
            // Disks whose roots should be overriden after storage_path() is suffixed
            'local' => '%storage_path%/app/',
            'public' => '%storage_path%/app/public/',
        ],
    ],
    'queue' => [
        'tag_base' => 'tenant',
    ],
]; 