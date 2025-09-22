<?php

declare(strict_types=1);

<<<<<<< HEAD
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;

uses(Tests\TestCase::class);

test('domain model can be instantiated', function (): void {
=======
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
>>>>>>> 1cbc182 (.)
    $domain = new Domain();

    expect($domain)->toBeInstanceOf(Domain::class);
});

<<<<<<< HEAD
test('get rows method works correctly', function (): void {
    // Mock della Action GetDomainsArrayAction
    $mockAction = $this->mock(GetDomainsArrayAction::class);
    $mockAction
        ->shouldReceive('execute')
        ->twice()
=======
it('get rows method works correctly', function () {
    // Mock della Action GetDomainsArrayAction
    $mockAction = Mockery::mock(GetDomainsArrayAction::class);
    $mockAction->shouldReceive('execute')
        ->once()
>>>>>>> 1cbc182 (.)
        ->andReturn([
            ['id' => 1, 'name' => 'test-domain.com'],
            ['id' => 2, 'name' => 'example.org'],
        ]);

<<<<<<< HEAD
    $domain = new Domain();
    $rows = $domain->getRows();

    expect($rows)->toBeArray();
    expect($rows)->toHaveCount(2);
    expect($rows[0]['name'])->toBe('test-domain.com');
    expect($rows[1]['name'])->toBe('example.org');
=======
    $this->app->instance(GetDomainsArrayAction::class, $mockAction);

    $domain = new Domain();
    $rows = $domain->getRows();

    expect($rows)->toBeArray()
        ->toHaveCount(2)
        ->and($rows[0]['name'])->toBe('test-domain.com')
        ->and($rows[1]['name'])->toBe('example.org');
>>>>>>> 1cbc182 (.)
});
