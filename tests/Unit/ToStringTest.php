<?php

namespace Sourceboat\Enumeration\Tests\Unit;

use Sourceboat\Enumeration\Tests\TestCase;
use Sourceboat\Enumeration\Tests\UserRole;

class ToStringTest extends TestCase
{
    public function testToString(): void
    {
        $this->assertEquals('moderator', UserRole::MODERATOR()->__toString());
        $this->assertEquals('moderator', (string) UserRole::MODERATOR());
    }
}
