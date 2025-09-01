<?php

declare(strict_types=1);

<<<<<<< HEAD
<<<<<<< HEAD
use Mockery;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
=======
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Mockery;
>>>>>>> fe45b40 (.)
=======
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Mockery;
>>>>>>> 5192c37 (.)

uses(\Tests\TestCase::class);

beforeEach(function () {
    // Setup per i test
});

afterEach(function () {
    Mockery::close();
});

it('domain model can be instantiated', function () {
<<<<<<< HEAD
<<<<<<< HEAD
    $domain = new Domain;

=======
    $domain = new Domain();
    
>>>>>>> fe45b40 (.)
=======
    $domain = new Domain();
    
>>>>>>> 5192c37 (.)
    expect($domain)->toBeInstanceOf(Domain::class);
});

it('get rows method works correctly', function () {
    // Mock della Action GetDomainsArrayAction
    $mockAction = Mockery::mock(GetDomainsArrayAction::class);
    $mockAction->shouldReceive('execute')
        ->once()
        ->andReturn([
            ['id' => 1, 'name' => 'test-domain.com'],
            ['id' => 2, 'name' => 'example.org'],
        ]);

    $this->app->instance(GetDomainsArrayAction::class, $mockAction);

<<<<<<< HEAD
<<<<<<< HEAD
    $domain = new Domain;
=======
    $domain = new Domain();
>>>>>>> fe45b40 (.)
=======
    $domain = new Domain();
>>>>>>> 5192c37 (.)
    $rows = $domain->getRows();

    expect($rows)->toBeArray()
        ->toHaveCount(2)
        ->and($rows[0]['name'])->toBe('test-domain.com')
        ->and($rows[1]['name'])->toBe('example.org');
});
