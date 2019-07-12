<?php

namespace ES\Kernel\Database\Connector;

use ES\Kernel\Database\DbConfigLogic\ReaderConfList;

abstract class AbstractDBConnector
{
    /**
     * @var ReaderConfList
     */
    protected $readersConfigList;

    /**
     * @var int
     */
    protected $amountReaders = 0;

    /**
     * @var int
     */
    protected $tryReconnectReader = 0;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var mixed
     */
    private $master;

    /**
     * @var mixed
     */
    private $slave;

    /**
     * @var mixed
     */
    private $oneInstance;

	/**
	 * MySQL constructor.
	 * @param string $database
	 * @throws \Exception
	 */
	public function __construct(string $database)
	{
		$this->database = $database;
		$this->initMaster();
	}

    /**
     * @return mixed
     */
    public function getOneInstance()
    {
        return $this->oneInstance;
    }

    /**
     * @param mixed $oneInstance
     * @return AbstractDBConnector
     */
    public function setOneInstance($oneInstance): self
    {
        $this->oneInstance = $oneInstance;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
     * @return mixed
     */
    public function getSlave()
    {
        return $this->slave;
    }

    /**
     * @param mixed $writer
     * @return AbstractDBConnector
     */
    public function setMaster($writer): self
    {
        $this->master = $writer;

        return $this;
    }

    /**
     * @param mixed $reader
     * @return AbstractDBConnector
     */
    public function setSlave($reader): self
    {
        $this->slave = $reader;

        return $this;
    }

    abstract protected function initMaster();
    abstract protected function initSlave(int $num);
}