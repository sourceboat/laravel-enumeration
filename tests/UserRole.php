<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Enumeration;

/**
 * @method static \Sourceboat\Enumeration\Tests\UserRole MODERATOR()
 * @method static \Sourceboat\Enumeration\Tests\UserRole ADMIN()
 * @method static \Sourceboat\Enumeration\Tests\UserRole SUPER_ADMIN()
 * @method static \Sourceboat\Enumeration\Tests\UserRole USER()
 */
class UserRole extends Enumeration
{
    public const MODERATOR = 'moderator';
    public const ADMIN = 'admin';
    public const SUPER_ADMIN = 'super_admin';
    public const USER = 'user';
}
