<?php

namespace Sourceboat\Enumeration\Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

class GetMembersGreaterThanOrEqualToTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();

        config([
            'enums' => [
                FruitType::class => [
                    'weights' => [
                        FruitType::NUT => 1,
                        FruitType::BERRY => 2,
                        FruitType::LEGUME => 3,
                        FruitType::ACCESSORY_FRUIT => 4,
                    ],
                ],
            ],
        ]);
    }

    /**
     * Data provider for the test `testIsGreaterThanOrEqualTo`.
     *
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                FruitType::NUT(),
                [
                    Str::upper(FruitType::NUT) => FruitType::NUT(),
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                    Str::upper(FruitType::LEGUME) => FruitType::LEGUME(),
                    Str::upper(FruitType::ACCESSORY_FRUIT) => FruitType::ACCESSORY_FRUIT(),
                ],
            ],
            [
                FruitType::BERRY(),
                [
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                    Str::upper(FruitType::LEGUME) => FruitType::LEGUME(),
                    Str::upper(FruitType::ACCESSORY_FRUIT) => FruitType::ACCESSORY_FRUIT(),
                ],
            ],
            [
                FruitType::LEGUME(),
                [
                    Str::upper(FruitType::LEGUME) => FruitType::LEGUME(),
                    Str::upper(FruitType::ACCESSORY_FRUIT) => FruitType::ACCESSORY_FRUIT(),
                ],
            ],
            [
                FruitType::ACCESSORY_FRUIT(),
                [
                    Str::upper(FruitType::ACCESSORY_FRUIT) => FruitType::ACCESSORY_FRUIT(),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param \Sourceboat\Enumeration\Tests\FruitType $member
     * @param array $result
     * @return void
     */
    public function testGetMembersGreaterThanOrEqualTo(FruitType $member, array $result): void
    {
        $this->assertEquals($result, FruitType::getMembersGreaterThanOrEqualTo($member));
        $this->assertEquals($result, $member->getMembersGreaterThanOrEqualToThis());
    }
}