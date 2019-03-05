<?php

namespace Sourceboat\Enumeration\Tests;

class GetMembersByBlacklistTest extends TestCase
{
    /**
     * Check the membersByBlacklist functionality.
     *
     * @return void
     */
    public function testGetMembersByEmptyBlacklist(): void
    {
        $this->assertEquals(TestEnum::members(), TestEnum::membersByBlacklist());
    }

    /**
     * Check the membersByBlacklist functionality.
     *
     * @return void
     */
    public function testGetMembersByBlacklist(): void
    {
        $this->assertEquals([
            TestEnum::TEST1()->key() => TestEnum::TEST1(),
            TestEnum::TEST2()->key() => TestEnum::TEST2(),
            TestEnum::TEST3()->key() => TestEnum::TEST3(),
        ], TestEnum::membersByBlacklist([TestEnum::TEST4()]));
    }
}
