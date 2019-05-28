<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:35
 */

namespace ES\Kernel\System\Database\Connector;

use ES\Kernel\System\Database\DB;
use ES\Kernel\System\Database\DbConfigLogic\DbConfig;
use ES\Kernel\System\Database\DbConfigLogic\OneInstanceConf;
use ES\Kernel\System\Database\DbConfigLogic\ReaderConfList;

class MySQL extends AbstractDBConnector implements DBConnectorInterface
{
    /**
     * @return \mysqli
     */
    public function getWriter(): \mysqli
    {
        return $this->getOneInstance() ?? $this->getWriter();
    }

	/**
	 * @param int $num
	 * @return mixed
	 * @throws \Exception
	 */
	public function getReader(int $num = 0): \mysqli
	{
		if ($this->getOneInstance() !== null) {
			return $this->getOneInstance();
		}

		if (!$this->getReader() instanceof \mysqli) {
			$this->initReader($num);
		}

		return $this->getReader();
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
	protected function initReader(int $num)
	{
		try {
			if (empty($num)) {
				$num = \rand(0, $this->amountReaders - 1);
			}

			$this->setReader($this->connect($this->readersConfigList->get($num)));
		} catch (\mysqli_sql_exception $e) {
			if ($this->tryReconnectReader === $this->amountReaders - 1) {
				throw $e;
			}

			$this->tryReconnectReader++;
			$this->initReader($this->tryReconnectReader);
		}
	}

	/**
	 * @throws \Exception
	 */
	protected function initWriter()
	{
		$conf = DbConfig::create()->getConfigure(DB::MYSQL)[$this->database];

		if (!empty($conf['oneInstance'])) {
			$this->initOneInstance($conf['oneInstance']);
			return;
		}

		/** @var ReaderConfList $readersConf */
		$this->readersConfigList = $conf['read'];
		$this->amountReaders = $this->readersConfigList->count();

		try {
			$this->setWriter($this->connect($conf['write']));
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