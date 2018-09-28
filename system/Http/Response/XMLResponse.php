<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 28.03.2018
 * Time: 12:38
 */

namespace Http\Response;

class XMLResponse implements ResponseInterface
{
	public function render($data, array $param)
	{
		echo $data;
	}
}