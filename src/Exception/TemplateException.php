<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 17:53
 */

namespace ES\Kernel\Exception;

class TemplateException extends \Exception
{
	/**
	 * @param array $arguments
	 * @return TemplateException
	 */
	public static function notFound(array $arguments = []): self
	{
		return new self('');
	}
}