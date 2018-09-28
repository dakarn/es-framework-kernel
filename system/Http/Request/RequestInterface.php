<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.2018
 * Time: 22:30
 */

namespace Http\Request;

interface RequestInterface
{
	public function getMethod(): string;
}