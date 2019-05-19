<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2018
 * Time: 18:06
 */

namespace ES\Kernel\System\Database\Connector;


interface DBConnectorInterface
{
	/**
	 * @return mixed
	 */
	public function getWriter();

	/**
	 * @param int $num
	 * @return mixed
	 * @throws \Exception
	 */
	public function getReader(int $num = 0);
}