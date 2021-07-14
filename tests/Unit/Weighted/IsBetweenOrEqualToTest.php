<?php

namespace Sourceboat\Enumeration\Tests\Unit\Weighted;

use Sourceboat\Enumeration\Tests\TestCase;

class IsBetweenOrEqualToTest extends TestCase
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
     * Data provider for the test `testIsBetweenOrEqualTo`.
     *
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        return [
            [ FruitType::BERRY(), FruitType::ACCESSORY_FRUIT(), FruitType::NUT(), false ],
            [ FruitType::BERRY(), FruitType::ACCESSORY_FRUIT(), FruitType::BERRY(), true ],
            [ FruitType::BERRY(), FruitType::ACCESSORY_FRUIT(), FruitType::LEGUME(), true ],
            [ FruitType::BERRY(), FruitType::ACCESSORY_FRUIT(), FruitType::ACCESSORY_FRUIT(), true ],
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
    public function testIsBetweenOrEqualTo(FruitType $lower, FruitType $higher, FruitType $needle, bool $result): void
    {
        $this->assertEquals($result, $needle->isBetweenOrEqualTo($lower, $higher));
    }
}
