<?php

namespace Modules\User\Tests\Unit\Models\Traits;

use Modules\User\Models\Traits\IsTenants;
use Tests\TestCase;

/**
 * Class IsTenantsTest.
 *
 * @covers \Modules\User\Models\Traits\IsTenants
 */
final class IsTenantsTest extends TestCase
{
    private IsTenants $isTenants;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->isTenants = $this->getMockBuilder(IsTenants::class)
            ->setConstructorArgs([])
            ->getMockForTrait();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->isTenants);
    }

    public function testUsers(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
