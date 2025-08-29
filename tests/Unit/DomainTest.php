<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Tests\TestCase;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
<<<<<<< HEAD
use Mockery;

uses(\Tests\TestCase::class);

beforeEach(function () {
    // Setup per i test
});

afterEach(function () {
    Mockery::close();
});

it('domain model can be instantiated', function () {
    $domain = new Domain();
    
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
=======
use PHPUnit\Framework\Attributes\Test;
use Mockery;

class DomainTest extends TestCase
{
    #[Test]
    public function domain_model_can_be_instantiated(): void
    {
        $domain = new Domain();

        expect($domain)->toBeInstanceOf(Domain::class);
    }

    #[Test]
    public function get_rows_method_works_correctly(): void
    {
        // Mock della Action GetDomainsArrayAction
        $mockAction = Mockery::mock(GetDomainsArrayAction::class);
        $mockAction->shouldReceive('execute')
            ->once()
            ->andReturn([
                ['id' => 1, 'name' => 'test-domain.com'],
                ['id' => 2, 'name' => 'example.org'],
            ]);
>>>>>>> 1d8e6b9 (.)

        $this->app->instance(GetDomainsArrayAction::class, $mockAction);

<<<<<<< HEAD
    expect($rows)->toBeArray()
        ->toHaveCount(2)
        ->and($rows[0]['name'])->toBe('test-domain.com')
        ->and($rows[1]['name'])->toBe('example.org');
});
=======
        $domain = new Domain();
        $rows = $domain->getRows();

        expect($rows)->toBeArray();
        expect($rows)->toHaveCount(2);
        expect($rows[0]['name'])->toBe('test-domain.com');
        expect($rows[1]['name'])->toBe('example.org');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
>>>>>>> 1d8e6b9 (.)
