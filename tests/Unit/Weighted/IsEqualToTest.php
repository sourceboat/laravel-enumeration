<?php

namespace Sourceboat\Enumeration\Tests\Unit\Weighted;

use Sourceboat\Enumeration\Tests\TestCase;

class IsEqualToTest extends TestCase
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
     * Data provider for the test `testIsGreaterThan`.
     *
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        return [
            [ FruitType::NUT(), FruitType::NUT(), true ],
            [ FruitType::NUT(), FruitType::BERRY(), false ],
            [ FruitType::NUT(), FruitType::LEGUME(), false ],
            [ FruitType::NUT(), FruitType::ACCESSORY_FRUIT(), false ],
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
    public function testIsGreaterThanOrEqualTo(FruitType $first, FruitType $second, bool $result): void
    {
        $this->assertEquals($result, $first->isEqualTo($second));
    }
}
