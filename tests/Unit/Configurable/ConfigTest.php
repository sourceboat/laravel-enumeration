<?php

namespace Sourceboat\Enumeration\Tests\Unit\Configurable;

use Sourceboat\Enumeration\Tests\ConfigurableEnum;
use Sourceboat\Enumeration\Tests\TestCase;

class ConfigTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();

        config([
            'enums' => [
                ConfigurableEnum::class => [
                    'weight' => [
                        ConfigurableEnum::OPTION_ONE => 1,
                        ConfigurableEnum::OPTION_TWO => 2,
                    ],
                ],
            ],
        ]);
    }

    /**
     * Data provider for the test `testConfig`.
     *
     * @return array<mixed>
     */
    public function dataProvider(): array
    {
        return [
            [
                ConfigurableEnum::OPTION_ONE(),
                1,
            ],
            [
                ConfigurableEnum::OPTION_TWO(),
                2,
            ],
            [
                ConfigurableEnum::OPTION_THREE(),
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param \Sourceboat\Enumeration\Tests\ConfigurableEnum $configurable
     * @param int|null $expected
     * @return void
     */
    public function testConfig(ConfigurableEnum $configurable, ?int $expected): void
    {
        $this->assertEquals($expected, $configurable->config('weight'));
    }

    /**
     * Data provider for the test `testConfigWithDefault`.
     *
     * @return array<mixed>
     */
    public function dataProviderWithDefault(): array
    {
        return [
            [
                ConfigurableEnum::OPTION_ONE(),
                1,
            ],
            [
                ConfigurableEnum::OPTION_TWO(),
                2,
            ],
            [
                ConfigurableEnum::OPTION_THREE(),
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataProviderWithDefault
     * @param \Sourceboat\Enumeration\Tests\ConfigurableEnum $configurable
     * @param int|null $expected
     * @return void
     */
    public function testConfigWithDefault(ConfigurableEnum $configurable, ?int $expected): void
    {
        $this->assertNull($configurable->config('size'));
        $this->assertEquals($expected, $configurable->config('size', $expected));
    }

    public function testConfigPath(): void
    {
        $this->assertEquals('enums.' . ConfigurableEnum::class, ConfigurableEnum::configPath());
    }

    /**
     * Data provider for the test `testGetConfigKey`.
     *
     * @return array<mixed>
     */
    public function dataProviderGetConfigKey(): array
    {
        return [
            [
                ConfigurableEnum::OPTION_ONE(),
            ],
            [
                ConfigurableEnum::OPTION_TWO(),
            ],
            [
                ConfigurableEnum::OPTION_THREE(),
            ],
        ];
    }

    /**
     * @dataProvider dataProviderGetConfigKey
     * @param \Sourceboat\Enumeration\Tests\ConfigurableEnum $configurable
     * @return void
     */
    public function testGetConfigKey(ConfigurableEnum $configurable): void
    {
        $this->assertEquals(
            sprintf('enums.%s.weight.%s', ConfigurableEnum::class, $configurable->value()),
            $configurable->getConfigKey(ConfigurableEnum::configPath(), 'weight'),
        );
    }
}
