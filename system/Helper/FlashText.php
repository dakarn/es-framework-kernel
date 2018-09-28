<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 16:16
 */

namespace Helper;

use Http\Session;

class FlashText
{
	/**
	 * @param string $type
	 * @param string $text
	 */
	public static function add(string $type, string $text): void
	{
		$session = Session::create();
		$flash   = $session->getAsArray('flashText');

		$flash[count($flash)] = [
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
		if (!empty(Session::create()->has('flashText'))) {
			return false;
		}

		return false;
	}

	/**
	 * @param string $type
	 * @return bool
	 */
	public static function hasByType(string $type): bool
	{
		$sessions = Session::create()->getAsArray('flashText');

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
		$sessions = Session::create()->getAsArray('flashText');

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
		$session = Session::create();
		$data    = $session->getAsArray('flashText');
		$session->delete('flashText');

		FlashTextRender::render($data);
	}

	/**
	 * @return bool
	 */
	public static function remove(): bool
	{
		Session::create()->delete('flashText');
	    return true;
	}
}