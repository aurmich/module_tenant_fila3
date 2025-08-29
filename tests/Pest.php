<?php

declare(strict_types=1);

use Modules\Tenant\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeTenant', function () {
    return $this->toBeInstanceOf(\Modules\Tenant\Models\Tenant::class);
});

expect()->extend('toBeTenantUser', function () {
    return $this->toBeInstanceOf(\Modules\Tenant\Models\TenantUser::class);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createTenant(array $attributes = []): \Modules\Tenant\Models\Tenant
{
    return \Modules\Tenant\Models\Tenant::factory()->create($attributes);
}

function makeTenant(array $attributes = []): \Modules\Tenant\Models\Tenant
{
    return \Modules\Tenant\Models\Tenant::factory()->make($attributes);
}

function createTenantUser(array $attributes = []): \Modules\Tenant\Models\TenantUser
{
    return \Modules\Tenant\Models\TenantUser::factory()->create($attributes);
}

function makeTenantUser(array $attributes = []): \Modules\Tenant\Models\TenantUser
{
    return \Modules\Tenant\Models\TenantUser::factory()->make($attributes);
}
