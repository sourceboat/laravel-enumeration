<?php

namespace Sourceboat\Enumeration\Tests\Unit\Weighted;

use Illuminate\Support\Str;
use Sourceboat\Enumeration\Tests\FruitType;
use Sourceboat\Enumeration\Tests\TestCase;

class GetMembersLessThanTest extends TestCase
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
            [
                FruitType::NUT(),
                [],
            ],
            [
                FruitType::BERRY(),
                [
                    Str::upper(FruitType::NUT) => FruitType::NUT(),
                ],
            ],
            [
                FruitType::LEGUME(),
                [
                    Str::upper(FruitType::NUT) => FruitType::NUT(),
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                ],
            ],
            [
                FruitType::ACCESSORY_FRUIT(),
                [
                    Str::upper(FruitType::NUT) => FruitType::NUT(),
                    Str::upper(FruitType::BERRY) => FruitType::BERRY(),
                    Str::upper(FruitType::LEGUME) => FruitType::LEGUME(),
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param \Sourceboat\Enumeration\Tests\FruitType $member
     * @param array<mixed> $result
     * @return void
     */
    public function testGetMembersLessThan(FruitType $member, array $result): void
    {
        $this->assertEquals($result, FruitType::getMembersLessThan($member));
        $this->assertEquals($result, $member->getMembersLessThanThis());
    }
}
