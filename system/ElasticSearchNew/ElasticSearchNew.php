<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.2018
 * Time: 20:14
 */

namespace ElasticSearchNew;

use Configs\Config;
use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryEndpoints\Bulk;
use ElasticSearchNew\QueryEndpoints\Index;
use ElasticSearchNew\QueryEndpoints\Insert;
use ElasticSearchNew\QueryEndpoints\QueryTypesInterface;
use ElasticSearchNew\QueryEndpoints\Remove;
use ElasticSearchNew\QueryEndpoints\Search;
use ElasticSearchNew\QueryEndpoints\Select;
use ElasticSearchNew\QueryEndpoints\Update;
use Traits\SingletonTrait;

class ElasticSearchNew implements ElasticSearchNewInterface
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
	 * @throws \Exception\FileException
	 */
	public function getConfigConnection(): ElasticConnection
    {
        if (!$this->configConnection instanceof ElasticConnection) {

            $config = Config::get('elasticsearch');

            $this->configConnection = new ElasticConnection();
            $this->configConnection->setSchema($config['schema']);
            $this->configConnection->setPort($config['port']);
            $this->configConnection->setHost($config['host']);
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