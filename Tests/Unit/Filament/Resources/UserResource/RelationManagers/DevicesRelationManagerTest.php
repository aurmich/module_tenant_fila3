<?php

namespace Modules\User\Filament\Resources\Tests\Unit\UserResource\RelationManagers;

use Modules\User\Filament\Resources\UserResource\RelationManagers\DevicesRelationManager;
use Tests\TestCase;

/**
 * Class DevicesRelationManagerTest.
 *
 * @covers \Modules\User\Filament\Resources\UserResource\RelationManagers\DevicesRelationManager
 */
final class DevicesRelationManagerTest extends TestCase
{
    private DevicesRelationManager $devicesRelationManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->devicesRelationManager = new DevicesRelationManager();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->devicesRelationManager);
    }

    public function testForm(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testExtendTableCallback(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }

    public function testTable(): void
    {
        /** @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
