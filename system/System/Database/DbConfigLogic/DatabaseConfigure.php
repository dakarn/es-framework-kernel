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
	 * @var Writer
	 */
	private $writer;

	/**
	 * @var Reader[]
	 */
	private $readers;

    /**
     * DatabaseConfigure constructor.
     * @param array $config
     */
	public function __construct(array $config)
	{
		$this->writer  = new Writer($config['write']);

		foreach ($config['read'] as $item) {
			$this->readers[] = new Reader($item);
		}
	}

	/**
	 * @return Writer
	 */
	public function getWriter(): Writer
	{
		return $this->writer;
	}

	/**
	 * @return Reader[]
	 */
	public function getReaders(): array
	{
		return $this->readers;
	}
}