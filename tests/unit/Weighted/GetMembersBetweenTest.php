<?php

namespace Sourceboat\Enumeration\Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

class GetMembersBetweenTest extends TestCase
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
     * Data provider for the test `testGetMembersBetween`.
     *
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        return [
            [
                FruitType::NUT(),
                FruitType::NUT(),
                [],
            ],
            [
                FruitType::NUT(),
                FruitType::BERRY(),
                [],
            ],
            [
                FruitType::NUT(),
                FruitType::LEGUME(),
                [
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                ],
            ],
            [
                FruitType::NUT(),
                FruitType::ACCESSORY_FRUIT(),
                [
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                    Str::upper(FruitType::LEGUME) => FruitType::LEGUME(),
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
    public function testGetMembersBetween(FruitType $lower, FruitType $higher, array $result): void
    {
        $this->assertEquals($result, FruitType::getMembersBetween($lower, $higher));
        $this->assertEquals($result, $lower->getMembersBetweenThisAnd($higher));
    }
}
