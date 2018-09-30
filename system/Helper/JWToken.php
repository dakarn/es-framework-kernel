<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:17
 */

namespace Helper;

class JWToken
{
	private static $token = '';

	public static function getToken(): string
	{
		return self::$token;
	}

	public static function verifyToken()
	{

	}

	public static function generateToken()
	{

	}

	public static function decode()
	{

	}
}