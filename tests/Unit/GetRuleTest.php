<?php

namespace Sourceboat\Enumeration\Tests\Unit;

use Sourceboat\Enumeration\Tests\TestCase;
use Sourceboat\Enumeration\Tests\UserRole;

class GetRuleTest extends TestCase
{
    /**
     * Check the makeRule functionality.
     *
     * @return void
     */
    public function testMakeRule(): void
    {
        $rule = UserRole::makeRule();

        $this->assertTrue($rule->passes(null, UserRole::MODERATOR()->value()));
        $this->assertTrue($rule->passes(null, UserRole::ADMIN()->value()));
        $this->assertTrue($rule->passes(null, UserRole::SUPER_ADMIN()->value()));
        $this->assertTrue($rule->passes(null, UserRole::USER()->value()));
        $this->assertFalse($rule->passes(null, 'moderato'));
        $this->assertFalse($rule->passes(null, 5));
    }

    /**
     * Check the makeRuleWithWhitelist functionality.
     *
     * @return void
     */
    public function testMakeRuleWithWhitelist(): void
    {
        $rule = UserRole::makeRuleWithWhitelist([UserRole::MODERATOR()]);

        $this->assertTrue($rule->passes(null, UserRole::MODERATOR()->value()));
        $this->assertFalse($rule->passes(null, UserRole::ADMIN()->value()));
        $this->assertFalse($rule->passes(null, UserRole::SUPER_ADMIN()->value()));
        $this->assertFalse($rule->passes(null, UserRole::USER()->value()));
        $this->assertFalse($rule->passes(null, 'moderato'));
        $this->assertFalse($rule->passes(null, 5));
    }

    /**
     * Check the makeRuleWithBlacklist functionality.
     *
     * @return void
     */
    public function testMakeRuleWithBlacklist(): void
    {
        $rule = UserRole::makeRuleWithBlacklist([UserRole::MODERATOR()]);

        $this->assertFalse($rule->passes(null, UserRole::MODERATOR()->value()));
        $this->assertTrue($rule->passes(null, UserRole::ADMIN()->value()));
        $this->assertTrue($rule->passes(null, UserRole::SUPER_ADMIN()->value()));
        $this->assertTrue($rule->passes(null, UserRole::USER()->value()));
        $this->assertFalse($rule->passes(null, 'moderato'));
        $this->assertFalse($rule->passes(null, 5));
    }
}
