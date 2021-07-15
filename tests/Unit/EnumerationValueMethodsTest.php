<?php

namespace Sourceboat\Enumeration\Tests\Unit;

use Sourceboat\Enumeration\Rules\EnumerationValue;
use Sourceboat\Enumeration\Tests\FruitType;
use Sourceboat\Enumeration\Tests\TestCase;
use Sourceboat\Enumeration\Tests\UserRole;

class EnumerationValueMethodsTest extends TestCase
{
    /** @var array<\Sourceboat\Enumeration\Rules\EnumerationValue> */
    private static $rules;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$rules = [
            'role' => new EnumerationValue(UserRole::class, UserRole::membersByBlacklist([UserRole::ADMIN()])),
            'fruit' => new EnumerationValue(FruitType::class),
        ];
    }

    /** @return array<array<mixed>> */
    public function passesDataprovider(): array
    {
        return [
            ['role', UserRole::MODERATOR()->value(), true],
            ['role', UserRole::ADMIN()->value(), false],
            ['role', UserRole::SUPER_ADMIN()->value(), true],
            ['role', UserRole::USER()->value(), true],
            ['role', 'reporter', false],
            ['role', 5, false],

            ['fruit', FruitType::BERRY()->value(), true],
            ['fruit', FruitType::NUT()->value(), true],
            ['fruit', FruitType::LEGUME()->value(), true],
            ['fruit', FruitType::ACCESSORY_FRUIT()->value(), true],
            ['fruit', 'test', false],
            ['fruit', 5, false],
        ];
    }

    /**
     * @dataProvider passesDataProvider
     * @param string $ruleKey
     * @param string|int $value
     * @param bool $expectation
     * @return void
     */
    public function testPasses(string $ruleKey, $value, bool $expectation): void
    {
        $this->assertEquals($expectation, self::$rules[$ruleKey]->passes(null, $value));
    }

    public function testMessage(): void
    {
        $this->assertEquals('The given value is not suitable for :attribute.', self::$rules['role']->message());
    }

    /** @return array<array<mixed>> */
    public function sensitivityDataProvider(): array
    {
        return [
            ['moderator', false, true],
            ['ModerATor', false, true],
            ['moderator', true, true],
            ['ModerATor', true, false],
        ];
    }

    /**
     * @dataProvider sensitivityDataProvider
     * @param string $value
     * @param bool $caseSensitivity
     * @param bool $expectation
     * @return void
     */
    public function testSetCaseSensitivity(string $value, bool $caseSensitivity, bool $expectation): void
    {
        self::$rules['role']->setCaseSensitivity($caseSensitivity);
        $this->assertEquals($expectation, self::$rules['role']->passes(null, $value));
    }
}
