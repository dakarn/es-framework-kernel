<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.2018
 * Time: 18:34
 */

namespace ES\Kernel\Helper;

use ES\Kernel\Configs\Config;

class FlashTextRender
{
	/**
	 * @param array $items
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function render(array $items = [])
	{
		$flashText = self::getConfigFlash();
		$bigText   = $flashText['isBigText'] ? '<b>%s</b>' : '%s';

		foreach ($items as $item) {
			echo \sprintf($flashText['cssStart'] . $bigText, $item['type'], $item['text']) . $flashText['cssEnd'];
		}
	}

	/**
	 * @return array
	 * @throws \ES\Kernel\Exception\FileException
	 */
	private static function getConfigFlash(): array
	{
		return Config::get('common', 'flashText');
	}
}