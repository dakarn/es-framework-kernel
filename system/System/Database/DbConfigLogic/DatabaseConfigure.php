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
	private $readers;

	/**
	 * @var DefaultInstanceConf
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
		if (!empty($config[0])) {
			$this->defaultInstance = new DefaultInstanceConf($config[0]);
			$this->isOneInstance   = true;
			return;
		}

		$this->writer  = new WriterConf($config['write']);

		foreach ($config['read'] as $item) {
			$this->readers[] = new ReaderConf($item);
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
	 * @return DefaultInstanceConf
	 */
	public function getDefaultInstance(): DefaultInstanceConf
	{
		return $this->defaultInstance;
	}

	/**
	 * @return ReaderConf[]
	 */
	public function getReaders(): array
	{
		return $this->readers;
	}
}