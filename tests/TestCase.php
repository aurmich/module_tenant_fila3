<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

/**
 * Base test case for Tenant module tests.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Load Tenant module specific configurations
        $this->loadLaravelMigrations();
<<<<<<< HEAD
<<<<<<< HEAD

=======
        
>>>>>>> fe45b40 (.)
=======
        
>>>>>>> 5192c37 (.)
        // Seed any required data for Tenant tests
        $this->artisan('module:seed', ['module' => 'Tenant']);
    }

    /**
     * Get package providers.
     *
<<<<<<< HEAD
<<<<<<< HEAD
     * @param  \Illuminate\Foundation\Application  $app
=======
     * @param \Illuminate\Foundation\Application $app
>>>>>>> fe45b40 (.)
=======
     * @param \Illuminate\Foundation\Application $app
>>>>>>> 5192c37 (.)
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            \Modules\Tenant\Providers\TenantServiceProvider::class,
        ];
    }
}
