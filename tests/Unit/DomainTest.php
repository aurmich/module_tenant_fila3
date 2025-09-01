<?php

declare(strict_types=1);

use Mockery;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;

uses(\Tests\TestCase::class);

beforeEach(function () {
    // Setup per i test
});

afterEach(function () {
    Mockery::close();
});

it('domain model can be instantiated', function () {
    $domain = new Domain;

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

    $domain = new Domain;
    $rows = $domain->getRows();

    expect($rows)->toBeArray()
        ->toHaveCount(2)
        ->and($rows[0]['name'])->toBe('test-domain.com')
        ->and($rows[1]['name'])->toBe('example.org');
});
