<?php
/**
 * Created by PhpStorm.
 * use ES\Kernel\r: use ES\Kernel\r
 * Date: 10.03.2018
 * Time: 20:14
 */

namespace ES\Kernel\ElasticSearch;

use ES\Kernel\ElasticSearch\QueryEndpoints\QueryTypesInterface;
use ES\Kernel\Configs\Config;
use ES\Kernel\ElasticSearch\QueryEndpoints\Sql;
use ES\Kernel\ElasticSearch\QueryOptions\ElasticQueryParams;
use ES\Kernel\ElasticSearch\QueryEndpoints\Bulk;
use ES\Kernel\ElasticSearch\QueryEndpoints\Index;
use ES\Kernel\ElasticSearch\QueryEndpoints\Insert;
use ES\Kernel\ElasticSearch\QueryEndpoints\Remove;
use ES\Kernel\ElasticSearch\QueryEndpoints\Search;
use ES\Kernel\ElasticSearch\QueryEndpoints\Select;
use ES\Kernel\ElasticSearch\QueryEndpoints\Update;
use ES\Kernel\ObjectMapper\ObjectMapper;
use ES\Kernel\Traits\SingletonTrait;

class ElasticSearch implements ElasticSearchInterface
{
	use SingletonTrait;

    /**
     * @var ElasticQueryParams
     */
    private $queryParamsObject = [];

    /**
     * @var ElasticQueryParams
     */
	private $currentQueryClass;

    /**
     * @var ElasticConnection
     */
	private $configConnection;

	/**
	 * @return ElasticConnection
	 * @throws \ES\Kernel\Exception\\ObjectException
	 */
	public function getConfigConnection(): ElasticConnection
    {
        if (!$this->configConnection instanceof ElasticConnection) {
            $this->configConnection = ObjectMapper::create()->arrayToObject(Config::get('elasticsearch'), ElasticConnection::class);
        }

        return $this->configConnection;
    }

	/**
	 * @return Select
	 */
	public function select(): Select
    {
        return $this->getQueryClass(QueryTypesInterface::SELECT);
    }

	/**
	 * @return Index
	 */
	public function index(): Index
    {
        return $this->getQueryClass(QueryTypesInterface::INDEX);
    }

    /**
     * @return Sql
     */
    public function sql(): Sql
    {
        return $this->getQueryClass(QueryTypesInterface::INDEX);
    }

	/**
	 * @return Update
	 */
	public function update(): Update
    {
        return $this->getQueryClass(QueryTypesInterface::UPDATE);
    }

	/**
	 * @return Search
	 */
	public function search(): Search
    {
        return $this->getQueryClass(QueryTypesInterface::SEARCH);
    }

	/**
	 * @return Remove
	 */
	public function remove(): Remove
    {
        return $this->getQueryClass(QueryTypesInterface::REMOVE);
    }

	/**
	 * @return Insert
	 */
	public function insert(): Insert
    {
        return $this->getQueryClass(QueryTypesInterface::INSERT);
    }

	/**
	 * @return Bulk
	 */
	public function bulk(): Bulk
    {
        return $this->getQueryClass(QueryTypesInterface::BULK);
    }

    /**
     * @return ElasticQueryParams
     */
    public function getCurrentQueryType(): ElasticQueryParams
    {
        return $this->currentQueryClass;
    }

    /**
     * @param string $queryClass
     * @return mixed
     */
    private function getQueryClass(string $queryClass)
    {
        if (!isset($this->queryParamsObject[$queryClass])) {
            $current = $this->queryParamsObject[$queryClass] = new $queryClass();
            $this->currentQueryClass = $current;
        }

        return $this->queryParamsObject[$queryClass];
    }
}