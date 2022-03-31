<?php

namespace Sourceboat\Enumeration\Tests\Unit;

use Sourceboat\Enumeration\Exceptions\UndefinedMemberException;
use Sourceboat\Enumeration\Tests\TestCase;
use Sourceboat\Enumeration\Tests\UserRole;

class IsEnumKeyTest extends TestCase
{
    /**
     * Data provider for the test `testIsEnumKey`.
     *
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        return [
            [ UserRole::USER(), 'isUser', true ],
            [ UserRole::USER(), 'isUSER', true ],
            [ UserRole::USER(), 'isuser', true ],
            [ UserRole::USER(), 'isUSer', true ],
            [ UserRole::MODERATOR(), 'isUser', false ],
        ];
    }

    /**
     * Test functionality of is<EnumKey> helper.
     *
     * @dataProvider dataProvider
     * @param \Sourceboat\Enumeration\Tests\UserRole $role
     * @param string $method
     * @param bool $result
     * @return void
     */
    public function testIsEnumKey(UserRole $role, string $method, bool $result): void
    {
        $this->assertEquals($result, $role->{$method}());
    }

    /**
     * Test functionality of is<EnumKey> helper.
     *
     * @return void
     */
    public function testIsEnumKeyException(): void
    {
        $this->expectException(UndefinedMemberException::class);
        UserRole::USER()->isStudent();
    }
}
