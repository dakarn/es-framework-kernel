<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 16:16
 */

namespace Helper;

use Http\Session\SessionRedis;
use Http\Session\SessionSimple;
use Http\Session\Strategy\RedisStrategy;
use Http\Session\Strategy\SimpleSessionStrategy;

class FlashText
{
	public const MSG_DANGER  = 'danger';
	public const MSG_SUCCESS = 'success';
	public const MSG_ALERT   = 'alert';
	public const MSG_WARNING = 'warning';
	public const MSG_PRIMARY = 'primary';
	public const NSG_DARK    = 'dark';
	public const MSG_INFO    = 'info';
	public const MSG_LIGHT   = 'light';

	/**
	 * @param string $type
	 * @param string $text
	 */
	public static function add(string $type, string $text): void
	{
		$session = self::getSession();
		$flash   = $session->getAsArray('flashText');

		$flash[\count($flash)] = [
			'type' => $type,
			'text' => $text
		];

		$session->set('flashText', $flash);
	}

	/**
	 * @return bool
	 */
	public static function has(): bool
	{
		if (!empty( self::getSession()->has('flashText'))) {
			return false;
		}

		return false;
	}

	/**
	 * @param array $types
	 * @return bool
	 */
	public static function hasByTypes(array $types): bool
	{
		$sessions =  self::getSession()->getAsArray('flashText');

		foreach ($sessions as $session) {
			if (\in_array($session['type'], $types)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	public static function hasByType(string $type): bool
	{
		$sessions =  self::getSession()->getAsArray('flashText');

		foreach ($sessions as $session) {
			if ($session['type'] === $type) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param string $type
	 * @return array
	 */
	public static function get(string $type): array
	{
		$response = [];
		$sessions =  self::getSession()->getAsArray('flashText');

		foreach ($sessions as $session) {
			if ($session['type'] === $type) {
				$response[] = $session['text'];
			}
		}

		return $response;
	}

	/**
	 * @return void
	 */
	public static function render()
	{
		$session =  self::getSession();
		$data    = $session->getAsArray('flashText');
		$session->delete('flashText');

		FlashTextRender::render($data);
	}

	/**
	 * @return bool
	 */
	public static function remove(): bool
	{
		self::getSession()->delete('flashText');
	    return true;
	}

	/**
	 * @return SimpleSessionStrategy
	 */
	private static function getSession(): SimpleSessionStrategy
	{
		return SessionSimple::create();
	}
}