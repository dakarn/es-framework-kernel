<?php

namespace System;

use Configs\Config;

class Render
{
	/**
	 * @var string
	 */
	const PATH = TEMPLATE . '/';

	/**
	 * @var string
	 */
	private $template = '';

	/**
	 * @var array
	 */
	private $params = [];

	/**
	 * Render constructor.
	 * @param $template
	 * @param array $params
	 * @throws \Exception\FileException
	 */
	public function __construct($template, array $params = [])
	{
		if (!\file_exists(self::PATH . $template)) {
			$this->template = self::PATH . Config::get('common','errors')['404'];
		} else {
			$this->params   = $params;
			$this->template = self::PATH . $template;
		}
	}

	/**
	 * @return string
	 */
	public function render(): string
    {
        \extract($this->params);
        \ob_start();
        include $this->template;
        return \ob_get_clean();
	}
}