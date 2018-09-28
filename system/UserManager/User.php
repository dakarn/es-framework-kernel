<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.04.2018
 * Time: 15:45
 */

namespace UserManager;

final class User
{
    /**
     * @var UserManagerInterface
     */
    private static $userManager;

    /**
     * @return UserManagerInterface
     */
    public static function load(): UserManagerInterface
    {
        if (!self::$userManager instanceof UserManager) {
            self::$userManager = new UserManager();
        }

        return self::$userManager;
    }
}