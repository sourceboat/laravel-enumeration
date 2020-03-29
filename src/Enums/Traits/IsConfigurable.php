<?php

namespace Sourceboat\Enumeration\Enums\Traits;

/**
 * This trait allows you to shortcut to config options for your enums dynamically based on the member.
 *
 * This trait implements the `Configurable`-interface.
 */
trait IsConfigurable
{
    /**
     * Get the config path for this enum.
     *
     * @return string
     */
    public static function configPath(): string
    {
        return sprintf('enums.%s', static::class);
    }

    /**
     * Get the config key from this enum for the given path and subkey.
     *
     * @param  string $path
     * @param  string $subKey
     * @return string
     */
    public function getConfigKey(string $path, string $subKey): string
    {
        return sprintf('%s.%s.%s', $path, $subKey, $this->value());
    }

    /**
     * get the config value for this.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function config(string $key, $default = null)
    {
        return config($this->getConfigKey(static::configPath(), $key), $default);
    }
}
