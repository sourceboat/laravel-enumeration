<?php

namespace Sourceboat\Enumeration\Tests;

use Sourceboat\Enumeration\Enumeration;

/**
 * @method static self MODERATOR()
 * @method static self ADMIN()
 * @method static self SUPER_ADMIN()
 * @method static self USER()
 * @method bool isModerator()
 * @method bool isAdmin()
 * @method bool isSuper_Admin()
 * @method bool isUser()
 */
class UserRole extends Enumeration
{
    public const MODERATOR = 'moderator';
    public const ADMIN = 'admin';
    public const SUPER_ADMIN = 'super_admin';
    public const USER = 'user';
}
