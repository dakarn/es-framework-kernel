<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 08.11.2018
 * Time: 13:46
 */

namespace ES\Kernel\Helper;

interface ContainerInterface
{
    /**
     * @param string $class
     * @return mixed
     */
    public static function get(string $class);

    /**
     * @param string $class
     * @return bool
     */
    public static function has(string $class): bool;

    /**
     * @param string $name
     * @param $class
     * @return bool
     */
    public static function set(string $name, $class): bool;
}