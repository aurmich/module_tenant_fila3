<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

/**
 * Class CreateTeamUserTableTest.
 *
 * @covers \CreateTeamUserTable
 */
final class CreateTeamUserTableTest extends TestCase
{
    private \CreateTeamUserTable $createTeamUserTable;

    protected function setUp(): void
    {
        parent::setUp();

        /* @todo Correctly instantiate tested object to use it. */
        $this->createTeamUserTable = new \CreateTeamUserTable();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->createTeamUserTable);
    }

    public function testUp(): void
    {
        /* @todo This test is incomplete. */
        self::markTestIncomplete();
    }
}
