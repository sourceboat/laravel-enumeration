<?php

namespace Sourceboat\Enumeration\Tests\Unit\Weighted;

use Sourceboat\Enumeration\Tests\FruitType;
use Sourceboat\Enumeration\Tests\TestCase;

class IsLessThanOrEqualToTest extends TestCase
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
     * Data provider for the test `testIsLessThan`.
     *
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        return [
            [ FruitType::NUT(), FruitType::NUT(), true ],
            [ FruitType::NUT(), FruitType::BERRY(), true ],
            [ FruitType::NUT(), FruitType::LEGUME(), true ],
            [ FruitType::NUT(), FruitType::ACCESSORY_FRUIT(), true ],
            [ FruitType::ACCESSORY_FRUIT(), FruitType::NUT(), false ],
            [ FruitType::ACCESSORY_FRUIT(), FruitType::BERRY(), false ],
            [ FruitType::ACCESSORY_FRUIT(), FruitType::LEGUME(), false ],
            [ FruitType::ACCESSORY_FRUIT(), FruitType::ACCESSORY_FRUIT(), true ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param \Sourceboat\Enumeration\Tests\FruitType $first
     * @param \Sourceboat\Enumeration\Tests\FruitType $second
     * @param bool $result
     * @return void
     */
    public function testIsLessThanOrEqualTo(FruitType $first, FruitType $second, bool $result): void
    {
        $this->assertEquals($result, $first->isLessThanOrEqualTo($second));
    }
}
