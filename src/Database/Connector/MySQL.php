<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:35
 */

namespace ES\Kernel\Database\Connector;

use ES\Kernel\Database\DB;
use ES\Kernel\Database\DbConfigLogic\DbConfig;
use ES\Kernel\Database\DbConfigLogic\OneInstanceConf;
use ES\Kernel\Database\DbConfigLogic\ReaderConfList;

class MySQL extends AbstractDBConnector implements DBConnectorInterface
{
	/**
	 * @return \mysqli
	 */
	public function getMaster(): \mysqli
	{
		return $this->getOneInstance() ?? $this->getMaster();
	}

	/**
	 * @param int $num
	 * @return mixed
	 * @throws \Exception
	 */
	public function getSlave(int $num = 0): \mysqli
	{
		if ($this->getOneInstance() !== null) {
			return $this->getOneInstance();
		}

		if (!$this->getSlave() instanceof \mysqli) {
			$this->initSlave($num);
		}

		return $this->getSlave();
	}

	/**
	 * @param OneInstanceConf $conf
	 * @throws \Exception
	 */
	private function initOneInstance(OneInstanceConf $conf)
	{
		try {
			$this->setOneInstance($this->connect($conf));
		} catch (\mysqli_sql_exception $e) {
			throw $e;
		}
	}

	/**
	 * @param int $num
	 * @throws \Exception
	 */
	protected function initSlave(int $num)
	{
		try {
			if (empty($num)) {
				$num = \rand(0, $this->amountReaders - 1);
			}

			$this->setSlave($this->connect($this->readersConfigList->get($num)));
		} catch (\mysqli_sql_exception $e) {
			if ($this->tryReconnectReader === $this->amountReaders - 1) {
				throw $e;
			}

			$this->tryReconnectReader++;
			$this->initSlave($this->tryReconnectReader);
		}
	}

	/**
	 * @throws \Exception
	 */
	protected function initMaster()
	{
		$conf = DbConfig::create()->getConfigure(DB::MYSQL);

		if (!empty($conf['oneInstance'])) {
			$this->initOneInstance($conf['oneInstance']);
			return;
		}

		/** @var ReaderConfList $readersConf */
		$this->readersConfigList = $conf['read'];
		$this->amountReaders = $this->readersConfigList->count();

		try {
			$this->setMaster($this->connect($conf['write']));
		} catch (\mysqli_sql_exception $e) {
			throw $e;
		}
	}

	/**
	 * @param OneInstanceConf $conf
	 * @return \mysqli
	 */
	private function connect(OneInstanceConf $conf): \mysqli
	{
		\mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

		$mysqli = new \mysqli(
			$conf->getHost(),
			$conf->getUser(),
			$conf->getPassword(),
			$this->database
		);

		$mysqli->set_charset($conf->getCharset());

		return $mysqli;
	}
}