<?php

<<<<<<< HEAD
<<<<<<< HEAD
declare(strict_types=1);

use Modules\Tenant\Models\Domain;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Mockery;
=======
declare(strict_types=1);

use Mockery;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
>>>>>>> 1cbc182 (.)

uses(\Tests\TestCase::class);

beforeEach(function () {
    // Setup per i test
});

afterEach(function () {
    Mockery::close();
});

it('domain model can be instantiated', function () {
    $domain = new Domain();
<<<<<<< HEAD
    
=======

>>>>>>> 1cbc182 (.)
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
=======
<<<<<<< HEAD
declare(strict_types=1);
=======
namespace Modules\Tenant\Tests\Unit;
>>>>>>> 5a2ca30 (.)

use Modules\Tenant\Models\Domain;

uses(Tests\TestCase::class);

test('domain model can be instantiated', function (): void {
    $domain = new Domain();

    expect($domain)->toBeInstanceOf(Domain::class);
});

test('get rows method works correctly', function (): void {
    // Mock della Action GetDomainsArrayAction
    $this->mock(\Modules\Tenant\Actions\Domains\GetDomainsArrayAction::class, function ($mock) {
        $mock->shouldReceive('execute')
            ->once()
            ->andReturn([
                ['id' => 1, 'name' => 'test-domain.com'],
                ['id' => 2, 'name' => 'example.org'],
            ]);
    });
>>>>>>> 40aab39 (.)
=======
>>>>>>> 1cbc182 (.)

    $domain = new Domain();
    $rows = $domain->getRows();

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1cbc182 (.)
    expect($rows)->toBeArray()
        ->toHaveCount(2)
        ->and($rows[0]['name'])->toBe('test-domain.com')
        ->and($rows[1]['name'])->toBe('example.org');
<<<<<<< HEAD
=======
    expect($rows)->toBeArray();
    expect($rows)->toHaveCount(2);
    expect($rows[0]['name'])->toBe('test-domain.com');
    expect($rows[1]['name'])->toBe('example.org');
>>>>>>> 40aab39 (.)
=======
>>>>>>> 1cbc182 (.)
});
