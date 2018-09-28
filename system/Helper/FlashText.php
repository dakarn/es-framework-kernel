<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.03.2018
 * Time: 16:16
 */

namespace Helper;

use Http\Request\Request;

class FlashText
{
	public static function add(string $type, string $text)
	{
		$session = Request::create()->getSession();
		$flash   = $session->getAsArray('flashText');

		$flash[count($flash)] = [
			'type' => $type,
			'text' => $text
		];

		$session->set('flashText', $flash);
	}

	public static function has(): bool
	{
		if (!empty(Request::create()->getSession()->has('flashText'))) {
			return false;
		}

		return false;
	}

	public static function hasByType(string $type): bool
	{
		$sessions = Request::create()->getSession()->getAsArray('flashText');

		foreach ($sessions as $session) {
			if ($session['type'] === $type) {
				return true;
			}
		}

		return false;
	}

	public static function get(string $type): array
	{
		$response = [];
		$sessions = Request::create()->getSession()->getAsArray('flashText');

		foreach ($sessions as $session) {
			if ($session['type'] === $type) {
				$response[] = $session['text'];
			}
		}

		return $response;
	}

	public static function render()
	{
		$session = Request::create()->getSession();
		$data    = $session->getAsArray('flashText');
		$session->delete('flashText');

		FlashTextRender::render($data);
	}

	public static function remove()
	{
		Request::create()
			->getSession()
			->delete('flashText');
	}
}