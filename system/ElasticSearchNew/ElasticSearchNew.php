<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.2018
 * Time: 20:14
 */

namespace ElasticSearchNew;

use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryTypes\QueryTypesInterface;
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
     * @return ElasticQueryParams
     */
    public function select(): ElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::SELECT);
    }

    /**
     * @return ElasticQueryParams
     */
    public function index(): ElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::INDEX);
    }

    /**
     * @return ElasticQueryParams
     */
    public function update(): ElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::UPDATE);
    }

    /**
     * @return ElasticQueryParams
     */
    public function search(): ElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::SEARCH);
    }

    /**
     * @return ElasticQueryParams
     */
    public function remove(): ElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::REMOVE);
    }

    /**
     * @return ElasticQueryParams
     */
    public function insert(): ElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::INSERT);
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
        if (!$this->queryParamsObject[$queryClass] instanceof ElasticQueryParams) {
            $this->queryParamsObject[$queryClass] = new $queryClass();
        }

        return $this->queryParamsObject[$queryClass];
    }
}