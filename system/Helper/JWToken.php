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
	private const HEADER = [
		'alg' => 'HS256',
		'typ' => 'JWT',
	];

	private $payload = [

	];

	private static $token = '';

	public static function getToken(): string
	{
		return self::$token;
	}

	public static function verifyToken()
	{

	}

	public static function isValid(): bool
	{
		return true;
	}

	public static function generateToken()
	{

	}

	public static function decode()
	{

	}
}