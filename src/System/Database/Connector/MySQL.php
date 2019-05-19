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

class MySQL implements DBConnectorInterface
{
	/**
	 * @var \mysqli
	 */
	private $writer;

	/**
	 * @var \mysqli
	 */
	private $reader;

	/**
	 * @var \mysqli
	 */
	private $defaultInstance;

	/**
	 * @var ReaderConfList
	 */
	private $readersConfigList;

	/**
	 * @var int
	 */
	private $amountReaders = 0;

	/**
	 * @var int
	 */
	private $tryReconnectReader = 0;

	/**
	 * MySQL constructor.
	 * @throws \Exception
	 */
	public function __construct()
	{
		$this->initWriter();
	}

	/**
	 * @return \mysqli
	 */
	public function getWriter(): \mysqli
	{
		return $this->defaultInstance ?? $this->writer;
	}

	/**
	 * @param int $num
	 * @return mixed
	 * @throws \Exception
	 */
	public function getReader(int $num = 0): \mysqli
	{
		if ($this->defaultInstance !== null) {
			return $this->defaultInstance;
		}

		if (!$this->reader instanceof \mysqli) {
			$this->initReader($num);
		}

		return $this->reader;
	}

	/**
	 * @param OneInstanceConf $conf
	 * @throws \Exception
	 */
	private function initDefault(OneInstanceConf $conf)
	{
		try {
			$this->defaultInstance = $this->connect($conf);
		} catch (\mysqli_sql_exception $e) {
			throw $e;
		}
	}

	/**
	 * @param int $num
	 * @throws \Exception
	 */
	private function initReader(int $num)
	{
		try {
			if (empty($num)) {
				$num = \random_int(0, $this->amountReaders - 1);
			}

			$this->reader = $this->connect($this->readersConfigList->get($num));
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
	private function initWriter()
	{
		$conf = DbConfig::create()->getConfigure(DB::MYSQL);

		if (!empty($conf['oneInstance'])) {
			$this->initDefault($conf['oneInstance']);
			return;
		}

		/** @var ReaderConfList $readersConf */
		$this->readersConfigList = $conf['read'];
		$this->amountReaders = $this->readersConfigList->count();

		try {
			$this->writer = $this->connect($conf['write']);
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
			$conf->getDatabase()
		);

		$mysqli->set_charset($conf->getCharset());

		return $mysqli;
	}
}