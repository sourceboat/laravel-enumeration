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
        $this->assertTrue(TestEnum::randomMember()->anyOfArray(TestEnum::members()));
    }

    /**
     * Check the randomMember blacklist functionality.
     *
     * @return void
     */
    public function testGetRandomMemberWithBlacklist(): void
    {
        $this->assertEquals(
            TestEnum::randomMember(TestEnum::membersByBlacklist([TestEnum::TEST3()])),
            TestEnum::TEST3()
        );
    }
}
