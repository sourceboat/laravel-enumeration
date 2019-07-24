<?php

namespace Sourceboat\Enumeration\Tests;

class IsTest extends TestCase
{
    /**
     * Check that the is helper functions correctly.
     *
     * @return void
     */
    public function testGetCorrectResults(): void
    {
        $this->assertTrue(UserRole::MODERATOR()->is(UserRole::MODERATOR()));
        $this->assertFalse(UserRole::MODERATOR()->is(UserRole::ADMIN()));
        $this->assertFalse(UserRole::MODERATOR()->is('moderator'));
    }
}
