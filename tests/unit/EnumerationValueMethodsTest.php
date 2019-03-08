<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Rules\EnumerationValue;

class EnumerationValueMethodsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->rule = new EnumerationValue(TestEnum::class, TestEnum::membersByBlacklist([TestEnum::TEST2()]));
        $this->rule2 = new EnumerationValue(TestEnum2::class);
    }

    public function testPasses(): void
    {
        $this->assertTrue($this->rule->passes(null, TestEnum::TEST1()->value()));
        $this->assertFalse($this->rule->passes(null, TestEnum::TEST2()->value()));
        $this->assertTrue($this->rule->passes(null, TestEnum::TEST3()->value()));
        $this->assertTrue($this->rule->passes(null, TestEnum::TEST4()->value()));
        $this->assertFalse($this->rule->passes(null, 'test'));
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
        $this->assertTrue($this->rule->passes(null, 'test_1'));
        $this->assertTrue($this->rule->passes(null, 'TeSt_1'));

        $this->rule->setCaseSensitivity(true);

        $this->assertTrue($this->rule->passes(null, 'test_1'));
        $this->assertFalse($this->rule->passes(null, 'TeSt_1'));
    }
}
