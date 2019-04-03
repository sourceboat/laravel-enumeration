<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Rules\EnumerationValue;

class EnumerationValueMethodsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->rule = new EnumerationValue(UserRole::class, UserRole::membersByBlacklist([UserRole::ADMIN()]));
        $this->rule2 = new EnumerationValue(TestEnum2::class);
    }

    public function testPasses(): void
    {
        $this->assertTrue($this->rule->passes(null, UserRole::MODERATOR()->value()));
        $this->assertFalse($this->rule->passes(null, UserRole::ADMIN()->value()));
        $this->assertTrue($this->rule->passes(null, UserRole::SUPER_ADMIN()->value()));
        $this->assertTrue($this->rule->passes(null, UserRole::USER()->value()));
        $this->assertFalse($this->rule->passes(null, 'reporter'));
        $this->assertFalse($this->rule->passes(null, 5));

        $this->assertTrue($this->rule2->passes(null, TestEnum2::TEST1()->value()));
        $this->assertTrue($this->rule2->passes(null, TestEnum2::TEST2()->value()));
        $this->assertTrue($this->rule2->passes(null, TestEnum2::TEST3()->value()));
        $this->assertTrue($this->rule2->passes(null, TestEnum2::TEST4()->value()));
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
