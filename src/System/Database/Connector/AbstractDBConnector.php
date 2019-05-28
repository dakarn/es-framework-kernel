<?php

namespace ES\Kernel\System\Database\Connector;

use ES\Kernel\System\Database\DbConfigLogic\ReaderConfList;

abstract class AbstractDBConnector
{
    /**
     * MySQL constructor.
     * @param string $database
     * @throws \Exception
     */
    public function __construct(string $database)
    {
        $this->database = $database;
        $this->initWriter();
    }

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
    private $writer;

    /**
     * @var mixed
     */
    private $reader;

    /**
     * @var mixed
     */
    private $oneInstance;

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
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * @return mixed
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param mixed $writer
     * @return AbstractDBConnector
     */
    public function setWriter($writer): self
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * @param mixed $reader
     * @return AbstractDBConnector
     */
    public function setReader($reader): self
    {
        $this->reader = $reader;

        return $this;
    }

    abstract protected function initWriter();
    abstract protected function initReader(int $num);
}