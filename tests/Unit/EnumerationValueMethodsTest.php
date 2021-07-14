<?php

namespace Sourceboat\Enumeration\Tests\Unit;

use Sourceboat\Enumeration\Rules\EnumerationValue;
use Sourceboat\Enumeration\Tests\FruitType;
use Sourceboat\Enumeration\Tests\TestCase;
use Sourceboat\Enumeration\Tests\UserRole;

class EnumerationValueMethodsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->rule = new EnumerationValue(UserRole::class, UserRole::membersByBlacklist([UserRole::ADMIN()]));
        $this->rule2 = new EnumerationValue(FruitType::class);
    }

    public function testPasses(): void
    {
        $this->assertTrue($this->rule->passes(null, UserRole::MODERATOR()->value()));
        $this->assertFalse($this->rule->passes(null, UserRole::ADMIN()->value()));
        $this->assertTrue($this->rule->passes(null, UserRole::SUPER_ADMIN()->value()));
        $this->assertTrue($this->rule->passes(null, UserRole::USER()->value()));
        $this->assertFalse($this->rule->passes(null, 'reporter'));
        $this->assertFalse($this->rule->passes(null, 5));

        $this->assertTrue($this->rule2->passes(null, FruitType::BERRY()->value()));
        $this->assertTrue($this->rule2->passes(null, FruitType::NUT()->value()));
        $this->assertTrue($this->rule2->passes(null, FruitType::ACCESSORY_FRUIT()->value()));
        $this->assertTrue($this->rule2->passes(null, FruitType::LEGUME()->value()));
        $this->assertFalse($this->rule2->passes(null, 'test'));
        $this->assertFalse($this->rule2->passes(null, 5));
    }

    public function testMessage(): void
    {
        $this->assertEquals('The given value is not suitable for :attribute.', $this->rule->message());
    }

    public function testSetCaseSensitivity(): void
    {
        $this->assertTrue($this->rule->passes(null, 'moderator'));
        $this->assertTrue($this->rule->passes(null, 'ModerATor'));

        $this->rule->setCaseSensitivity(true);

        $this->assertTrue($this->rule->passes(null, 'moderator'));
        $this->assertFalse($this->rule->passes(null, 'ModerATor'));
    }
}
