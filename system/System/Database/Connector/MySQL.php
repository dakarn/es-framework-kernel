<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 0:35
 */

namespace System\Database\Connector;

use System\Database\DB;
use System\Database\DbConfigLogic\DbConfig;
use System\Database\DbConfigLogic\Reader;
use System\Database\DbConfigLogic\Writer;

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
	 * @var Reader[]
	 */
	private $readersConfig = [];

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
		return $this->writer;
	}

	/**
	 * @param int $num
	 * @return mixed
	 * @throws \Exception
	 */
	public function getReader(int $num = 0): \mysqli
	{
		if (!$this->reader instanceof \mysqli) {
			$this->initReader($num);
		}

		return $this->reader;
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

			\mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

			$this->reader = new \mysqli(
				$this->readersConfig[$num]->getHost(),
				$this->readersConfig[$num]->getUser(),
				$this->readersConfig[$num]->getPassword(),
				$this->readersConfig[$num]->getDatabase()
			);

			$this->writer->set_charset($this->readersConfig[$num]->getCharset());
		} catch (\mysqli_sql_exception $e) {
			if ($this->tryReconnectReader === $this->amountReaders - 1) {
				throw $e;
			}

			$this->tryReconnectReader++;
			$this->initReader($this->tryReconnectReader);
		}
	}

	private function initWriter()
	{
		$conf = DbConfig::create()->getConfigure(DB::MYSQL);

		/** @var Writer $writer */
		$writer  = $conf['write'];
		$readers = $conf['read'];

		try {
			$this->amountReaders = \count($readers);

			\mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

			$this->writer = new \mysqli(
				$writer->getHost(),
				$writer->getUser(),
				$writer->getPassword(),
				$writer->getDatabase()
			);

			$this->writer->set_charset($writer->getCharset());
		} catch (\mysqli_sql_exception $e) {
			throw $e;
		}

		/** @var Reader $reader */
		foreach ($readers as $reader) {
			$this->readersConfig[] = $reader;
		}
	}
}