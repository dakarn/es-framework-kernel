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

	/**
	 * @var DatabaseConfigure
	 */
	private $dbConfigs = [];

	/**
	 * @param string $dbType
	 * @param DatabaseConfigure $databaseConfigure
	 * @return DbConfig
	 */
	public function setConfigure(string $dbType, DatabaseConfigure $databaseConfigure): self
	{
		$this->dbConfigs[$dbType]['read']  = $databaseConfigure;
		$this->dbConfigs[$dbType]['write'] = $databaseConfigure;

		return $this;
	}

	/**
	 * @param string $dbType
	 * @return DatabaseConfigure[]
	 */
	public function getConfigure(string $dbType): array
	{
		if (empty($this->dbConfigs[$dbType])) {
			throw new \DomainException('Such DbConfig not exist.');
		}

		return $this->dbConfigs[$dbType];
	}
}