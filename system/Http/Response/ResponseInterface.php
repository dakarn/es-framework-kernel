<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.04.2018
 * Time: 22:59
 */

namespace Http\Response;

interface ResponseInterface
{
	public function render($data, array $param);
}