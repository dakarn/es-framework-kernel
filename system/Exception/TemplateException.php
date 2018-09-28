<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 17:53
 */

namespace Exception;

class TemplateException extends \Exception
{
	public static function notFound(array $arguments = []): self
	{
		return new self('');
	}
}