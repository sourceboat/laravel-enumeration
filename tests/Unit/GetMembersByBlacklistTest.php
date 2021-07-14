<?php

namespace Sourceboat\Enumeration\Tests\Unit;

use Sourceboat\Enumeration\Tests\TestCase;
use Sourceboat\Enumeration\Tests\UserRole;

class GetMembersByBlacklistTest extends TestCase
{
    /**
     * Check the membersByBlacklist functionality.
     *
     * @return void
     */
    public function testGetMembersByEmptyBlacklist(): void
    {
        $this->assertEquals(UserRole::members(), UserRole::membersByBlacklist());
    }

    /**
     * Check the membersByBlacklist functionality.
     *
     * @return void
     */
    public function testGetMembersByBlacklist(): void
    {
        $this->assertEquals([
            UserRole::MODERATOR()->key() => UserRole::MODERATOR(),
            UserRole::ADMIN()->key() => UserRole::ADMIN(),
            UserRole::SUPER_ADMIN()->key() => UserRole::SUPER_ADMIN(),
        ], UserRole::membersByBlacklist([UserRole::USER()]));
    }
}
