<?php

namespace Sourceboat\Enumeration\Tests;

use Orchestra\Testbench\TestCase;

class IsBetweenTest extends TestCase
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
     * Data provider for the test `testIsBetween`.
     *
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [ FruitType::NUT(), FruitType::ACCESSORY_FRUIT(), FruitType::NUT(), false ],
            [ FruitType::NUT(), FruitType::ACCESSORY_FRUIT(), FruitType::BERRY(), true ],
            [ FruitType::NUT(), FruitType::ACCESSORY_FRUIT(), FruitType::ACCESSORY_FRUIT(), false ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param \Sourceboat\Enumeration\Tests\FruitType $lower
     * @param \Sourceboat\Enumeration\Tests\FruitType $higher
     * @param \Sourceboat\Enumeration\Tests\FruitType $needle
     * @param bool $result
     * @return void
     */
    public function testIsBetween(FruitType $lower, FruitType $higher, FruitType $needle, bool $result): void
    {
        $this->assertEquals($result, $needle->isBetween($lower, $higher));
    }
}
