<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\Models\Domain;

class DomainsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domains = [
            [
<<<<<<< HEAD
                'domain' => 'saluteora.localhost',
=======
                'domain' => 'techplanner.localhost',
>>>>>>> 01b26b3 (.)
                'is_primary' => true,
                'is_ssl_enabled' => false,
                'is_active' => true,
            ],
            [
<<<<<<< HEAD
                'domain' => 'salutemo.localhost',
=======
                'domain' => 'example.localhost',
>>>>>>> 01b26b3 (.)
                'is_primary' => false,
                'is_ssl_enabled' => false,
                'is_active' => true,
            ],
            [
<<<<<<< HEAD
                'domain' => 'demo.saluteora.it',
=======
                'domain' => 'demo.techplanner.it',
>>>>>>> 01b26b3 (.)
                'is_primary' => false,
                'is_ssl_enabled' => true,
                'is_active' => false,
            ],
        ];

        foreach ($domains as $domainData) {
            Domain::factory()->create($domainData);
        }

        // Create additional random domains for development
        if (app()->environment(['local', 'development'])) {
            Domain::factory()
                ->count(5)
                ->create();
        }
    }
}