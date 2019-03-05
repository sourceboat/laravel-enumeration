<?php

namespace Sourceboat\Enumeration\Tests;

class GetRuleTest extends TestCase
{
    /**
     * Check the makeRule functionality.
     *
     * @return void
     */
    public function testMakeRule(): void
    {
        $rule = TestEnum::makeRule();

        $this->assertTrue($rule->passes(null, TestEnum::TEST1()->value()));
        $this->assertTrue($rule->passes(null, TestEnum::TEST2()->value()));
        $this->assertTrue($rule->passes(null, TestEnum::TEST3()->value()));
        $this->assertTrue($rule->passes(null, TestEnum::TEST4()->value()));
        $this->assertFalse($rule->passes(null, 'test'));
        $this->assertFalse($rule->passes(null, 5));
    }

    /**
     * Check the makeRuleWithWhitelist functionality.
     *
     * @return void
     */
    public function testMakeRuleWithWhitelist(): void
    {
        $rule = TestEnum::makeRuleWithWhitelist([TestEnum::TEST1()]);

        $this->assertTrue($rule->passes(null, TestEnum::TEST1()->value()));
        $this->assertFalse($rule->passes(null, TestEnum::TEST2()->value()));
        $this->assertFalse($rule->passes(null, TestEnum::TEST3()->value()));
        $this->assertFalse($rule->passes(null, TestEnum::TEST4()->value()));
        $this->assertFalse($rule->passes(null, 'test'));
        $this->assertFalse($rule->passes(null, 5));
    }

    /**
     * Check the makeRuleWithBlacklist functionality.
     *
     * @return void
     */
    public function testMakeRuleWithBlacklist(): void
    {
        $rule = TestEnum::makeRuleWithBlacklist([TestEnum::TEST1()]);

        $this->assertFalse($rule->passes(null, TestEnum::TEST1()->value()));
        $this->assertTrue($rule->passes(null, TestEnum::TEST2()->value()));
        $this->assertTrue($rule->passes(null, TestEnum::TEST3()->value()));
        $this->assertTrue($rule->passes(null, TestEnum::TEST4()->value()));
        $this->assertFalse($rule->passes(null, 'test'));
        $this->assertFalse($rule->passes(null, 5));
    }
}
