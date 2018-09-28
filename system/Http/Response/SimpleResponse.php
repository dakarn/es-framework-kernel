<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 0:53
 */

namespace Http\Response;

class SimpleResponse implements ResponseInterface
{
	public function render($data, array $param)
	{
		echo $data;
	}
}