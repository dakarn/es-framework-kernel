<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 18:20
 */

namespace System\Database;

use Traits\SingletonTrait;

class DbConfig
{
	use SingletonTrait;

	private $dbConfigs = [];

	public function setConfigure(string $dbType, DatabaseConfigure $databaseConfigure): self
	{
		$this->dbConfigs[$dbType]['read']  = $databaseConfigure['read'];
		$this->dbConfigs[$dbType]['write'] = $databaseConfigure['write'];

		return $this;
	}
}