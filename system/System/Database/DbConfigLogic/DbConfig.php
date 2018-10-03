<?php

namespace System\Database\DbConfigLogic;

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
		$this->dbConfigs[$dbType]['read']  = $databaseConfigure->getReaders();
		$this->dbConfigs[$dbType]['write'] = $databaseConfigure->getWriter();

		return $this;
	}

	/**
	 * @param string $dbType
	 * @return array
	 */
	public function getConfigure(string $dbType): array
	{
		if (empty($this->dbConfigs[$dbType])) {
			throw new \DomainException('Such DbConfig not exist.');
		}

		return $this->dbConfigs[$dbType];
	}
}