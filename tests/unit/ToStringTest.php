<?php

namespace Sourceboat\Enumeration\Tests;

class ToStringTest extends TestCase
{
    public function testToString(): void
    {
        $this->assertEquals('moderator', UserRole::MODERATOR()->__toString());
        $this->assertEquals('moderator', (string) UserRole::MODERATOR());
    }
}
