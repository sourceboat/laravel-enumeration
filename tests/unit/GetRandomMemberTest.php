<?php

namespace Sourceboat\Enumeration\Tests;

class GetRandomMemberTest extends TestCase
{
    /**
     * Check the randomMember functionality.
     *
     * @return void
     */
    public function testGetRandomMember(): void
    {
        $this->assertTrue(UserRole::randomMember()->anyOfArray(UserRole::members()));
    }

    /**
     * Check the randomMember blacklist functionality.
     *
     * @return void
     */
    public function testGetRandomMemberWithBlacklist(): void
    {
        $this->assertEquals(
            UserRole::randomMember(UserRole::membersByBlacklist([UserRole::SUPER_ADMIN()])),
            UserRole::SUPER_ADMIN(),
        );
    }
}
