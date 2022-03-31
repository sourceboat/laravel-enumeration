<?php

namespace Sourceboat\Enumeration\Tests\Unit\Weighted;

use Illuminate\Support\Str;
use Sourceboat\Enumeration\Tests\FruitType;
use Sourceboat\Enumeration\Tests\TestCase;

class GetMembersBetweenOrEqualToTest extends TestCase
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
     * Data provider for the test `testGetMembersBetweenOrEqualTo`.
     *
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        return [
            [
                FruitType::NUT(),
                FruitType::NUT(),
                [
                    Str::upper(FruitType::NUT) => FruitType::NUT(),
                ],
            ],
            [
                FruitType::NUT(),
                FruitType::BERRY(),
                [
                    Str::upper(FruitType::NUT) => FruitType::NUT(),
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                ],
            ],
            [
                FruitType::NUT(),
                FruitType::LEGUME(),
                [
                    Str::upper(FruitType::NUT) => FruitType::NUT(),
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                    Str::upper(FruitType::LEGUME) => FruitType::LEGUME(),
                ],
            ],
            [
                FruitType::NUT(),
                FruitType::ACCESSORY_FRUIT(),
                [
                    Str::upper(FruitType::NUT) => FruitType::NUT(),
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                    Str::upper(FruitType::LEGUME) => FruitType::LEGUME(),
                    Str::upper(FruitType::ACCESSORY_FRUIT) => FruitType::ACCESSORY_FRUIT(),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param \Sourceboat\Enumeration\Tests\FruitType $lower
     * @param \Sourceboat\Enumeration\Tests\FruitType $higher
     * @param array<mixed> $result
     * @return void
     */
    public function testGetMembersBetweenOrEqualTo(FruitType $lower, FruitType $higher, array $result): void
    {
        $this->assertEquals($result, FruitType::getMembersBetweenOrEqualTo($lower, $higher));
        $this->assertEquals($result, $lower->getMembersBetweenOrEqualToThisAnd($higher));
    }
}
