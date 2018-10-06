<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.10.2018
 * Time: 2:19
 */

namespace System;

interface RenderInterface
{
	/**
	 * Render constructor.
	 * @param $template
	 * @param array $params
	 * @throws \Exception\FileException
	 */
	public function __construct($template, array $params = []);

	/**
	 * @return string
	 * @throws \Exception\FileException
	 */
	public function render(): string;
}