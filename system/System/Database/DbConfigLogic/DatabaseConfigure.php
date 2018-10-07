<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.03.2018
 * Time: 20:14
 */

namespace System\Database\DbConfigLogic;

class DatabaseConfigure
{
	/**
	 * @var WriterConf
	 */
	private $writer;

	/**
	 * @var ReaderConf[]
	 */
	private $readersList;

	/**
	 * @var OneInstanceConf
	 */
	private $defaultInstance;

	/**
	 * @var bool
	 */
	private $isOneInstance = false;

    /**
     * DatabaseConfigure constructor.
     * @param array $config
     */
	public function __construct(array $config)
	{
		if (!empty($config['oneInstance'])) {
			$this->defaultInstance = new OneInstanceConf($config['oneInstance']);
			$this->isOneInstance   = true;
			return;
		}

		$this->writer  = new WriterConf($config['write']);

		$this->readersList = new ReaderConfList();

		foreach ($config['read'] as $index => $item) {
			$this->readersList->add($index, new ReaderConf($item));
		}
	}

	/**
	 * @return bool
	 */
	public function isOneInstance(): bool
	{
		return $this->isOneInstance;
	}

	/**
	 * @return WriterConf
	 */
	public function getWriter(): WriterConf
	{
		return $this->writer;
	}

	/**
	 * @return OneInstanceConf
	 */
	public function getDefaultInstance(): OneInstanceConf
	{
		return $this->defaultInstance;
	}

	/**
	 * @return ReaderConfList
	 */
	public function getReadersList(): ReaderConfList
	{
		return $this->readersList;
	}
}