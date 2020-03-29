<?php

namespace Sourceboat\Enumeration\Enums\Interfaces;

interface Configurable
{
    /**
     * Get the config value for this enum member.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function config(string $key, $default);
}
